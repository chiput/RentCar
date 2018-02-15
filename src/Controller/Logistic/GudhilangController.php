<?php

namespace App\Controller\Logistic;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Gudhilang;
use App\Model\Gudhilangdetail;
use App\Model\Barang;
use App\Model\Option;
use App\Model\Brgsatuan;
use App\Model\Gudang;
use Illuminate\Database\Capsule\Manager as DB;
use Kulkul\Options;
use Kulkul\LogisticStock\LogisticStockProvider; 
use Kulkul\Accounting\AccountingServiceProvider;

class GudhilangController extends Controller 
{
    public function __invoke(Request $request, Response $response, Array $args)
    {

        $data['d_start'] = date("d-m-Y");
        $data['d_end'] = date("d-m-Y");
        $data["warehouses"] = Gudang::all();

        if($request->isPost()){
            $data = $request->getParsedBody();
        }
        $data['items'] = Gudhilang::whereBetween("tanggal",[$this->convert_date($data['d_start']), $this->convert_date($data['d_end'])])
                            ->orderBy("created_at","desc")->get();
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'logistic/loss-item', $data);   
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data["goods"] = Barang::all();
        $data["units"] = Brgsatuan::all();


        $query = $request->getQueryParams();


        if(@$args["id"] != ""){
            $data['item'] = Gudhilang::find($args["id"]);
            $data["warehouses"] = Gudang::where('id',$data['item']->gudang_id)->get();
            $date = $data['item']->tanggal;
            $gudang_id = $data['item']->gudang_id;
        } else {
            
            if(!isset($query['gudang_id']) || !isset($query['tanggal'])) 
            return $response->withRedirect($this->router->pathFor('logistic-loss-item'));

            $item = Gudhilang::where(DB::raw('left(nobukti,7)'), '=', 'GH.'.date('ym'))
                                ->orderBy('nobukti',"desc")->first();
            if($item == NULL){
                @$data['item']->nobukti = 'GH.'.date('ym').substr('0000'.(substr($item->nobukti,-4)*1+1),-4);
            }else{
                @$data['item']->nobukti = substr($item->nobukti,0,7).substr('0000'.(substr($item->nobukti,-4)*1+1),-4);
            }
            
            $data['item']->tanggal = $query['tanggal'];
            $data["warehouses"] = Gudang::where('id',$query['gudang_id'])->get();

            $date = $this->convert_date($query['tanggal']);
            $gudang_id = $query['gudang_id'];

        }

        $stock = new LogisticStockProvider();
        $data['stock'] = $stock->getStock($date, $gudang_id, 0, 0, 2);

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['item'] = (object) $this->session->getFlash('post_data');
        }
        
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'logistic/loss-item-form', $data);   
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

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
                return $response->withRedirect($this->router->pathFor('logistic-loss-item-add'));
            } else {
                return $response->withRedirect($this->router->pathFor('logistic-loss-item-edit',['id'=>$postData['id']]));
            }
        }
        
        if($postData['id'] != ""){

            
            $item = Gudhilang::find($postData['id']);
            // var_dump($item->accjurnal_id); return $response;
            $Accprovider = new AccountingServiceProvider();
            $res = $Accprovider->jurnal_delete($item->accjurnal_id);
            $item->users_id_edit = $this->session->get('activeUser')["id"];
            
            $detail = Gudhilangdetail::where("gudhilang_id","=",$postData['id'])->delete();
            

        } else {
            $item = new Gudhilang();
            $item->users_id = $this->session->get('activeUser')["id"];
            $item->users_id_edit = 0;            
        }

        $jurnal_id = $this->post_jurnal($postData);

        if(!$jurnal_id){
            $this->session->setFlash('error_messages', "Error Posting jurnal");
            $this->session->setFlash('post_data', $postData);
            if ($postData['id'] == '') return $response->withRedirect($this->router->pathFor('logistic-loss-item-add'));
                
            return $response->withRedirect($this->router->pathFor('logistic-loss-item-edit',['id'=>$postData['id']]));
        }


        $item->tanggal = $this->convert_date($postData['tanggal']);
        $item->nobukti = $postData['nobukti'];
        $item->gudang_id = $postData['gudang_id'];
        $item->keterangan = $postData['keterangan'];
        $item->accjurnal_id = $jurnal_id;
        $item->cetak = 0;
        $item->save();

        $item_id = $item->id;
        
        // simpan detail
        foreach($postData['barang_id'] as $key => $barang){
            $detail = new Gudhilangdetail();
            $detail->gudhilang_id = $item->id;
            $detail->barang_id = $barang;
            $detail->satuan_id = $postData["satuan_id"][$key];
            $detail->kuantitas = $postData["kuantitas"][$key];
            $detail->save();
        }
        
        $this->session->setFlash('success', 'Data telah tersimpan');
        return $response->withRedirect($this->router->pathFor('logistic-loss-item'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        if(@$args["id"] != ""){
            $item = Gudhilang::find($args["id"]);
            $Accprovider = new AccountingServiceProvider();
            $res = $Accprovider->jurnal_delete($item->accjurnal_id);
        }
        if($item != null){
            $item->delete();
            $details = Gudhilangdetail::where("gudhilang_id","=",$args["id"])->delete();
        }

        $this->session->setFlash('success', 'Data telah terhapus');
        return $response->withRedirect($this->router->pathFor('logistic-loss-item'));
    }

    public function report(Request $request, Response $response, Array $args)
    {
        
        $data['item'] = Gudhilang::find($args["id"]);
        $data['options'] = Options::all();
        return $this->renderer->render($response, 'logistic/reports/loss-item-report', $data);   
    }

    public function report_all(Request $request, Response $response, Array $args)
    {
        
        if($request->isPost()){
            $post = $request->getParsedBody();
            $data = $post;
            $data['items'] = Gudhilang::whereBetween('tanggal',[$this->convert_date($post["d_start"]),$this->convert_date($post["d_end"])])->get();
            $data['options'] = Options::all();
            return $this->renderer->render($response, 'logistic/reports/loss-item-report-all', $data);  
        } else {
            $data['app_profile'] = $this->app_profile;
            return $this->renderer->render($response, 'logistic/reports/loss-item-report-form', $data);   
        }
         
    }

    private function post_jurnal($postData)
    {
        $data=[ 
                "code" => "",
                "tanggal" => $postData['tanggal'],
                "nobukti" => @$postData['nobukti'],
                "keterangan" => 'Barang Hiang / Rusak '.@$postData['nobukti'].'. '.@$postData['keterangan'],
                "details"=>[]
            ];
        $total = 0;
        foreach($postData['barang_id'] as $key => $barang){
            $harga = implode("",explode(".",$postData['hargastok'][$key])) * $postData['kuantitas'][$key];
            $total+=$harga;
            
        }

        $data["details"][]=["accounts_id"=>Option::where("name","=","biaya_barang_rusak")->first()->value,
                                "debet"=>$total,
                                "kredit"=>0
                                ];

        $data["details"][]=["accounts_id"=>Option::where("name","=","beban_pembelian")->first()->value,
                            "debet"=>0,
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