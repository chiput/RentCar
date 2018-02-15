<?php

namespace App\Controller\Store;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Storekasir;
use App\Model\Storekasirdetail;
use App\Model\Barang;
use App\Model\Gudpakai;
use App\Model\Gudpakaidetail;
use Kulkul\Options;
use Kulkul\CurrencyFormater\FormaterAdapter;
use App\Model\Option;
use App\Model\Setupgudang;
use App\Model\Accjurnal;
use App\Model\Accjurnaldetail;
use Kulkul\Accounting\AccountingServiceProvider;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Capsule\Manager as DB;
use Harmoni\LogAuditing\LogAuditingProvider;

class KasirController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {

        $data['app_profile'] = $this->app_profile;
        $data['datas'] = Storekasir::orderby('id','desc')->get();

        return $this->renderer->render($response, 'store/kasir', $data);


    }

    public function GenericNoBukti($NoBukti){
        $repalgs= $this->db->table('storekasir')->get();
        if ($NoBukti<10){
            $NoBuktitext="000".$NoBukti++;
        }else if ($NoBukti<100){
            $NoBuktitext="00".$NoBukti++;
        }else if ($NoBukti<1000){
            $NoBuktitext="0".$NoBukti++;
        }
        else if ($NoBukti<10000){
            $NoBuktitext=$NoBukti++;
        }
        $status=true;
         foreach ($repalgs as $reskasir ) {
            if(strtolower($reskasir->nobukti)==strtolower("ST.".date('y').date('m').$NoBuktitext)){
                //$NoBukti++;
                $status=false;
            }
        }
        if(!$status){
           return $this->GenericNoBukti($NoBukti);
        }
        else{
            return "ST.".date('y').date('m').$NoBuktitext ;
        }
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data['errors'] = $this->session->getFlash('error_messages');
        $setgud = Setupgudang::where('name','gud_store')->first();
        $data['barangs'] = Capsule::select("
                select * from 
                (select 
                    C.*,
                    C.id as barangidnya,
                    D.id as gudid,
                    D.nama as namagud,
                    F.nama as satuannama
                from 
                    gudterima A,
                    gudterimadetail B,
                    barang C,
                    gudang D, 
                    departments E,
                    brgsatuan F
                where 
                    A.id=B.gudterima_id 
                    and B.barang_id=C.id 
                    and A.gudang_id=D.id 
                    and F.id=C.brgsatuan_id 
                    and D.id=".$setgud->value."
                group by C.id
                ) x LEFT JOIN storebarang z ON x.id=z.barang_id Where z.barang_id IS NOT NULL");

        if (isset($args['id'])){
            $data['Storekasir'] = Storekasir::find($args['id']);
            $data['Storekasirdetail'] = Storekasirdetail::where('storekasirdetails.storekasir_id','=',$args['id'])
                                                        ->get();
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

            $data['NoBukti'] =$this->GenericNoBukti(count($this->db->table('storekasir')->get()));
        }


        return $this->renderer->render($response, 'store/kasir-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();
        $jurnal_id = $this->post_jurnal($postData);

        //pemakaian barang
        $gudnya2 = Gudpakai::where("keterangan",'=','pemakaian barang pada store dengan bill '.$postData['nobukti'])->delete();
        //$gudnya3 = Gudpakaidetail::where('gudpakai_id','=',$gudnya2->id)->delete();
        $setgud = Setupgudang::where('name','gud_store')->first();
        //Pemakaian Barang
        $usage = Gudpakai::where(DB::raw('left(nobukti,7)'), '=', 'PB.'.date('ym'))
                                ->orderBy('nobukti',"desc")->first();
        $usagebukti = 'PB.'.date('ym').substr('0000'.(substr($usage->nobukti,-4)*1+1),-4);

        $gud = new Gudpakai;
        $gud->tanggal = $this->convert_date($postData['date']);
        $gud->nobukti = $usagebukti;
        $gud->gudang_id = $setgud->value;
        $gud->accjurnal_id = 0;
        $gud->keterangan = 'pemakaian barang pada store dengan bill '.$postData['nobukti'];
        $gud->users_id = $this->session->get('activeUser')["id"];
        $gud->save();

        $barang = [];

        foreach ($postData["ids"] as $key => $menu) {
                
            $barang = Barang::where('id','=',$postData['ids'][$key])->get();
            foreach ($barang as $keys) {
                $gudet = new Gudpakaidetail;
                $gudet->gudpakai_id = $gud->id;
                $gudet->barang_id = $keys->id;
                $gudet->satuan_id = $keys->brgsatuan_id;
                $gudet->account_id = 0;
                $gudet->kuantitas = $postData['qty'][$key];
                $gudet->save();
            }
        }


        //Store
        if(isset($postData['diskon'])){
            $diskon = $postData['totalnya'] * $postData['diskon'] / 100;
            $postData['totalnya'] = $postData['totalnya'] - $diskon;
        }

        
        if ($postData['checks']=="0"){
            $reskasirku = new Storekasir();
            $reskasirku->jurnalid = $jurnal_id;
            $reskasirku->tanggal = $this->convert_date($postData['date']);
            $reskasirku->nobukti = $postData['nobukti'];
            $reskasirku->total = FormaterAdapter::reverse($postData['totalnya']);
            $reskasirku->users_id = $this->session->get('activeUser')["id"];
        }  elseif($postData['checks']=="1") {
            $reskasirku = Storekasir::find($postData['zid']);
            $reskasirku->tanggal = $this->convert_date($postData['date']);
            $reskasirku->total = FormaterAdapter::reverse($postData['totalnya']);
            $reskasirku->users_id_edit = $this->session->get('activeUser')["id"];
            $reservationdetails=Storekasirdetail::where("storekasir_id",$postData['zid']);
            $resdet = $reservationdetails->get();
            $reservationdetails->delete();
        }

        if(isset($postData['diskon'])){
            $reskasirku->diskon = $diskon;
        }
        $original = $reskasirku->getOriginal();
        $kasir = $reskasirku->save();

        LogAuditingProvider::logactivity($reskasirku,$original,'storekasir');
        $details = [];

        if($kasir){
            foreach ($postData["ids"] as $key => $rooms) {
                $det = new Storekasirdetail();
                $det->storekasir_id = $reskasirku->id;
                $det->barang_id = $postData['ids'][$key];
                $det->kuantitas = $postData['qty'][$key];
                $det->harga = FormaterAdapter::reverse($postData['hargatot'][$key]);
                $det->save();
                $details[] = $det;
            }

            LogAuditingProvider::logactivitydetails($details,$resdet,'storekasirdetails',$reskasirku->id);
        }

        return $response->withRedirect($this->router->pathFor('store-kasir-report',['id' => $reskasirku->id ]));
    }

    public function ajax(Request $request, Response $response, Array $args)
    {
        $data['storekasir'] = Storekasirdetail::where('storekasir_id','=',$args['id'])->get();

        return $this->renderer->render($response, 'store/kasir-ajax', $data);
    }

    public function kasirreport(Request $request, Response $response, Array $args)
    {
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
            $Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        $data['storekasir'] = Storekasir::where('id','=',$args['id'])->get();
        $data['storekasirdetail'] = Storekasirdetail::where('storekasir_id','=',$args['id'])->get();

        return $this->renderer->render($response, 'store/reports/kasir-report', $data);
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $reskasirku = Storekasir::find($args['id']);
        $reskasirku->delete();
        $reskasirkudetail = Storekasirdetail::where('storekasir_id','=',$args['id']);
        $reskasirkudetail->delete();
        //hapus jurnal umum
        $jurId = $det[0]['jurnalid'];
        if($jurId != NULL){
            $jurnal = Accjurnal::find($jurId)->delete();
            $jurnaldetail = Accjurnaldetail::where('accjurnals_id','=',$jurId)->delete();
        }
        $this->session->setFlash('success', 'Data kasir telah dihapus');
        return $response->withRedirect($this->router->pathFor('store-kasir'));


    }

    private function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }

    public function laporanpenjualan(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        if($request->isPost()){
            $date=$postData["date"];
            $data['kategori'] =$postData["kategoriid"];
        }else{
            $date=date("d-m-Y");
            $data['kategori'] = 0;
        }
        $data['tanggal'] = $date;


        $data['datas'] = Storekasirdetail::groupBy('barang_id')
                                            ->join('storekasir','storekasirdetails.storekasir_id','=','storekasir.id')
                                            ->selectRaw('SUM(storekasirdetails.kuantitas) as total, storekasir.tanggal, SUM(storekasir.diskon) as diskon, storekasirdetails.barang_id, storekasir.users_id')
                                            ->where('storekasir.tanggal','=',$this->convert_date($date))
                                            ->get();

        return $this->renderer->render($response, 'store/reports/laporan-penjualan', $data);
    }

    public function laporanpenjualanprint(Request $request, Response $response, Array $args)
    {
        $data['options'] = Options::all();
        $data['tanggal'] = $args['date'];
        $data['datas'] = Storekasirdetail::groupBy('barang_id')
                                            ->join('storekasir','storekasirdetails.storekasir_id','=','storekasir.id')
                                            ->selectRaw('SUM(storekasirdetails.kuantitas) as total, storekasir.tanggal, SUM(storekasir.diskon) as diskon, storekasirdetails.barang_id, storekasir.users_id')
                                            ->where('storekasir.tanggal','=',$this->convert_date($args['date']))
                                            ->get();
        return $this->renderer->render($response, 'store/reports/laporan-penjualan-print', $data);
    }

    private function post_jurnal($postData){
        $jurnal=[
                "id"=>"",
                "code" => "",
                "tanggal" => date('Y-m-d', strtotime($postData['date'])),
                "nobukti" => $postData['nobukti'],
                "keterangan" => "Penjualan Store",
                "details"=>[]
            ];

            $diskon = FormaterAdapter::reverse($postData['totalnya']) * $postData['diskon'] / 100;
        $totalharga = FormaterAdapter::reverse($postData['totalnya'] - FormaterAdapter::reverse($diskon));

        // simpan ke kas
        $jurnal["details"][]=[
            "accounts_id"=>Option::where("name","=","kas")->first()->value,
            "debet"=>FormaterAdapter::reverse($totalharga),
            "kredit"=>0
        ]; 

        // simpan ke pendapatan store
        $jurnal["details"][]=[
            "accounts_id"=>Option::where("name","=","penjualan")->first()->value,
            "debet"=>0,
            "kredit"=>FormaterAdapter::reverse($totalharga)
        ]; 


        $Accprovider=new AccountingServiceProvider();

        $accounting=$Accprovider->jurnal_save($jurnal);

        if($accounting["stat"]=="error"){
            echo $accounting["mess"];
            return false;
        }

        return $accounting["accjurnals_id"];

    }

}
