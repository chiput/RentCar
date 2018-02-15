<?php

namespace App\Controller\Logistic;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Gudminta;
use App\Model\Gudmintastatus;
use App\Model\Gudmintadetail;
use App\Model\Barang;
use App\Model\Brgsatuan;
use App\Model\Department;
use App\Model\Konversi;
use Illuminate\Database\Capsule\Manager as DB;
use Kulkul\Options;

class PermintaanBarangController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }

        $data['d_start'] = date("d-m-Y");
        $data['d_end'] = date("d-m-Y");
        
        if($request->isPost()){
            $data = $request->getParsedBody();
        }
        $data['purReqs'] = Gudminta::whereBetween("tanggal",[convert_date($data['d_start']),convert_date($data['d_end'])])
                            ->orderBy("created_at","desc")->get();
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'logistic/purchase-request', $data);
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data["goods"] = Barang::all();
        $data["departments"] = Department::all();
        $data["units"] = Brgsatuan::all();
        $data["konversi"] = Konversi::all();

        if(@$args["id"] != ""){
            $data['purReq'] = Gudminta::find($args["id"]);
        } else {

            $purReq = Gudminta::where(DB::raw('left(nobukti,7)'), '=', 'MB.'.date('ym'))
                                ->orderBy('nobukti',"desc")->first();
            $data['purReq'] = (object)[];
            if($purReq == NULL){
                //$data['purReq']->nobukti = 'MB.'.date('ym').substr('0000'.(substr($purReq->nobukti,-4)*1+1),-4);
                $data['purReq']->nobukti = 'MB.'.date('ym').substr('0000'.(substr($purReq->nobukti,-4)*1+1),-4);
            }else{
                $data['purReq']->nobukti = substr($purReq->nobukti,0,7).substr('0000'.(substr($purReq->nobukti,-4)*1+1),-4);
                //$data['purReq']->nobukti = substr('0000'.(substr($purReq->nobukti,-4)*1+1),-4);
            }

        }

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['purReq'] = (object) $this->session->getFlash('post_data');
        }

        $data['app_profile'] = $this->app_profile;
        //print_r($data);
        return $this->renderer->render($response, 'logistic/purchase-request-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

         function convert_date($date){
                   $date = date("Y-m-d", strtotime($date));
                   return $date;
                }

        //Array ( [id] => [nobukti] => aaaa [department_id] => 1 [tanggal] => 2017-02-07 [keterangan] => asdasdasd [barang_id] => Array ( [0] => kasdkjsd ) [satuan_id] => Array ( [0] => 1 ) [kuantitas] => Array ( [0] => 0 ) )
        // validation
        $this->validation->validate([
            'tanggal|Tanggal' => [convert_date($postData['tanggal']), 'required'],
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
                return $response->withRedirect($this->router->pathFor('logistic-purchase-request-add'));
            } else {
                return $response->withRedirect($this->router->pathFor('logistic-purchase-request-edit',['id'=>$postData['id']]));
            }
        }

        if($postData['id'] != ""){
            $purReq = Gudminta::find($postData['id']);
            $purReq->users_id_edit = $this->session->get('activeUser')["id"];
            $detail = Gudmintadetail::where("gudminta_id","=",$postData['id'])->delete();
        } else {
            $purReq = new Gudminta();
            $purReq->users_id = $this->session->get('activeUser')["id"];
            $purReq->users_id_edit = 0;
        }

        $purReq->tanggal = convert_date($postData['tanggal']);
        $purReq->nobukti = $postData['nobukti'];
        $purReq->department_id = $postData['department_id'];
        $purReq->keterangan = $postData['keterangan'];
        $purReq->cetak = 0;
        $purReq->save();

        $purReq_id = $purReq->id;

        // simpan detail
        foreach($postData['barang_id'] as $key => $barang){
            $detail = new Gudmintadetail();
            $detail->gudminta_id = $purReq->id;
            $detail->barang_id = $barang;
            $detail->satuan_id = $postData["satuan_id"][$key];
            $detail->kuantitas = $postData["kuantitas"][$key];
            $detail->users_id = $this->session->get('activeUser')["id"];
            $detail->save();
        }

        if($postData['id'] != "") {
            $reqstatus = Gudmintastatus::where("gudminta_id","=",$purReq_id)->first();
            $reqstatus->users_id_edit = $this->session->get('activeUser')["id"];
        } else {
            $reqstatus = new Gudmintastatus();
            $reqstatus->users_id = $this->session->get('activeUser')["id"];
            $reqstatus->users_id_edit = 0;
        }

        $reqstatus->gudminta_id = $purReq_id;
        $reqstatus->tanggal =  convert_date($postData['tanggal']);
        $reqstatus->keterangan = "requested";
        $reqstatus->status = 0;
        $reqstatus->save();

        $this->session->setFlash('success', 'Data telah tersimpan');

        if($postData['vad'] == 'request'){
            return $response->withRedirect($this->router->pathFor('logistic-purchase-request-request'));
        } else { 
            return $response->withRedirect($this->router->pathFor('logistic-purchase-request'));
        }
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        if(@$args["id"] != ""){
            $purReq = Gudminta::find($args["id"]);
        }
        if($purReq != null){
            $purReq->delete();
            $details = Gudmintadetail::where("gudminta_id","=",$args["id"])->delete();
            $reqstatus = Gudmintastatus::where("gudminta_id","=",$args["id"])->delete();
        }

        $this->session->setFlash('success', 'Data telah terhapus');
        return $response->withRedirect($this->router->pathFor('logistic-purchase-request'));
    }

    public function report(Request $request, Response $response, Array $args)
    {


        $data['purReq'] = Gudminta::find($args["id"]);
        $data['options'] = Options::all();
        // print_r(Options::all());
        // return $response;
        return $this->renderer->render($response, 'logistic/reports/purchase-request-report', $data);
    }

    public function posted(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();
        $jurnal=Gudminta::find($postData["id"]);
        $jurnal->status=$postData["posted"];
        $jurnal->save();
        return $response;
    }

    public function status(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();
        $jurnal=Gudminta::find($args["id"]);
        $jurnal->status=0;
        $jurnal->save();

        $this->session->setFlash('success', 'Data telah direset');
        return $response->withRedirect($this->router->pathFor('logistic-purchase-request'));
    }
}
