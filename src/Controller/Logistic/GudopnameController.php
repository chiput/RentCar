<?php

namespace App\Controller\Logistic;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Gudopname;
use App\Model\Gudopnamedetail;
use App\Model\Barang;
use App\Model\Brgsatuan;
use App\Model\Gudang;
use Illuminate\Database\Capsule\Manager as DB;
use Kulkul\Options;

class GudopnameController extends Controller 
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
        $data['stocks'] = Gudopname::whereBetween("tanggal",[convert_date($data['d_start']),convert_date($data['d_end'])])
                            ->orderBy("created_at","desc")->get();
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'logistic/stocktaking', $data);   
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data["goods"] = Barang::all();
        $data["warehouses"] = Gudang::all();
        $data["units"] = Brgsatuan::all();

        if(@$args["id"] != ""){
            $data['stock'] = Gudopname::find($args["id"]);
        } else {
            
            $stock = Gudopname::where(DB::raw('left(nobukti,7)'), '=', 'MB.'.date('ym'))
                                ->orderBy('nobukti',"desc")->first();
            if($stock == NULL){
                @$data['stock']->nobukti = 'SO.'.date('ym').substr('0000'.(substr($stock->nobukti,-4)*1+1),-4);
            }else{
                @$data['stock']->nobukti = substr($stock->nobukti,0,7).substr('0000'.(substr($stock->nobukti,-4)*1+1),-4);
            }
            
        }

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['stock'] = (object) $this->session->getFlash('post_data');
        }
        
        $data['app_profile'] = $this->app_profile;
        //print_r($data);
        return $this->renderer->render($response, 'logistic/stocktaking-form', $data);   
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

        //Array ( [id] => [nobukti] => aaaa [department_id] => 1 [tanggal] => 2017-02-07 [keterangan] => asdasdasd [barang_id] => Array ( [0] => kasdkjsd ) [satuan_id] => Array ( [0] => 1 ) [kuantitas] => Array ( [0] => 0 ) )
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
                return $response->withRedirect($this->router->pathFor('logistic-stocktaking-add'));
            } else {
                return $response->withRedirect($this->router->pathFor('logistic-stocktaking-edit',['id'=>$postData['id']]));
            }
        }
        
        if($postData['id'] != ""){
            $stock = Gudopname::find($postData['id']);
            $stock->users_id_edit = $this->session->get('activeUser')["id"];
            $detail = Gudopnamedetail::where("Gudopname_id","=",$postData['id'])->delete();
        } else {
            $stock = new Gudopname();
            $stock->users_id = $this->session->get('activeUser')["id"];
            $stock->users_id_edit = 0;            
        }
                
        $stock->tanggal = convert_date($postData['tanggal']);
        $stock->nobukti = $postData['nobukti'];
        $stock->gudang_id = $postData['gudang_id'];
        $stock->keterangan = $postData['keterangan'];
        $stock->cetak = 0;
        $stock->save();

        $stock_id = $stock->id;
        
        // simpan detail
        foreach($postData['barang_id'] as $key => $barang){
            $detail = new Gudopnamedetail();
            $detail->gudopname_id = $stock->id;
            $detail->barang_id = $barang;
            $detail->satuan_id = $postData["satuan_id"][$key];
            $detail->kuantitas = $postData["kuantitas"][$key];
            $detail->users_id = $this->session->get('activeUser')["id"];
            $detail->save();
        }
        
        $this->session->setFlash('success', 'Data telah tersimpan');
        return $response->withRedirect($this->router->pathFor('logistic-stocktaking'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        if(@$args["id"] != ""){
            $stock = Gudopname::find($args["id"]);
        }
        if($stock != null){
            $stock->delete();
            $details = Gudopnamedetail::where("gudopname_id","=",$args["id"])->delete();
        }

        $this->session->setFlash('success', 'Data telah terhapus');
        return $response->withRedirect($this->router->pathFor('logistic-stocktaking'));
    }

    public function report(Request $request, Response $response, Array $args)
    {
        

        $data['stock'] = Gudopname::find($args["id"]);
        $data['options'] = Options::all();
        return $this->renderer->render($response, 'logistic/reports/stocktaking-report', $data);   
    }
}