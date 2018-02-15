<?php

namespace App\Controller\Logistic;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Gudpindah;
use App\Model\Gudpindahdetail;
use App\Model\Barang;
use App\Model\Brgsatuan;
use App\Model\Gudang;
use Illuminate\Database\Capsule\Manager as DB;
use Kulkul\Options;
use Kulkul\LogisticStock\LogisticStockProvider; 


class GudpindahController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['d_start'] = date("d-m-Y");
        $data['d_end'] = date("d-m-Y");
        $data["warehouses"] = Gudang::all();
        
        if($request->isPost()){
            $data = $request->getParsedBody();
        }
        $data['mutations'] = Gudpindah::whereBetween("tanggal",[$this->convert_date($data['d_start']),$this->convert_date($data['d_end'])])
                            ->orderBy("created_at","desc")->get();
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'logistic/mutation', $data);
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data["goods"] = Barang::all();
        $data["warehouses_to"] = Gudang::all();
        $data["units"] = Brgsatuan::all();
        $query = $request->getQueryParams();


        if(@$args["id"] != ""){
            $data['mutation'] = Gudpindah::find($args["id"]);
            $data["warehouses_from"] = Gudang::where('id',$data['mutation']->gudang_id1)->get();
            $date = $data['mutation']->tanggal;
            $gudang_id = $data['mutation']->gudang_id1;
            
        } else {

            $mutation = Gudpindah::where(DB::raw('left(nobukti,7)'), '=', 'MG.'.date('ym'))
                                ->orderBy('nobukti',"desc")->first();
            if($mutation == NULL){
                @$data['mutation']->nobukti = 'MG.'.date('ym').substr('0000'.(substr($mutation->nobukti,-4)*1+1),-4);
            }else{
                @$data['mutation']->nobukti = substr($mutation->nobukti,0,7).substr('0000'.(substr($mutation->nobukti,-4)*1+1),-4);
            }
            $data["warehouses_from"] = Gudang::where('id',$query['gudang_id'])->get();

            $date = $this->convert_date($query['tanggal']);
            $gudang_id = $query['gudang_id'];

        }

        $stock = new LogisticStockProvider();
        $data['stock'] = $stock->getStock($date, $gudang_id, 0, 0, 2);

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['mutation'] = (object) $this->session->getFlash('post_data');
        }

        $data['app_profile'] = $this->app_profile;
        //print_r($data);
        return $this->renderer->render($response, 'logistic/mutation-form', $data);
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

        // var_dump($postData); return $response;
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
                return $response->withRedirect($this->router->pathFor('logistic-mutation-add'));
            } else {
                return $response->withRedirect($this->router->pathFor('logistic-mutation-edit',['id'=>$postData['id']]));
            }
        }

        if($postData['id'] != ""){
            $mutation = Gudpindah::find($postData['id']);
            $mutation->users_id_edit = $this->session->get('activeUser')["id"];
            $detail = Gudpindahdetail::where("Gudpindah_id","=",$postData['id'])->delete();
        } else {
            $mutation = new Gudpindah();
            $mutation->users_id = $this->session->get('activeUser')["id"];
            $mutation->users_id_edit = 0;
        }

        $mutation->tanggal = $this->convert_date($postData['tanggal']);
        $mutation->nobukti = $postData['nobukti'];
        $mutation->gudang_id1 = $postData['gudang_id1'];
        $mutation->gudang_id2 = $postData['gudang_id2'];
        $mutation->keterangan = $postData['keterangan'];
        $mutation->cetak = 0;
        $mutation->save();

        $mutation_id = $mutation->id;

        // simpan detail
        foreach($postData['barang_id'] as $key => $barang){
            $detail = new Gudpindahdetail();
            $detail->gudpindah_id = $mutation->id;
            $detail->barang_id = $barang;
            $detail->brgsatuan_id = $postData["brgsatuan_id"][$key];
            $detail->kuantitas = $postData["kuantitas"][$key];
            $detail->save();
        }

        $this->session->setFlash('success', 'Data telah tersimpan');
        return $response->withRedirect($this->router->pathFor('logistic-mutation'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        if(@$args["id"] != ""){
            $mutation = Gudpindah::find($args["id"]);
        }
        if($mutation != null){
            $mutation->delete();
            $details = Gudpindahdetail::where("Gudpindah_id","=",$args["id"])->delete();
        }

        $this->session->setFlash('success', 'Data telah terhapus');
        return $response->withRedirect($this->router->pathFor('logistic-mutation'));
    }

    public function report(Request $request, Response $response, Array $args)
    {

        $data['mutation'] = Gudpindah::find($args["id"]);
        $data['options'] = Options::all();
        // print_r(Options::all());
        // return $response;
        return $this->renderer->render($response, 'logistic/reports/mutation-report', $data);
    }

    public function report_all(Request $request, Response $response, Array $args)
    {
        if($request->isPost()){
            $post = $request->getParsedBody();
            $data = $post;
            $data['mutations'] = Gudpindah::whereBetween('tanggal',[$this->convert_date($post["d_start"]),$this->convert_date($post["d_end"])])->get();
            $data['options'] = Options::all();
            return $this->renderer->render($response, 'logistic/reports/mutation-report-all', $data);
        } else {
            $data['app_profile'] = $this->app_profile;
            return $this->renderer->render($response, 'logistic/reports/mutation-report-form', $data);
        }
    }

    private function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
         
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }
}
