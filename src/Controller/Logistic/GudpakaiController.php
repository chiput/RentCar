<?php

namespace App\Controller\Logistic;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Gudpakai;
use App\Model\Gudpakaidetail;
use App\Model\Barang;
use App\Model\Brgsatuan;
use App\Model\Gudang;
use App\Model\Option;
use App\Model\Account;
use App\Model\Gudminta;
use App\Model\Gudmintadetail;
use Illuminate\Database\Capsule\Manager as DB;
use Kulkul\LogisticStock\LogisticStockProvider; // provider hitung stok akhir
use Kulkul\Options;
use Kulkul\Accounting\AccountingServiceProvider;


class GudpakaiController extends Controller
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
        $data["warehouses"] = Gudang::all();

        if($request->isPost()){
            $data = $request->getParsedBody();
        }
        $data['usages'] = Gudpakai::whereBetween("tanggal",[$this->convert_date($data['d_start']),$this->convert_date($data['d_end'])])
                            ->orderBy("created_at","desc")->get();
        $data['app_profile'] = $this->app_profile;
        $data['puReq'] = Gudminta::where('status','=',2)->orderBy('id','DESC')->where('pemakstatus','=',0)->get();
        return $this->renderer->render($response, 'logistic/usage', $data);
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data["goods"] = Barang::all();
        $data["units"] = Brgsatuan::all();
        $data["accounts"] = Account::all();

        $query = $request->getQueryParams();

        if(@$args["id"] != ""){

            $data['usage'] = Gudpakai::find($args["id"]);
            $data["warehouses"] = Gudang::where('id',$data['usage']->gudang_id)->get();
            $date = $data['usage']->tanggal;
            $gudang_id = $data['usage']->gudang_id;

        } else {

            if(!isset($query['gudang_id']) || !isset($query['tanggal']))
            return $response->withRedirect($this->router->pathFor('logistic-usage'));

            $usage = Gudpakai::where(DB::raw('left(nobukti,7)'), '=', 'PB.'.date('ym'))
                                ->orderBy('nobukti',"desc")->first();
            if($usage == NULL){
                @$data['usage']->nobukti = 'PB.'.date('ym').substr('0000'.(substr($usage->nobukti,-4)*1+1),-4);
            }else{
                @$data['usage']->nobukti = substr($usage->nobukti,0,7).substr('0000'.(substr($usage->nobukti,-4)*1+1),-4);
            }

            $data['usage']->tanggal = $query['tanggal'];
            $data["warehouses"] = Gudang::where('id',$query['gudang_id'])->get();
            $data['request'] = Gudmintadetail::where('gudminta_id','=',$query['request_id'])->get();

            $date = $this->convert_date($query['tanggal']);
            $gudang_id = $query['gudang_id'];
            $data['gudminta'] = $query['request_id'];
        }

        $stock = new LogisticStockProvider();

        $data['stock'] = $stock->getStock($date, $gudang_id, 0, 0, 2); // cek stok pada gudang dan tanggal tertentu
        // echo "<pre>";
        // var_dump($data['stock']['categories']);
        // echo "</pre>";
        
        // return false;
        
        // $data = $stock->getStock(date("Y-m-t",strtotime($postData["year"].'-'.$postData["month"].'-01'))
        //                             , $postData['gudang_id'], $postData['kategori_id'], $postData['barang_id'], $postData['stok']);

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['usage'] = (object) $this->session->getFlash('post_data');
        }

        $data['app_profile'] = $this->app_profile;
        //print_r($data);
        return $this->renderer->render($response, 'logistic/usage-form', $data);
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

            if ($postData['id'] == '') return $response->withRedirect($this->router->pathFor('logistic-usage-add'));

            return $response->withRedirect($this->router->pathFor('logistic-usage-edit',['id'=>$postData['id']]));
        }

        if($postData['id'] != ""){
            $usage = Gudpakai::find($postData['id']);
            $usage->users_id_edit = $this->session->get('activeUser')["id"];
            $detail = Gudpakaidetail::where("Gudpakai_id","=",$postData['id'])->delete();

            $Accprovider = new AccountingServiceProvider();
            $res = $Accprovider->jurnal_delete($usage->accjurnal_id);

        } else {
            $usage = new Gudpakai();
            $usage->users_id = $this->session->get('activeUser')["id"];
            $usage->users_id_edit = 0;
        }


        $usage->tanggal = convert_date($postData['tanggal']);
        $usage->nobukti = $postData['nobukti'];
        $usage->gudang_id = $postData['gudang_id'];
        $usage->keterangan = $postData['keterangan'];
        $usage->save();

        $usage_id = $usage->id;

        // simpan detail
        foreach($postData['barang_id'] as $key => $barang){
            $detail = new Gudpakaidetail();
            $detail->gudpakai_id = $usage_id;
            $detail->barang_id = $barang;
            $detail->satuan_id = $postData["satuan_id"][$key];
            $detail->kuantitas = $postData["kuantitas"][$key];
            $detail->account_id = 0;
            $detail->save();
        }

        $mintak = Gudminta::find($postData['gudminta']);
        $mintak->pemakstatus = 1;
        $mintak->save();

        $this->session->setFlash('success', 'Data telah tersimpan');
        return $response->withRedirect($this->router->pathFor('logistic-usage'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        if(@$args["id"] != ""){
            $usage = Gudpakai::find($args["id"]);
        }
        if($usage != null){
            $Accprovider = new AccountingServiceProvider();
            $res = $Accprovider->jurnal_delete($usage->accjurnal_id);

            $usage->delete();
            $details = Gudpakaidetail::where("Gudpakai_id","=",$args["id"])->delete();
        }

        $this->session->setFlash('success', 'Data telah terhapus');
        return $response->withRedirect($this->router->pathFor('logistic-usage'));
    }

    public function report(Request $request, Response $response, Array $args)
    {


        $data['usage'] = Gudpakai::find($args["id"]);
        $data['options'] = Options::all();
        // print_r(Options::all());
        // return $response;
        return $this->renderer->render($response, 'logistic/reports/usage-report', $data);
    }

    public function report_all(Request $request, Response $response, Array $args)
    {
        if($request->isPost()){
            $post = $request->getParsedBody();
            $data = $post;
            $data['usages'] = Gudpakai::whereBetween('tanggal',[$this->convert_date($post["d_start"]),$this->convert_date($post["d_end"])])->get();
            if($post['gudang_id'] != 0){
                $data['usages'] = Gudpakai::whereBetween('tanggal',[$this->convert_date($post["d_start"]),$this->convert_date($post["d_end"])])->where('gudang_id','=',$post['gudang_id'])->get();
            }
            $data['options'] = Options::all();
            return $this->renderer->render($response, 'logistic/reports/usage-report-all', $data);
        } else {
            $data['app_profile'] = $this->app_profile;
            $data["warehouses"] = Gudang::all();
            return $this->renderer->render($response, 'logistic/reports/usage-report-form', $data);
        }

    }

    private function post_jurnal($postData)
    {
        $data=[
                "code" => "",
                "tanggal" => $postData['tanggal'],
                "nobukti" => @$postData['nobukti'],
                "keterangan" => 'Pemakaian Barang '.@$postData['nobukti'].'. '.@$postData['keterangan'],
                "details"=>[]
            ];
        $total = 0;
        foreach($postData['barang_id'] as $key => $barang){
            $harga = implode("",explode(".",$postData['hargastok'][$key])) * $postData['kuantitas'][$key];
            $total+=$harga;
            $data["details"][]=["accounts_id"=>$postData['account_id'][$key],
                                "debet"=>$harga,
                                "kredit"=>0
                                ];
        }

        $data["details"][]=["accounts_id"=>Option::where("name","=","beban_pembelian")->first()->value,
                            "debet"=>'0',
                            "kredit"=>$total
                            ];

        $Accprovider=new AccountingServiceProvider();

        $accounting=$Accprovider->jurnal_save($data);

        if($accounting["stat"]=="error"){
        	echo $accounting["mess"];
        	return false;
        }

        //print_r($accounting);
        return $accounting["accjurnals_id"];
    }

    private function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
         
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }
}
