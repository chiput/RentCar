<?php

namespace App\Controller\Pembelian;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Pembelian;
use App\Model\PembelianDetail;
use App\Model\PembelianStatus;
use App\Model\PembelianReturDetail;
use App\Model\Department;
use App\Model\Gudminta;
use App\Model\Gudmintastatus;
use App\Model\Gudmintadetail;
use App\Model\Gudterima;
use App\Model\Gudterimadetail;
use App\Model\Barang;
use App\Model\Brgsatuan;
use App\Model\Supplier;
use App\Model\Accjurnal;
use App\Model\Accjurnaldetail;
use App\Model\Option;
use Kulkul\Accounting\AccountingServiceProvider;
use Kulkul\CurrencyFormater\FormaterAdapter;

use Illuminate\Database\Capsule\Manager as DB;

class PembelianController extends Controller
{
	public function __invoke(Request $request, Response $response, Array $args)
	{
		$postData = $request->getParsedBody();

		$data = [];
		$data['app_profile'] = $this->app_profile;

		if ($request->isPost()) {
			$data["d_start"]=$postData["start"];
            $data["d_end"]=$postData["end"];
		} else {
			$data["d_start"]=date("d-m-Y");
            $data["d_end"]=date("d-m-Y",strtotime("tomorrow"));
		}

		$data['purchOrders'] = Pembelian::whereBetween("tanggal",[$this->convert_date($data['d_start']), $this->convert_date($data['d_end'])])->orderBy("created_at","desc")->get();

		return $this->renderer->render($response, 'pembelian/pembelian', $data);

	}

	public function form(Request $request, Response $response, Array $args)
	{
		$data = [];
		$data['app_profile'] = $this->app_profile;
		$data['suppliers'] = Supplier::orderBy("created_at", "desc")->get();
		//$data['purchases'] = Gudminta::orderBy("tanggal", "desc")->doesntHave('pembelian')->get();
        $data['purchases'] = Gudmintastatus::where("status", "=", 0)->orderBy("tanggal", "desc")->orderBy('gudminta_id','desc')->get();
		$data['goods'] = Barang::select('id', 'kode', 'nama')->get();
		$data['units'] = Brgsatuan::select('id', 'nama')->get();
		$data['orderdetails'] = PembelianDetail::join('pembelian','pembelian.id','=','pembeliandetail.pembelian_id')->select('pembeliandetail.*','pembelian.permintaan_id')->get();
		$data['returdetails'] = PembelianReturDetail::all();
        $data['terimadetails'] = Gudterimadetail::join('gudterima','gudterima.id','=','gudterimadetail.gudterima_id')
                                                ->join('pembelian','pembelian.id','=','gudterima.pembelian_id')
                                                ->select('gudterimadetail.*','pembelian.permintaan_id')->get();



		if(@$args["id"] != ""){
            $data['order'] = Pembelian::find($args["id"]);
            $data['order']->tanggal = $this->convert_date($data['order']->tanggal);
            $data['order']->supplier_name = $data['order']->supplier->nama;
            $data['order']->department_name = $data['order']->department->name;


            $order_id = $data['order']->id;

            $goodterima = Gudterimadetail::whereHas("goodterima", function($q) use ($order_id) {
                $q->where('pembelian_id','=', $order_id);
            })->get();

            $data['goodterima'] = [];
            foreach($goodterima as $key => $barang)  {
                $data['goodterima'][$barang->barang_id] = $barang;
            }

        } else {

            $purReq = Pembelian::where(DB::raw('left(nobukti,7)'), '=', 'PO.'.date('ym'))
                                ->orderBy('nobukti',"desc")->first();
             if(@$args["id"] != ""){
	            $data['order'] = Pembelian::find($args["id"]);
	        } else {

	            $purReq = Pembelian::where(DB::raw('left(nobukti,7)'), '=', 'PO.'.date('ym'))
	                                ->orderBy('nobukti',"desc")->first();
	            if($purReq == NULL){
	                @$data['order']->nobukti = 'PO.'.date('ym').substr('0000'.(substr($purReq->nobukti,-4)*1+1),-4);
	            }else{
	                @$data['order']->nobukti = substr($purReq->nobukti,0,7).substr('0000'.(substr($purReq->nobukti,-4)*1+1),-4);
	            }

	        }

	        $data['errors'] = $this->session->getFlash('error_messages');
	        if (!is_null($data['errors'])) {
	            $data['order'] = (object) $this->session->getFlash('post_data');
	        }

        }

		return $this->renderer->render($response, 'pembelian/pembelian-form', $data);
	}

	public function save(Request $request, Response $response, Array $args)
	{
		$postData = $request->getParsedBody();

        //  function convert_date($date){
        //     $date = date("Y-m-d", strtotime($date));
        //     return $date;
        // }

        $jurnal_id = $this->post_jurnal($postData);

		$this->validation->validate([
			'tanggal|Tanggal' => [$postData['tanggal'], 'required'],
			'nobukti|No. Bukti' => [$postData['nobukti'], 'required'],
			'permintaan_id|No. Permintaan' => [$postData['permintaan_id'], 'required'],
			'supplier_id|Supplier' => [$postData['supplier_id'], 'required'],
		]);

		if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('daftar-pembelian-add'));
            } else {
                return $response->withRedirect($this->router->pathFor('daftar-pembelian-update'));
            }
        }

        if ($postData['id'] != "") {
        	$pembelian = Pembelian::find($postData['id']);
        	$pembelian->users_id_edit = $this->session->get('activeUser')["id"];
        	$pembeliandetail = PembelianDetail::where("pembelian_id","=",$postData['id'])->delete();
        } else {
        	$pembelian = new Pembelian();
        	$pembelian->users_id_edit = 0;
            $pembelian->users_id = $this->session->get('activeUser')["id"];
        }

        if(isset($postData['tunai'])) {
        	$tunai = 1;
        	$tempo = 0;
        } else {
        	$tunai = 0;
        	$tempo = $postData['tempo'];
        }

        $pembelian->tanggal = $this->convert_date($postData['tanggal']);
        $pembelian->nobukti = $postData['nobukti'];
        $pembelian->permintaan_id = $postData['permintaan_id'];
        $pembelian->department_id = $postData['department_id'];
        $pembelian->supplier_id = $postData['supplier_id'];
        $pembelian->tunai = $tunai;
        $pembelian->tempo = $tempo;
        $pembelian->keterangan = $postData['keterangan'];
        $pembelian->diskon = FormaterAdapter::reverse($postData['diskon']);
        $pembelian->ppn = $postData['ppn'];
        $pembelian->ongkos = FormaterAdapter::reverse($postData['ongkos']);
        $pembelian->jurnalid = $jurnal_id;
        $pembelian->cetak = 0;
        $pembelian->save();

        $pembelian_id = $pembelian->id;

        if($postData['id'] != "") {
            $reqstatus = PembelianStatus::where("pembelian_id","=", $pembelian_id)->first();
        } else {
            $reqstatus = new PembelianStatus();
        }

        $reqstatus->tanggal = $this->convert_date($postData['tanggal']);
        $reqstatus->pembelian_id = $pembelian_id;
        $reqstatus->keterangan = "created";
        $reqstatus->status = 0;
        $reqstatus->save();

        $purchased = 0;
        $count = 0;
        foreach ($postData['barang_id'] as $key => $barang) {
            $reqstatus = Gudmintadetail::where("gudminta_id", "=", $postData['permintaan_id'])->where("barang_id", "=", $barang)->where("kuantitas", "=", $postData["kuantitas"][$key])->get();
            $count +=1;
            if(!$reqstatus->isEmpty()) {
                $purchased += 1;
            }
        }  

        if($count == $purchased) {
            $purch = Gudmintastatus::where("gudminta_id", "=", $postData['permintaan_id'])->first();
            $purch->keterangan = "purchased";
            $purch->status = 1;
            $purch->save();
        }

        foreach($postData['barang_id'] as $key => $barang) {
        	$detail = new PembelianDetail();
        	$detail->pembelian_id = $pembelian_id;
        	$detail->barang_id = $barang;
        	$detail->satuan_id = $postData["satuan_id"][$key];
        	$detail->kuantitas = $postData["kuantitas"][$key];
        	$detail->harga = FormaterAdapter::reverse($postData["harga"][$key]);
        	$detail->save();
        }


        //merubah keterangan dan status di gudmintastatus

        //cek gudang minta detail kuantitas minta
        $wagudminta = Gudmintadetail::where('gudminta_id','=',$postData['permintaan_id'])->get();

        foreach ($wagudminta as $key => $value) {
            $waminta[$key]['kuantitas'] = $value->kuantitas;
            $waminta[$key]['barang'] = $value->barang_id;
        }


        //cek pembelian detail jumlah pembelian barang sesuai dengan permintaan
        $wapembelian = PembelianDetail::join('pembelian','pembelian.id','=','pembeliandetail.pembelian_id')
                                ->selectRaw('SUM(pembeliandetail.kuantitas) as qty, pembeliandetail.barang_id')
                                ->where('permintaan_id','=',$postData['permintaan_id'])
                                ->groupBy('barang_id')
                                ->get();

        $wastatus = array();
        foreach ($wapembelian as $key => $value) {
            $wadata[$key]['jumlah'] = $value->qty;

            // cek validasi kuantitas pembelian detail apakah sama dengan kuantitas gudminta
            if($waminta[$key]['kuantitas'] <= $wadata[$key]['jumlah']){
                $wastatus[] = 1;
            } else {
                $wastatus[] = 0;
            }
        }

        //perbaharui status
        if(array_sum($wastatus) == count($wastatus)){
            $purch = Gudmintastatus::where("gudminta_id", "=", $postData['permintaan_id'])->first();
            $purch->keterangan = "purchased";
            $purch->status = 1;
            $purch->save();
        }



        $this->session->setFlash('success', 'Data Telah Tersimpan');
        return $response->withRedirect($this->router->pathFor('daftar-pembelian'));

	}

	public function delete(Request $request, Response $response, Array $args)
	{
		if(@$args["id"] != ""){
            $purReq = Pembelian::find($args["id"]);

            // start logika update status dan hapus ke jurnal 
            // get permintaan_id
            $permintaan_id = Pembelian::where('id','=',$args['id'])->get();
            $perId = $permintaan_id[0]['permintaan_id'];
            $jurId = $permintaan_id[0]['jurnalid'];

            // hapus jurnal
            $jurnal = Accjurnal::find($jurId)->delete();
            $jurnaldetail = Accjurnaldetail::where('accjurnals_id','=',$jurId)->delete();

            // update startus gudminta
            $purch = Gudmintastatus::where("gudminta_id", "=", $perId)->first();
            $purch->keterangan = "requested";
            $purch->status = 0;
            $purch->save();
            // end logika update status
        }

        if($purReq != null){
            $purReq->delete();
            $details = PembelianDetail::where("pembelian_id","=",$args["id"])->delete();
            $req = PembelianStatus::where("pembelian_id","=",$args["id"])->delete();
        }

        $this->session->setFlash('success', 'Data Telah Terhapus');
        return $response->withRedirect($this->router->pathFor('daftar-pembelian'));

	}

    private function post_jurnal($postData){
        $jurnal=[
                "id"=>"",
                "code" => "",
                "tanggal" => date('Y-m-d', strtotime($postData['tanggal'])),
                "nobukti" => $postData['nobukti'],
                "keterangan" => "Pembelian",
                "details"=>[]
            ];

        $pembelian = (FormaterAdapter::reverse($postData['total_harga']) + FormaterAdapter::reverse($postData['ongkos']) + FormaterAdapter::reverse($postData['ppn_hasil'])) - FormaterAdapter::reverse($postData['diskon']);

        $jurnal["details"][]=[
            "accounts_id"=>Option::where("name","=","beban_pembelian")->first()->value,
            "debet"=> FormaterAdapter::reverse($pembelian),
            "kredit"=> 0
        ]; // beban pembelian

        $jurnal["details"][]=[
            "accounts_id"=>Option::where("name","=","kas")->first()->value,
            "debet"=> 0,
            "kredit"=> FormaterAdapter::reverse($postData['total_harga'])
        ]; // potongan pembelian


        $jurnal["details"][]=[
            "accounts_id"=>Option::where("name","=","o_kirim_pembelian")->first()->value,
            "debet"=> 0,
            "kredit"=>FormaterAdapter::reverse($postData['ongkos'])
        ]; // ongkos kirim

        $jurnal["details"][]=[
            "accounts_id"=>Option::where("name","=","ppn_beli")->first()->value,
            "debet"=> 0,
            "kredit"=> FormaterAdapter::reverse($postData['ppn_hasil'])
        ]; // simpan biaya ppn

        $jurnal["details"][]=[
            "accounts_id"=>Option::where("name","=","pot_pemb")->first()->value,
            "debet"=>FormaterAdapter::reverse($postData['diskon']),
            "kredit"=> 0
        ]; // potongan pembelian



        $Accprovider=new AccountingServiceProvider();

        $accounting=$Accprovider->jurnal_save($jurnal);

        if($accounting["stat"]=="error"){
            echo $accounting["mess"];
            return false;
        }

        //print_r($accounting);
        return $accounting["accjurnals_id"];
    }

    function convert_date($date){
            $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
            return $date;
        }
}
        
