<?php

namespace App\Controller\Logistic;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Gudrevisi;
use App\Model\Gudrevisidetail;
use App\Model\Barang;
use App\Model\Brgsatuan;
use App\Model\Gudang;
use App\Model\Account;
use App\Model\Option;
use Illuminate\Database\Capsule\Manager as DB;
use Kulkul\Options;
use Kulkul\Accounting\AccountingServiceProvider;


class GudrevisiController extends Controller 
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['d_start'] = date("d-m-Y");
        $data['d_end'] = date("d-m-Y");
        if($request->isPost()){
            $data = $request->getParsedBody();
        }

        $data["warehouses"] = Gudang::all();

        $data['revisions'] = Gudrevisi::whereBetween("tanggal",[$this->convert_date($data['d_start']),$this->convert_date($data['d_end'])])
                            ->orderBy("created_at","desc")->get();
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'logistic/revision', $data);   
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data["goods"] = Barang::all();
        $data["warehouses"] = Gudang::all();
        $data["units"] = Brgsatuan::all();
        $data["accounts"] = Account::all();

        $query = $request->getQueryParams();

        if(@$args["id"] != ""){
            $data['revision'] = Gudrevisi::find($args["id"]);
        } else {
            
            $revision = Gudrevisi::where(DB::raw('left(nobukti,7)'), '=', 'GR.'.date('ym'))
                                ->orderBy('nobukti',"desc")->first();
            if($revision == NULL){
                @$data['revision']->nobukti = 'GR.'.date('ym').substr('0000'.(substr($revision->nobukti,-4)*1+1),-4);
            }else{
                @$data['revision']->nobukti = substr($revision->nobukti,0,7).substr('0000'.(substr($revision->nobukti,-4)*1+1),-4);
            }
            

            // new logik tampil data barang
            $data['data'] = Barang::leftJoin('gudterimadetail','gudterimadetail.barang_id','=','barang.id')
                                    ->leftjoin('gudterima','gudterima.id','=','gudterimadetail.gudterima_id')
                                    ->leftJoin('gudpindahdetail','gudpindahdetail.barang_id','=','barang.id')
                                    ->leftjoin('gudpindah','gudpindah.id','=','gudpindahdetail.gudpindah_id')
                                    ->leftJoin('gudrevisidetail','gudrevisidetail.barang_id','=','barang.id')
                                    ->leftjoin('gudrevisi','gudrevisi.id','gudrevisidetail.gudrevisi_id')
                                    ->join('brgsatuan','brgsatuan.id','=','barang.brgsatuan_id')
                                    ->select('barang.*','brgsatuan.nama as satuan','gudterima.gudang_id as gud1','gudpindah.gudang_id2 as gud2','gudrevisi.gudang_id as gud3')
                                    ->where('gudterima.gudang_id','=',$query['gudang_id'])
                                    ->orWhere('gudpindah.gudang_id2','=',$query['gudang_id'])
                                    ->orWhere('gudrevisi.gudang_id','=',$query['gudang_id'])
                                    ->groupBy('gudterima.gudang_id','barang.id')
                                    ->groupBy('gudpindah.gudang_id2','barang.id')
                                    ->groupBy('gudrevisi.gudang_id','barang.id')
                                    ->get();

            $data['revision']->tanggal = $this->convert_date($query['tanggal']);
            $data['revision']->gudang_id = $query['gudang_id'];
        }

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['revision'] = (object) $this->session->getFlash('post_data');
        }
        
        $data['app_profile'] = $this->app_profile;
        //print_r($data);
        return $this->renderer->render($response, 'logistic/revision-form', $data);   
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
                return $response->withRedirect($this->router->pathFor('logistic-revision-add'));
            } else {
                return $response->withRedirect($this->router->pathFor('logistic-revision-edit',['id'=>$postData['id']]));
            }
        }
        
        if($postData['id'] != ""){
            $revision = Gudrevisi::find($postData['id']);
            $revision->users_id_edit = $this->session->get('activeUser')["id"];
            $detail = Gudrevisidetail::where("gudrevisi_id","=",$postData['id'])->delete();

            $Accprovider = new AccountingServiceProvider();
            $res = $Accprovider->jurnal_delete($revision->accjurnal_id);
        } else {
            $revision = new Gudrevisi();
            $revision->users_id = $this->session->get('activeUser')["id"];
            $revision->users_id_edit = 0;            
        }
                
        $jurnal_id = $this->post_jurnal($postData);

        $revision->tanggal = convert_date($postData['tanggal']);
        $revision->nobukti = $postData['nobukti'];
        $revision->gudang_id = $postData['gudang_id'];
        $revision->accjurnal_id = $jurnal_id;
        $revision->keterangan = $postData['keterangan'];
        $revision->cetak = 0;
        $revision->save();

        $revision_id = $revision->id;
        
        // simpan detail
        foreach($postData['barang_id'] as $key => $barang){
            $detail = new Gudrevisidetail();
            $detail->gudrevisi_id = $revision_id;
            $detail->barang_id = $barang;
            $detail->satuan_id = $postData["satuan_id"][$key];
            $detail->kuantitas = $postData["kuantitas"][$key];
            $detail->harga = implode("",explode(".",$postData['harga'][$key]));
            $detail->save();
        }
        
        $this->session->setFlash('success', 'Data telah tersimpan');
        return $response->withRedirect($this->router->pathFor('logistic-revision'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        if(@$args["id"] != ""){
            $revision = Gudrevisi::find($args["id"]);
        }
        if($revision != null){
            $revision->delete();
            $details = Gudrevisidetail::where("gudrevisi_id","=",$args["id"])->delete();
        }

        $this->session->setFlash('success', 'Data telah terhapus');
        return $response->withRedirect($this->router->pathFor('logistic-revision'));
    }

    public function report(Request $request, Response $response, Array $args)
    {
        

        $data['revision'] = Gudrevisi::find($args["id"]);
        $data['options'] = Options::all();
        // print_r(Options::all());
        // return $response;
        return $this->renderer->render($response, 'logistic/reports/revision-report', $data);   
    }

    public function report_all(Request $request, Response $response, Array $args)
    {
        if($request->isPost()){
            $post = $request->getParsedBody();
            $data = $post;
            $data['revisions'] = Gudrevisi::whereBetween('tanggal',[$this->convert_date($post["d_start"]),$this->convert_date($post["d_end"])])->get();
            $data['options'] = Options::all();
            return $this->renderer->render($response, 'logistic/reports/revision-report-all', $data);  
        } else {
            $data['app_profile'] = $this->app_profile;
            return $this->renderer->render($response, 'logistic/reports/revision-report-form', $data);   
        }
         
    }

    private function post_jurnal($postData)
    {
        $data=[ 
                "code" => "",
                "tanggal" => $postData['tanggal'],
                "nobukti" => @$postData['nobukti'],
                "keterangan" => 'Revisi Stok Barang '.@$postData['nobukti'].'. '.@$postData['keterangan'],
                "details"=>[]
            ];
        $total = 0;
        foreach($postData['barang_id'] as $key => $barang){
            $harga = implode("",explode(".",$postData['harga'][$key])) * $postData['kuantitas'][$key];
            $total+=$harga;
            
        }

        if($total>0){
            $data["details"][]=["accounts_id"=>Option::where("name","=","kas")->first()->value,
                                "debet"=>'0',
                                "kredit"=>$total,
                                ];
            $data["details"][]=["accounts_id"=>Option::where("name","=","beban_pembelian")->first()->value,
                                "debet"=>$total,
                                "kredit"=>0
                                ];
        }else{
            $data["details"][]=["accounts_id"=>Option::where("name","=","kas")->first()->value,
                                "debet"=>$total*-1,
                                "kredit"=>0,
                                ];
            $data["details"][]=["accounts_id"=>Option::where("name","=","beban_pembelian")->first()->value,
                                "debet"=>0,
                                "kredit"=>$total*-1
                                ];
        }
        
       
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