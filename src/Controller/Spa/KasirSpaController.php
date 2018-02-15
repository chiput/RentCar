<?php

namespace App\Controller\Spa;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Spalayanan;
use App\Model\Spakategori;
use App\Model\Barang;
use App\Model\Account;
use App\Model\Spalayanandetail;
use App\Model\Brgsatuan;
use App\Model\Konversi;
use App\Model\Spaterapis;
use App\Model\Spakasir;
use App\Model\Spakasirdetail;
use App\Model\Option;
use Kulkul\Options;
use App\Model\Addcharge;
use App\Model\Addchargedetail;
use App\Model\Gudpakai;
use App\Model\Gudpakaidetail;
use App\Model\Reservationdetail;
use App\Model\Reservation;
use App\Model\Creditcard;
use App\Model\Accjurnal;
use App\Model\Accjurnaldetail;
use Kulkul\Accounting\AccountingServiceProvider;
use Kulkul\LogisticStock\LogisticStockProvider; 
use Kulkul\CurrencyFormater\FormaterAdapter;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Capsule\Manager as DB;

class KasirSpaController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {

        $data['app_profile'] = $this->app_profile;
        $data['Kasir'] = Spakasir::orderby('id','desc')->get();

        return $this->renderer->render($response, 'spa/kasirspa', $data);
    }

    public function GenericNoBukti($NoBukti){
        $repalgs= $this->db->table('spakasir')->get();
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
         foreach ($repalgs as $spakasir ) {
            if(strtolower($spakasir->nobukti)==strtolower("SPA.".date('y').date('m').$NoBuktitext)){
                //$NoBukti++;
                $status=false;
            }
        }
        if(!$status){
           return $this->GenericNoBukti($NoBukti);
        }
        else{
            return "SPA.".date('y').date('m').$NoBuktitext ;
        }
    }

    public function form(Request $request, Response $response, Array $args)
    {

        $data['errors'] = $this->session->getFlash('error_messages');
        $data['creditcards'] = Creditcard::all();

        if (isset($args['id'])){
            $data['spakasir'] = Spakasir::find($args['id']);
            $data['spakasirdetail'] = $this->db->table('spakasirdetail')
                                ->join('spalayanan', 'spalayanan.id', '=', 'spakasirdetail.layananid')
                                ->join('spaterapis','spaterapis.id','=','spakasirdetail.terapisid')
                                ->select('spakasirdetail.*','spalayanan.nama_layanan as nama_layanan','spaterapis.nama as nama_terapis','spalayanan.kode as kodelayanan','spakasirdetail.kuantitas')
                                ->where('spakasirdetail.spakasir_id','=',$args['id'])->get();
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

            $data['NoBukti'] =$this->GenericNoBukti(count($this->db->table('spakasir')->get()));
        }

        $data['Kasir'] = $this->db->table('spalayanan')
                        ->join('spakategori','spalayanan.kategoriid','=','spakategori.id')
                         ->select('spalayanan.*','spakategori.nama as namakategori' )
                        ->get()->sortByDesc("created_at");
        $data['terapis'] = Spaterapis::all();

        $data['Rooms'] = Reservationdetail::where("checkin_at","!=", null)
                                            ->where("checkout_at","=",null)
                                            ->get();

        return $this->renderer->render($response, 'spa/kasirspa-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        // validation
        $this->validation->validate([
            'pelanggan|Pelanggan' => [$postData['pelanggan'], 'required'],
            'kapasitas|Pax' => [$postData['kapasitas'], 'required'],
            'qty|Kuantitas' => [$postData['qty'], 'required'],
            //'terapis_id|Pilih Terapis' => [$postData['terapis_id'], 'required'],
            //'layanan_id|Pilih Layanan' => [$postData['layanan_id'], 'required'],
        ]);
        
        if (!$this->validation->passes()) {
            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['zid'] == '') {
                return $response->withRedirect($this->router->pathFor('kasirspa-add'));
            } else {
                return $response->withRedirect($this->router->pathFor('kasirspa-edit',['id' => $postData['zid']]));
            }
        }

        function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }


        $gudnya2 = Gudpakai::where("keterangan",'=','pemakaian barang pada spa dengan bill '.$postData['nobukti'])->delete();
        $gudnya3 = Gudpakaidetail::where('gudpakai_id','=',$gudnya2->id)->delete();

        //Pemakaian Barang
        $usage = Gudpakai::where(DB::raw('left(nobukti,7)'), '=', 'PB.'.date('ym'))
                                ->orderBy('nobukti',"desc")->first();
        $usagebukti = 'PB.'.date('ym').substr('0000'.(substr($usage->nobukti,-4)*1+1),-4);

        $gud = new Gudpakai;
        $gud->tanggal = convert_date($postData['date']);
        $gud->nobukti = $usagebukti;
        $gud->gudang_id = 6;
        $gud->accjurnal_id = 0;
        $gud->keterangan = 'pemakaian barang pada spa dengan bill '.$postData['nobukti'];
        $gud->users_id = $this->session->get('activeUser')["id"];
        $gud->save();

        $barang = [];

        foreach ($postData["ids"] as $key => $layanan) {
            $barang = Spalayanandetail::where('id2','=',$postData['ids'][$key])->get();
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


        //Spa
        if(isset($postData['diskon'])){
            $diskon = $postData['totalnya'] * $postData['diskon'] / 100;
            $postData['totalnya'] = $postData['totalnya'] - $diskon;
        }
        
        if($postData['cash'] != 0 || $postData['totalcreditcard'] != 0){
            $jurnal_id = $this->post_jurnal($postData);
        }

        if($postData['cash'] == 0 && $postData['totalcreditcard'] == 0 && $postData['nokamarid'] == "0"){
            $jurnal_id =$this->post_jurnal($postData);
        }

        // if($postData['totalkamar'] > 0 && $postData['totalkamar'] < $postData['totalnya']){
        //     $jurnal_id =$this->post_jurnal($postData);
        // }

        if ($postData['checks']=="0"){


            $spakasir = new Spakasir();
            $spakasir->jurnalid = $jurnal_id;
            $spakasir->tanggal = convert_date($postData['date']);
            $spakasir->nobukti = $postData['nobukti'];
            $spakasir->pax = $postData['kapasitas'];
            $spakasir->namapelanggan = $postData['pelanggan'];
            $spakasir->total = FormaterAdapter::reverse($postData['totalnya']);
            $spakasir->keterangan = $postData['keterangan'];
            if($postData['pembayaran'] > 0 && $postData['pembayaran'] == $postData['totalnya']){
                $spakasir->bayar = FormaterAdapter::reverse($postData['pembayaran']);
            } else {
                $spakasir->bayar = FormaterAdapter::reverse($postData['totalnya']);
            }
            if ($postData['totalkamar'] != 0 && $postData['cash'] == 0) {
               $spakasir->kembalian = FormaterAdapter::reverse($postData['kembalian']) - FormaterAdapter::reverse($postData['kembalian']);
            }else{
                $spakasir->kembalian = FormaterAdapter::reverse($postData['kembalian']);
            }
            $spakasir->users_id = $this->session->get('activeUser')["id"];
            if($postData['cash'] > 0){
                $spakasir->tunai = FormaterAdapter::reverse($postData['cash']);
            }
            if ($postData['jeniskartukredit'] == 0 && $postData['nokamarid'] == 0) {
                $spakasir->tunai = FormaterAdapter::reverse($postData['totalnya']);
            }
            if($postData['jeniskartukredit'] > 0){
                if($postData['cash'] <= 0 && $postData['totalkamar'] <= 0){
                    $spakasir->kartubayar = FormaterAdapter::reverse($postData['totalnya']);
                } else {
                    $spakasir->kartubayar = FormaterAdapter::reverse($postData['totalcreditcard']);
                }
                $spakasir->jenis_kartukredit = $postData['jeniskartukredit'];
            }
            if($postData['nokamarid'] > 0){
                $spakasir->checkinid = $postData['nokamarid'];
                if ($postData['totalkamar'] == 0) {
                    $spakasir->totalkamar = FormaterAdapter::reverse($postData['totalnya']);
                }elseif ($postData['totalkamar'] == 0 && $postData['cash'] != 0) {
                    $spakasir->totalkamar = FormaterAdapter::reverse($postData['totalnya']) - FormaterAdapter::reverse($postData['cash']);
                } else{
                    $spakasir->totalkamar = FormaterAdapter::reverse($postData['totalkamar']);
                }
            }
        }  elseif($postData['checks']=="1") {
            $spakasir = Spakasir::find($postData['zid']);
            $spakasir->tanggal = convert_date($postData['date']); 
            $spakasir->pax = $postData['kapasitas'];
            $spakasir->namapelanggan = $postData['pelanggan'];
            $spakasir->total = FormaterAdapter::reverse($postData['totalnya']);
            $spakasir->keterangan = $postData['keterangan'];
            if($postData['pembayaran'] > 0 && $postData['pembayaran'] == $postData['totalnya']){
                $spakasir->bayar = FormaterAdapter::reverse($postData['pembayaran']);
            } else {
                $spakasir->bayar = FormaterAdapter::reverse($postData['totalnya']);
            }
            if ($postData['totalkamar'] != 0 && $postData['cash'] == 0) {
               $spakasir->kembalian = FormaterAdapter::reverse($postData['kembalian']) - FormaterAdapter::reverse($postData['kembalian']);
            }else{
                $spakasir->kembalian = FormaterAdapter::reverse($postData['kembalian']);
            }
            $spakasir->users_id = $this->session->get('activeUser')["id"];
            if($postData['cash'] > 0){
                if($postData['totalcreditcard'] <= 0 && $postData['totalkamar'] <= 0){
                    $spakasir->tunai = FormaterAdapter::reverse($postData['totalnya']);
                } else {
                    $spakasir->tunai = FormaterAdapter::reverse($postData['cash']);
                }
            }
            if ($postData['jeniskartukredit'] == "" && $postData['nokamarid'] == "") {
                $spakasir->tunai = FormaterAdapter::reverse($postData['totalnya']);
            }
            if($postData['jeniskartukredit'] > 0){
                if($postData['cash'] <= 0 && $postData['totalkamar'] <= 0){
                    $spakasir->kartubayar = FormaterAdapter::reverse($postData['totalnya']);
                } else {
                    $spakasir->kartubayar = FormaterAdapter::reverse($postData['totalcreditcard']);
                }
                $spakasir->jenis_kartukredit = $postData['jeniskartukredit'];
            }
            if($postData['nokamarid'] != ""){
                $spakasir->checkinid = $postData['nokamarid'];
                if ($postData['totalkamar'] == 0) {
                    $spakasir->totalkamar = FormaterAdapter::reverse($postData['totalnya']);
                }elseif ($postData['totalkamar'] == 0 && $postData['cash'] != 0) {
                    $spakasir->totalkamar = FormaterAdapter::reverse($postData['totalnya']) - FormaterAdapter::reverse($postData['cash']);
                } else{
                    $spakasir->totalkamar = FormaterAdapter::reverse($postData['totalkamar']);
                }
            }

            $reservationdetails=Spakasirdetail::where("spakasir_id",$postData['zid']);
            $reservationdetails->delete();
        }

        if(isset($postData['diskon'])){
            $spakasir->diskon = FormaterAdapter::reverse($diskon);
        }

        $kasir = $spakasir->save();


        $insertedId = $spakasir->id;

        if($kasir){

            foreach ($postData["ids"] as $key => $rooms) {
                $det = new Spakasirdetail();
                $det->spakasir_id = $insertedId;
                $det->layananid = $postData['ids'][$key];
                $det->terapisid = $postData['terapis'][$key];
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
                $Addcharge->remark='SPA';
                $Addcharge->pisah=0;
                $Addcharge->users_id=$this->session->get('activeUser')["id"];
                $AddchargeQuery=$Addcharge->save();
                if($AddchargeQuery){
                    $Addchargedetail = new Addchargedetail();
                    $Addchargedetail->addcharges_id=$Addcharge->id;
                    $Addchargedetail->addchargetypes_id=1;
                    $Addchargedetail->remark='SPA';
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
                $resupdate = spakasir::find($insertedId);
                $resupdate->addcharge_id = $addchargesid;
                $resupdate->save();

            }

        }

        return $response->withRedirect($this->router->pathFor('kasirspa-report',['id' => $insertedId ]));

    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $spakasir = Spakasir::find($args['id']);
        $det = Spakasir::where('id','=',$args['id'])->get();
        $spakasir->delete();
        $spakasirdetail = Spakasirdetail::where('spakasir_id','=',$args['id']);
        $spakasirdetail->delete();

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
        return $response->withRedirect($this->router->pathFor('kasirspa'));
    }

    public function ajax(Request $request, Response $response, Array $args)
    {
       
        $data['spakasir'] = Spakasirdetail::where('spakasir_id','=',$args['id'])->get();

        return $this->renderer->render($response, 'spa/kasirspa-ajax', $data);
    }

    public function kasirspareport(Request $request, Response $response, Array $args)
    {
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
            $Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        $data['spakasir'] = Spakasir::where('id','=',$args['id'])->get();
        $data['spakasirdetail'] = Spakasirdetail::where('spakasir_id','=',$args['id'])->get();

        return $this->renderer->render($response, 'spa/reports/kasirspa-report', $data);
    }

    private function post_jurnal($postData){
        $jurnal=[
                "id"=>"",
                "code" => "",
                "tanggal" => date('Y-m-d', strtotime($postData['date'])),
                "nobukti" => $postData['nobukti'],
                "keterangan" => "Penjualan Spa",
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
        if($postData['jenis_kartukredit'] > 0){
            $penjualan_bersih = FormaterAdapter::reverse($postData['totalcreditcard']);
            if($postData['cash'] > 0){
                $penjualan_bersih = FormaterAdapter::reverse($postData['totalcreditcard']) + FormaterAdapter::reverse($postData['cash']);
            }
        }

        if ($totalkamar < $jlmTotal) {
               $penjualan_bersih = FormaterAdapter::reverse($postData['totalnya']) - FormaterAdapter::reverse($postData['totalkamar']);
            }  

        // simpan ke kas
        $jurnal["details"][]=[
            "accounts_id"=>Option::where("name","=","kas")->first()->value,
            "debet"=>FormaterAdapter::reverse($penjualan_bersih),
            "kredit"=>0
        ]; 

        // simpan ke pendapatan spa
        $jurnal["details"][]=[
            "accounts_id"=>Option::where("name","=","pend_spa")->first()->value,
            "debet"=>0,
            "kredit"=>FormaterAdapter::reverse($penjualan_bersih)
        ]; 


        $Accprovider=new AccountingServiceProvider();

        $accounting=$Accprovider->jurnal_save($jurnal);

        if($accounting["stat"]=="error"){
            echo $accounting["mess"];
            return false;
        }

        //print_r($accounting);
        return $accounting["accjurnals_id"];
    }

}