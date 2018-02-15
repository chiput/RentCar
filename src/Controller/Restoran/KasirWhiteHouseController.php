<?php

namespace App\Controller\Restoran;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Resmenu;
use App\Model\Reskategori;
use App\Model\Barang;
use App\Model\Account;
use App\Model\Resmenudetail;
use App\Model\Brgsatuan;
use App\Model\Konversi;
use App\Model\Reswaiter;
use App\Model\Reskasirku;
use App\Model\Reskasirkudetail;
use App\Model\Option;
use Kulkul\Options;
use App\Model\Addcharge;
use App\Model\Addchargedetail;
use App\Model\Gudpakai;
use App\Model\Gudpakaidetail;
use App\Model\Reservationdetail;
use App\Model\Creditcard;
use App\Model\Accjurnal;
use App\Model\Accjurnaldetail;
use Kulkul\Accounting\AccountingServiceProvider;
use Kulkul\LogisticStock\LogisticStockProvider; 
use Kulkul\CurrencyFormater\FormaterAdapter;
use App\Model\Setupgudang;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Capsule\Manager as DB;

class KasirWhiteHouseController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {

        $data['app_profile'] = $this->app_profile;
        $data['Menus'] = Reskasirku::orderby('id','desc')->where('resto','=',2)->where('reskasirku.users_id','=',$this->session->get('activeUser')["id"])->get();

        return $this->renderer->render($response, 'restoran/kasirwhitehouse', $data);
    }

    public function GenericNoBukti($NoBukti){
        $repalgs= $this->db->table('reskasirku')->where('resto','=',2)->get();
        if ($NoBukti<10){
            $NoBuktitext="001".$NoBukti++;
        }else if ($NoBukti<100){
            $NoBuktitext="01".$NoBukti++;
        }else if ($NoBukti<1000){
            $NoBuktitext="1".$NoBukti++;
        }
        else if ($NoBukti<10000){
            $NoBuktitext=$NoBukti++;
        }
        $status=true;
         foreach ($repalgs as $reskasir ) {
            if(strtolower($reskasir->nobukti)==strtolower("WH.".date('y').date('m').$NoBuktitext)){
                //$NoBukti++;
                $status=false;
            }
        }
        if(!$status){
           return $this->GenericNoBukti($NoBukti);
        }
        else{
            return "WH.".date('y').date('m').$NoBuktitext ;
        }
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data['errors'] = $this->session->getFlash('error_messages');
        $data['creditcards'] = Creditcard::all();

        if (isset($args['id'])){
            $data['reskasirku'] = Reskasirku::find($args['id']);
            $data['Reskasirkudetail'] = $this->db->table('reskasirkudetail')
                                ->join('resmenu', 'resmenu.id', '=', 'reskasirkudetail.menuid')
                                ->select('reskasirkudetail.*','resmenu.nama as namamenu','resmenu.kode as kodemenu','reskasirkudetail.kuantitas')
                                ->where('reskasirkudetail.reskasirku_id','=',$args['id'])->get();
            $data['iids'] = $args['id'];
            $data['check'] = 1;

        } else {

            if($request->isPost()){        
                $date=$postData["date"];
            }else{
                $date=date("Y-m-d");
            }

            $data['check'] = 0;
            $data["date"]=$date;

            $data['NoBukti'] =$this->GenericNoBukti(count($this->db->table('reskasirku')->where('resto','=',2)->get()));
        }

        $data['Menus'] = $this->db->table('resmenu')
                        ->join('reskategori','resmenu.kategoriid','=','reskategori.id')
                         ->select('resmenu.*','reskategori.nama as namakategori' )
                         ->where('resmenu.aktif','=',1)
                        ->get()->sortByDesc("created_at");
        $data['waiters'] = Reswaiter::all();
        $data['Rooms'] = Reservationdetail::where("checkin_at","!=", null)
                                            ->where("checkout_at","=",null)
                                            ->get();

        

        return $this->renderer->render($response, 'restoran/kasirwhitehouse-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

         function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }

        // validation
        $this->validation->validate([
            'meja|Meja' => [$postData['meja'], 'required'],
            'kapasitas|Pax' => [$postData['kapasitas'], 'required'],
            'waiter|Waiter' => [$postData['waiter'], 'required'],
            'qty|Kuantitas' => [$postData['qty'], 'required'],
            'menu|Pilih Menu' => [$postData['menu'], 'required']
        ]);
        
        if (!$this->validation->passes()) {
            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('kasirwh-add'));
            } else {
                return $response->withRedirect($this->router->pathFor('kasirwh-edit',['id' => $postData['id']]));
            }
        }
        
        if (preg_match('/[^-_@. 0-9A-Za-z]/',$postData['meja'])) { 

            $this->session->setFlash('error_messages', array('Inputan Meja Tidak Valid'));

            if($postData['zid'] == ""){
                return $response->withRedirect($this->router->pathFor('kasirwh-add'));
            } else {
                return $response->withRedirect($this->router->pathFor('kasirwh-edit',['id'=>$postData['zid']]));
            }
        }

        $gudnya2 = Gudpakai::where("keterangan",'=','pemakaian barang pada restoran dengan bill '.$postData['nobukti'])->delete();
        $gudnya3 = Gudpakaidetail::where('gudpakai_id','=',$gudnya2->id)->delete();
        $setgud = Setupgudang::where('name','gud_whitehorse')->first();
        //Pemakaian Barang
        $usage = Gudpakai::where(DB::raw('left(nobukti,7)'), '=', 'PB.'.date('ym'))
                                ->orderBy('nobukti',"desc")->first();
        $usagebukti = 'PB.'.date('ym').substr('0000'.(substr($usage->nobukti,-4)*1+1),-4);

        $gud = new Gudpakai;
        $gud->tanggal = convert_date($postData['date']);
        $gud->nobukti = $usagebukti;
        $gud->gudang_id = $setgud->value;
        $gud->accjurnal_id = 0;
        $gud->keterangan = 'pemakaian barang pada restoran dengan bill '.$postData['nobukti'];
        $gud->users_id = $this->session->get('activeUser')["id"];
        $gud->save();

        $barang = [];

        foreach ($postData["ids"] as $key => $menu) {
            echo $postData['ids'][$key];
            $barang = Resmenudetail::where('id2','=',$postData['ids'][$key])->get();
            foreach ($barang as $keys) {
                $gudet = new Gudpakaidetail;
                $gudet->gudpakai_id = $gud->id;
                $gudet->barang_id = $keys->barangid;
                $gudet->satuan_id = $keys->satuanid;
                $gudet->account_id = 0;
                $gudet->kuantitas = $keys->kuantitas*$postData['qty'][$key];
                $gudet->save();
            }
        }


        //Restoran
        if(isset($postData['diskon'])){
            $diskon = $postData['totalnya'] * $postData['diskon'] / 100;
            $postData['totalnya'] = $postData['totalnya'] - $diskon;
        }

        if($postData['cash'] != 0 || $postData['totalcreditcard'] != 0){
            $jurnal_id =$this->post_jurnal($postData);
        }

        if($postData['cash'] == 0 && $postData['totalcreditcard'] == 0 && $postData['nokamarid'] == ""){
            $jurnal_id =$this->post_jurnal($postData);
        }


        if ($postData['checks']=="0"){


            $reskasirku = new Reskasirku();
            $reskasirku->jurnalid = $jurnal_id;
            $reskasirku->tanggal = convert_date($postData['date']);
            $reskasirku->nobukti = $postData['nobukti'];
            $reskasirku->meja = $postData['meja'];
            $reskasirku->pax = $postData['kapasitas'];
            $reskasirku->waiters_id = $postData['waiter'];
            $reskasirku->total = FormaterAdapter::reverse($postData['totalnya']);
            $reskasirku->keterangan = $postData['keterangan'];
            if($postData['pembayaran'] > 0){
                $reskasirku->bayar = FormaterAdapter::reverse($postData['pembayaran']);
            } else {
                $reskasirku->bayar = FormaterAdapter::reverse($postData['totalnya']);
            }
            //$reskasirku->kembalian = FormaterAdapter::reverse($postData['kembalian']);
            $reskasirku->users_id = $this->session->get('activeUser')["id"];
            $reskasirku->resto = 2;            
            if($postData['cash'] > 0){
                $reskasirku->tunai = FormaterAdapter::reverse($postData['cash']);
            }
            if ($postData['jeniskartukredit'] == 0 && $postData['nokamarid'] == "") {
                $reskasirku->tunai = FormaterAdapter::reverse($postData['totalnya']);
            }
            if($postData['jeniskartukredit'] > 0){
                if($postData['cash'] <= 0 && $postData['totalkamar'] <= 0){
                    $reskasirku->kartubayar = FormaterAdapter::reverse($postData['totalnya']);
                } else {
                    $reskasirku->kartubayar = FormaterAdapter::reverse($postData['totalcreditcard']);
                }
                $reskasirku->jenis_kartukredit = $postData['jeniskartukredit'];
            }
            if($postData['nokamarid'] > 0){
                $reskasirku->checkinid = $postData['nokamarid'];
                if ($postData['totalkamar'] == 0) {
                    $reskasirku->totalkamar = FormaterAdapter::reverse($postData['totalnya']);
                }elseif ($postData['totalkamar'] == 0 && $postData['cash'] != 0) {
                    $spakasir->totalkamar = FormaterAdapter::reverse($postData['totalnya']) - FormaterAdapter::reverse($postData['cash']);
                } else{
                    $reskasirku->totalkamar = FormaterAdapter::reverse($postData['totalkamar']);
                }
            }
        }  elseif($postData['checks']=="1") {
            $reskasirku = Reskasirku::find($postData['zid']);
            $reskasirku->tanggal = convert_date($postData['date']);
            $reskasirku->meja = $postData['meja'];
            $reskasirku->pax = $postData['kapasitas'];
            $reskasirku->waiters_id = $postData['waiter'];
            $reskasirku->total = FormaterAdapter::reverse($postData['totalnya']);
            $reskasirku->keterangan = $postData['keterangan'];
            if($postData['pembayaran'] > 0 && $postData['pembayaran'] == $postData['totalnya']){
                $reskasirku->bayar = FormaterAdapter::reverse($postData['pembayaran']);
            } else {
                $reskasirku->bayar = FormaterAdapter::reverse($postData['totalnya']);
            }
            //$reskasirku->kembalian = FormaterAdapter::reverse($postData['kembalian']);
            $reskasirku->users_id = $this->session->get('activeUser')["id"];
            if($postData['cash'] > 0){
                if($postData['totalcreditcard'] <= 0 && $postData['totalkamar'] <= 0){
                    $reskasirku->tunai = FormaterAdapter::reverse($postData['totalnya']);
                } else {
                    $reskasirku->tunai = FormaterAdapter::reverse($postData['cash']);
                }
            }
            if ($postData['jeniskartukredit'] == "" && $postData['totalkamar'] == "") {
                $reskasirku->tunai = FormaterAdapter::reverse($postData['totalnya']);
            }
            if($postData['jeniskartukredit'] > 0){
                if($postData['cash'] <= 0 && $postData['totalkamar'] <= 0){
                    $reskasirku->kartubayar = FormaterAdapter::reverse($postData['totalnya']);
                } else {
                    $reskasirku->kartubayar = FormaterAdapter::reverse($postData['totalcreditcard']);
                }
                $reskasirku->jenis_kartukredit = $postData['jeniskartukredit'];
            }
            if($postData['nokamarid'] != ""){
                $reskasirku->checkinid = $postData['nokamarid'];
                if ($postData['totalkamar'] == 0) {
                    $reskasirku->totalkamar = FormaterAdapter::reverse($postData['totalnya']);
                }elseif ($postData['totalkamar'] == 0 && $postData['cash'] != 0) {
                    $spakasir->totalkamar = FormaterAdapter::reverse($postData['totalnya']) - FormaterAdapter::reverse($postData['cash']);
                } else{
                    $reskasirku->totalkamar = FormaterAdapter::reverse($postData['totalkamar']);
                }
            }

            $reservationdetails=Reskasirkudetail::where("reskasirku_id",$postData['zid']);
            $reservationdetails->delete();
        }

        if(isset($postData['diskon'])){
            $reskasirku->diskon = FormaterAdapter::reverse($diskon);
        }

        $kasir = $reskasirku->save();


        $insertedId = $reskasirku->id;

        if($kasir){

            foreach ($postData["ids"] as $key => $rooms) {
                $det = new Reskasirkudetail();
                $det->reskasirku_id = $insertedId;
                $det->menuid = $postData['ids'][$key];
                $det->kuantitas = $postData['qty'][$key];
                $det->harga = FormaterAdapter::reverse($postData['hargatot'][$key]);
                $det->save();
            }

            if ($postData['nokamarid']){
                $Reservasidetail_id=0;
                $queryReservasidetails=  Capsule::select("select id from reservationdetails where checkin_code is not null  and check_out_id is null and id =".$postData['nokamarid']);
                foreach ($queryReservasidetails as $queryReservasidetail) {
                    $Reservasidetail_id=$queryReservasidetail->id;
                }
                $Addcharge = new Addcharge();
                $Addcharge->tanggal=convert_date($postData['date']);
                $Addcharge->nobukti=$postData['nobukti'];
                $Addcharge->reservationdetails_id=$Reservasidetail_id;
                $Addcharge->accjurnals_id=0;
                $Addcharge->service=0;
                $Addcharge->nservice=0;
                $Addcharge->nppn=0;
                if ($postData['totalkamar'] > 0) {
                    $Addcharge->ntotal=FormaterAdapter::reverse($postData['totalkamar']);
                }elseif ($postData['cash'] > 0 || $postData['totalcreditcard'] > 0 ) {
                    $Addcharge->ntotal = FormaterAdapter::reverse($postData['totalnya']) - FormaterAdapter::reverse($postData['cash']) - FormaterAdapter::reverse($postData['totalcreditcard']);
                }else{
                    $Addcharge->ntotal=FormaterAdapter::reverse($postData['totalnya']);
                }
                $Addcharge->remark='Restoran';
                $Addcharge->pisah=0;
                $Addcharge->users_id=$this->session->get('activeUser')["id"];
                $AddchargeQuery=$Addcharge->save();
                if($AddchargeQuery){
                    $Addchargedetail = new Addchargedetail();
                    $Addchargedetail->addcharges_id=$Addcharge->id;
                    $Addchargedetail->addchargetypes_id=1;
                    $Addchargedetail->remark='Restoran';
                    $Addchargedetail->qty=1;
                    if ($postData['totalkamar'] > 0) {
                        $Addchargedetail->sell=FormaterAdapter::reverse($postData['totalkamar']);
                    }elseif ($postData['cash'] > 0 || $postData['totalcreditcard'] > 0 ) {
                        $Addchargedetail->sell = FormaterAdapter::reverse($postData['totalnya']) - FormaterAdapter::reverse($postData['cash']) - FormaterAdapter::reverse($postData['totalcreditcard']);
                    }else{
                        $Addchargedetail->sell=FormaterAdapter::reverse($postData['totalnya']);
                    }
                    $Addchargedetail->buy=0;
                    $Addchargedetail->users_id=$this->session->get('activeUser')["id"];
                    $Addchargedetail->save();
                }

                // identifikasi addcharges id
                $addchargesid = $Addcharge->id;

                //update addcharges di database kasirku
                $resupdate = Reskasirku::find($insertedId);
                $resupdate->addcharge_id = $addchargesid;
                $resupdate->save();

            }
        }

        return $response->withRedirect($this->router->pathFor('kasirwhitehouse-report',['id' => $insertedId ]));

    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $reskasirku = Reskasirku::find($args['id']);      
        $det = Reskasirku::where('id','=',$args['id'])->get();
        $reskasirku->delete();
        $reskasirkudetail = Reskasirkudetail::where('reskasirku_id','=',$args['id']);
        $reskasirkudetail->delete();

        //hapus jurnal umum
        $jurId = $det[0]['jurnalid'];
        if($jurId != NULL){
            $jurnal = Accjurnal::find($jurId)->delete();
            $jurnaldetail = Accjurnaldetail::where('accjurnals_id','=',$jurId)->delete();
        }
        // end hapus jurnal umum

        //hapus addcharges di kamar
        $addId = $det[0]['addcharge_id'];
        if($addId != NULL){
            $addcharges = Addcharge::find($addId)->delete();
            $addchargesdetail = Addchargedetail::where('addcharges_id','=',$addId)->delete();
        }
        //end hapus addcharges di kamar

        $this->session->setFlash('success', 'Data kasir telah dihapus');
        return $response->withRedirect($this->router->pathFor('kasirwh'));
    }

    public function ajax(Request $request, Response $response, Array $args)
    {
        $data['reskasirku'] = Reskasirkudetail::where('reskasirku_id','=',$args['id'])->get();

        return $this->renderer->render($response, 'restoran/kasirku-ajax', $data);
    }

    public function kasirkureport(Request $request, Response $response, Array $args)
    {
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
            $Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        $data['resto'] = 'wh';
        $data['reskasirku'] = Reskasirku::where('id','=',$args['id'])->get();
        $data['Reskasirkudetail'] = Reskasirkudetail::where('reskasirku_id','=',$args['id'])->get();

        return $this->renderer->render($response, 'restoran/reports/kasirku-report', $data);
    }

    private function post_jurnal($postData){
        $jurnal=[
                "id"=>"",
                "code" => "",
                "tanggal" => date('Y-m-d', strtotime($postData['date'])),
                "nobukti" => $postData['nobukti'],
                "keterangan" => "Penjualan White Horse",
                "details"=>[]
            ];

        $penjualan_bersih = FormaterAdapter::reverse($postData['cash']);
        $totalkamar = FormaterAdapter::reverse($postData['totalkamar']);
        $jlmTotal =  FormaterAdapter::reverse($postData['totalnya']);
        //jika cash tidak diisi maka ambil nominal dari total pembayaran
        if($penjualan_bersih <= 0 && $postData['totalcreditcard'] <= 0 && $postData['totalkamar'] <= 0){
            $penjualan_bersih = FormaterAdapter::reverse($postData['totalnya']);
        }

         //jika total kredit tidak 0 maka disimpan ke jurnal
        if($postData['totalcreditcard'] > 0){
            $penjualan_bersih = $postData['totalcreditcard'];
            if($postData['cash'] > 0){
                $penjualan_bersih = FormaterAdapter::reverse($postData['totalcreditcard']) + FormaterAdapter::reverse($postData['cash']);
            }
        }

        if ($totalkamar < $jlmTotal) {
           $penjualan_bersih = FormaterAdapter::reverse($postData['totalnya']) - FormaterAdapter::reverse($postData['totalkamar']);
        }  

        $jurnal["details"][]=[
            "accounts_id"=>Option::where("name","=","kas")->first()->value,
            "debet"=>FormaterAdapter::reverse($penjualan_bersih),
            "kredit"=>0
        ]; // simpan ke kas


        $jurnal["details"][]=[
            "accounts_id"=>Option::where("name","=","pend_restoranwh")->first()->value,
            "debet"=>0,
            "kredit"=>FormaterAdapter::reverse($penjualan_bersih)
        ]; // simpan pendapatan resto


        $Accprovider=new AccountingServiceProvider();

        $accounting=$Accprovider->jurnal_save($jurnal);

        if($accounting["stat"]=="error"){
            echo $accounting["mess"];
            return false;
        }

        //print_r($accounting);
        return $accounting["accjurnals_id"];
    }

    public function rekappenjualan(Request $request, Response $response, $args)
    {
        
        $postData = $request->getParsedBody();

        if($request->isPost()){        
            $date=$postData["date"];
        }else{
            $date=date("d-m-Y");
        }

        $data['tanggal'] = $date;
        $data['resto'] = 'wh';

        $data['menus'] = Reskasirku::where('tanggal','=',$this->convert_date($date))->where('reskasirku.users_id','=',$this->session->get('activeUser')["id"])->where('resto','=',2)->get();

        return $this->renderer->render($response, 'restoran/reports/rekap-penjualan', $data);
    } 

    public function rekappenjualanprint(Request $request, Response $response, $args)
    {
        $postData = $request->getParsedBody();

        if($request->isPost()){        
            $date=$postData["date"];
        }else{
            $date=date("Y-m-d");
        }

        $data['tanggal'] = $date;

        $data['menus'] = Reskasirku::where('tanggal','=',$this->convert_date($date))->where('reskasirku.users_id','=',$this->session->get('activeUser')["id"])->where('resto','=',2)->get();
        $data['options'] = Options::all();

        return $this->renderer->render($response, 'restoran/reports/rekap-penjualan-print', $data);
    } 

    public function laporanpenjualan(Request $request, Response $response, $args)
    {

        $postData = $request->getParsedBody();

        if($request->isPost()){        
            $date=$postData["date"];
            $data['kategori'] =$postData["kategoriid"];
        }else{
            $date=date("d-m-Y");
            $data['kategori'] = 0;
        }
        $data['resto'] = 'wh';

        $data['tanggal'] = $date;
        $data['Menu_kategoris'] = Reskategori::all();
        $data['menus'] = Reskasirkudetail::groupBy('menuid')
                                ->join('resmenu','resmenu.id','=','reskasirkudetail.menuid')
                                ->join('reskasirku','reskasirku.id','=','reskasirkudetail.reskasirku_id')
                                ->selectRaw('SUM(reskasirkudetail.kuantitas) as total, resmenu.*,reskasirku.tanggal, SUM(reskasirku.diskon) as diskon')
                                ->where('reskasirku.tanggal','=',$this->convert_date($date))
                                ->where('reskasirku.resto','=',2)
                                ->where('reskasirku.users_id','=',$this->session->get('activeUser')["id"])
                                ->get();
        if($postData["kategoriid"] > 0){
        $data['menus'] = Reskasirkudetail::groupBy('menuid')
                                ->join('resmenu','resmenu.id','=','reskasirkudetail.menuid')
                                ->join('reskasirku','reskasirku.id','=','reskasirkudetail.reskasirku_id')
                                ->selectRaw('SUM(reskasirkudetail.kuantitas) as total, resmenu.*,reskasirku.tanggal, SUM(reskasirku.diskon) as diskon')
                                ->where('resmenu.kategoriid','=',$postData["kategoriid"])
                                ->where('reskasirku.tanggal','=',$this->convert_date($date))
                                ->where('reskasirku.resto','=',2)
                                ->where('reskasirku.users_id','=',$this->session->get('activeUser')["id"])
                                ->get();
        }
        // Perulangan service (menu tambahan) di restoran
        $data['services'] = Reskasirkudetail::groupBy('menuid')
                                ->join('reskasirku','reskasirku.id','=','reskasirkudetail.reskasirku_id')
                                ->where('reskasirku.tanggal','=',$this->convert_date($date))
                                ->where('reskasirku.resto','=',2)
                                ->selectRaw('SUM(reskasirkudetail.kuantitas) as totalqty, reskasirkudetail.*, reskasirku.*, SUM(reskasirkudetail.harga) as harga')
                                ->where('reskasirku.users_id','=',$this->session->get('activeUser')["id"])
                                ->get();

        return $this->renderer->render($response, 'restoran/reports/laporan-penjualan', $data);
    } 
    public function laporanpenjualanprint(Request $request, Response $response, $args)
    {
        $data['options'] = Options::all();  
        $date=$args['date']; 
        $data['tanggal'] = $args['date'];
        $data['menus'] = Reskasirkudetail::groupBy('menuid')
                                ->join('resmenu','resmenu.id','=','reskasirkudetail.menuid')
                                ->join('reskasirku','reskasirku.id','=','reskasirkudetail.reskasirku_id')
                                ->selectRaw('SUM(reskasirkudetail.kuantitas) as total, resmenu.*,reskasirku.tanggal,reskasirku.resto, SUM(reskasirku.diskon) as diskon')
                                ->where('reskasirku.tanggal','=',$this->convert_date($date))
                                ->where('reskasirku.resto','=',2)
                                ->where('reskasirku.users_id','=',$this->session->get('activeUser')["id"])
                                ->get();
        if($args["id"] > 0){
        $data['menus'] = Reskasirkudetail::groupBy('menuid')
                                ->join('resmenu','resmenu.id','=','reskasirkudetail.menuid')
                                ->join('reskasirku','reskasirku.id','=','reskasirkudetail.reskasirku_id')
                                ->selectRaw('SUM(reskasirkudetail.kuantitas) as total, resmenu.*,reskasirku.tanggal,reskasirku.resto, SUM(reskasirku.diskon) as diskon')
                                ->where('resmenu.kategoriid','=',$args["id"])
                                ->where('reskasirku.tanggal','=',$this->convert_date($date))
                                ->where('reskasirku.resto','=',2)
                                ->where('reskasirku.users_id','=',$this->session->get('activeUser')["id"])
                                ->get();
        }
        // Perulangan service (menu tambahan) di restoran
        $data['services'] = Reskasirkudetail::groupBy('menuid')
                                ->join('reskasirku','reskasirku.id','=','reskasirkudetail.reskasirku_id')
                                ->where('reskasirku.tanggal','=',$date)
                                ->where('reskasirku.resto','=',2)
                                ->selectRaw('SUM(reskasirkudetail.kuantitas) as totalqty, reskasirkudetail.*, reskasirku.*, SUM(reskasirkudetail.harga) as harga')
                                ->where('reskasirku.users_id','=',$this->session->get('activeUser')["id"])
                                ->get();

        return $this->renderer->render($response, 'restoran/reports/laporan-penjualan-print', $data);
    } 

    private function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }
    

}
