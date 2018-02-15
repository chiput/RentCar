<?php

namespace App\Controller\Logistic;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Gudterima;
use App\Model\Gudterimadetail;
use App\Model\PembelianDetail;
use App\Model\PembelianStatus;
use App\Model\Pembelian;
use App\Model\Barang;
use App\Model\Brgsatuan;
use App\Model\Gudang;
use App\Model\Account;
use Illuminate\Database\Capsule\Manager as DB;
use Kulkul\Options;

class GudterimaController extends Controller 
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['d_start'] = date("d-m-Y");
        $data['d_end'] = date("d-m-Y");
        if($request->isPost()){
            $data = $request->getParsedBody();
        }
        $data['receives'] = Gudterima::whereBetween("tanggal",[$this->convert_date($data['d_start']),$this->convert_date($data['d_end'])])
                            ->orderBy("created_at","desc")->get();
        //$data["purchases"] = Pembelian::orderBy("nobukti","desc")->get();
        $data["purchases"] = PembelianStatus::where("status", "=", 0)->orderBy("id", "desc")->get();
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'logistic/receive', $data);   
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data["goods"] = Barang::all();
        $data["warehouses"] = Gudang::all();
        $data["units"] = Brgsatuan::all();
        $data["accounts"] = Account::all();
        

        if(@$args["id"] != ""){
            $data['receive'] = Gudterima::find($args["id"]);
            $data["purchase"] = Pembelian::find($data['receive']->pembelian_id);
        } else {
            $data["purchase"] = Pembelian::find(@$args['pembelian_id']);

            $receive = Gudterima::where(DB::raw('left(nobukti,7)'), '=', 'TB.'.date('ym'))
                                ->orderBy('nobukti',"desc")->first();

            if($receive == NULL){
                @$data['receive']->nobukti = 'TB.'.date('ym').substr('0000'.(substr($receive->nobukti,-4)*1+1),-4);
            }else{
                @$data['receive']->nobukti = substr($receive->nobukti,0,7).substr('0000'.(substr($receive->nobukti,-4)*1+1),-4);
            }
            
        }

        $data["receive_total"] = $this->receive_total($data["purchase"]->id);

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['receive'] = (object) $this->session->getFlash('post_data');
        }
        
        $data['app_profile'] = $this->app_profile;
        //print_r($data);
        return $this->renderer->render($response, 'logistic/receive-form', $data);   
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        function convert_date($date){
                    $date = date("Y-m-d", strtotime($date));
                    return $date;
                } 

        // validation
        $this->validation->validate([
            'tanggal|Tanggal' => [$postData['tanggal'], 'required'],
            'nobukti|No. Bukti' => [$postData['nobukti'], 'required'],
        ]);
        if (!$this->validation->passes() || count($postData["barang_id"])<1) {

            if(count($postData["barang_id"])<1){
                $this->session->setFlash('error_messages', ['Minimal 1 barang']);
            }else{
                $this->session->setFlash('error_messages', $this->validation->errors()->all());
            } 
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('logistic-receive-add',['pembelian_id'=>$postData['purchase_id']]));
            } else {
                return $response->withRedirect($this->router->pathFor('logistic-receive-edit',['id'=>$postData['id']]));
            }
        }
        
        if($postData['id'] != ""){
            $receive = Gudterima::find($postData['id']);
            $receive->users_id_edit = $this->session->get('activeUser')["id"];
            $detail = Gudterimadetail::where("gudterima_id","=",$postData['id'])->delete();
        } else {
            $receive = new Gudterima();
            $receive->users_id = $this->session->get('activeUser')["id"];
            $receive->users_id_edit = 0;            
        }
                
        $receive->tanggal = convert_date($postData['tanggal']);
        $receive->nobukti = $postData['nobukti'];
        $receive->gudang_id = $postData['gudang_id'];
        $receive->pembelian_id = $postData['pembelian_id'];
        $receive->keterangan = $postData['keterangan'];
        $receive->save();

        $receive_id = $receive->id;
        
        // simpan detail
        foreach($postData['barang_id'] as $key => $barang){
            $detail = new Gudterimadetail();
            $detail->gudterima_id = $receive_id;
            $detail->barang_id = $barang;
            $detail->satuan_id = $postData["satuan_id"][$key];
            $detail->tglexpired = $postData["tglexpired"][$key] == "" ? null : $postData["tglexpired"][$key];
            $detail->kuantitas = floatval($postData["kuantitas"][$key]) <= 0 ? 0 : floatval(@$postData["kuantitas"][$key]);
            $detail->save();
        }

        $purchased = 0;
        $count = 0;
        foreach ($postData['barang_id'] as $key => $barang) {
            $mintastatus = PembelianDetail::where("pembelian_id", "=", $postData['pembelian_id'])->where("barang_id", "=", $barang)->where("kuantitas", "=", floatval($postData["kuantitas"][$key]) <= 0 ? 0 : floatval(@$postData["kuantitas"][$key]))->get();
            $count += 1;

            if(!$mintastatus->isEmpty()) {
                $purchased += 1;
            }
        }


        if($count == $purchased) {
            $minta = PembelianStatus::where("pembelian_id", "=", $postData['pembelian_id'])->first();
            $minta->keterangan = "done";
            $minta->status = 1;
            $minta->save();
        }

        //merubah keterangan dan status di pembelianstatus

        //cek gudang minta detail kuantitas minta
        $wapebeliandetail = PembelianDetail::where("pembelian_id", "=", $postData['pembelian_id'])->get();

        foreach ($wapebeliandetail as $key => $value) {
            $wapembeli[$key]['kuantitas'] = $value->kuantitas;
        }


        //cek pembelian detail jumlah pembelian barang sesuai dengan permintaan
        $wapembelian = Gudterimadetail::join('gudterima','gudterima.id','=','gudterimadetail.gudterima_id')
                                ->selectRaw('SUM(gudterimadetail.kuantitas) as qty, gudterimadetail.barang_id')
                                ->where('pembelian_id','=',$postData['pembelian_id'])
                                ->groupBy('barang_id')
                                ->get();

        $wastatus = array();
        foreach ($wapembelian as $key => $value) {
            $wadata[$key]['jumlah'] = $value->qty;
            // cek validasi kuantitas pembelian detail apakah sama dengan kuantitas gudminta
            if($wapembeli[$key]['kuantitas'] != 0){
                if($wapembeli[$key]['kuantitas'] == $wadata[$key]['jumlah']){
                    $wastatus[] = 1;
                } else {
                    $wastatus[] = 0;
                }
            } else if($wapembeli[$key]['kuantitas'] == 0){
                $wastatus[] = 1;
            }

            
        }

        //perbaharui status
        if(array_sum($wastatus) == count($wastatus)){
            $pminta = PembelianStatus::where("pembelian_id", "=", $postData['pembelian_id'])->first();
            $pminta->keterangan = "done";
            $pminta->status = 1;
            $pminta->save();
        }
        
        $this->session->setFlash('success', 'Data telah tersimpan');
        return $response->withRedirect($this->router->pathFor('logistic-receive'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        if(@$args["id"] != ""){
            $receive = Gudterima::find($args["id"]);
        }
        if($receive != null){
            $receive->delete();
            $details = Gudterimadetail::where("gudterima_id","=",$args["id"])->delete();
        }

        $this->session->setFlash('success', 'Data telah terhapus');
        return $response->withRedirect($this->router->pathFor('logistic-receive'));
    }

    public function report(Request $request, Response $response, Array $args)
    {
        

        $data['receive'] = Gudterima::find($args["id"]);
        $data['options'] = Options::all();
        // print_r(Options::all());
        // return $response;
        return $this->renderer->render($response, 'logistic/reports/receive-report', $data);   
    }

    public function report_all(Request $request, Response $response, Array $args)
    {
        if($request->isPost()){
            $post = $request->getParsedBody();
            $data = $post;

            $data['receives'] = Gudterima::whereBetween('tanggal',[$this->convert_date($post["d_start"]),$this->convert_date($post["d_end"])])->get();
            $data['options'] = Options::all();
            return $this->renderer->render($response, 'logistic/reports/receive-report-all', $data);  
        } else {
            $data['app_profile'] = $this->app_profile;
            return $this->renderer->render($response, 'logistic/reports/receive-report-form', $data);   
        }
         
    }


    public function receive_total($pembelian_id)
    {
        $receiveDetails = Gudterimadetail::whereHas('gudterima', function ($query) use($pembelian_id){
                                $query->where('pembelian_id', '=', $pembelian_id);
                            })
                            ->selectRaw('barang_id, sum(kuantitas) as kuantitas')
                            ->groupBy('barang_id')
                            ->get();
        $total=[];
        foreach($receiveDetails as $detail){
            $total[$detail->barang_id] = $detail->kuantitas;
        }
        return $total;

    }

    private function convert_date($date){
            $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
            return $date;
        }
    
}