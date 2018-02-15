<?php

namespace App\Controller\Accounting;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Account;
use App\Model\Acckastype;
use App\Model\Acckas;
use App\Model\Acckasdetail;
use App\Controller\Controller;
use Kulkul\Accounting\AccountingServiceProvider;
use Kulkul\Authentication\Session;
use Kulkul\CodeGenerator\TransKasCode;
use Kulkul\CodeGenerator\TransBankCode;
use Kulkul\CurrencyFormater\FormaterAdapter;



class AcckasController extends Controller
{

    public function __invoke(Request $request, Response $response, Array $args)
    {

        //$postData=$request->getParsedBody();
        //echo $args["type"];
        switch ($args["type"]) {
            case 'kas':
                $type=1;
                break;
            case 'bank':
                $type=2;
                break;
            default:
                return $response;
                break;
        }
        $data=[];
        $data['app_profile'] = $this->app_profile;
        

        $data['type'] = $type;
        $data["trans"]=Acckas::where("type","=",$type)->get();

        return $this->renderer->render($response, 'accounting/kas', $data);

    }

    public function form(Request $request, Response $response, Array $args)
    {
        
        switch (@$args["type"]) {
            case 'kas':
                $type=1;
                $data["trans"]=(object)["nobukti"=>TransKasCode::generate(),"tanggal"=>date("Y-m-d")];
                break;
            case 'bank':
                $type=2;
                $data["trans"]=(object)["nobukti"=>TransBankCode::generate(),"tanggal"=>date("Y-m-d")];
                break;
            default:
                $type=0;
                break;
        }

        $data["types"]=Acckastype::where("type","=",$type)->get();
        $data["type"]=$type;
        $data['app_profile'] = $this->app_profile;
        
        if(isset($args["id"])){
            $data["trans"]=Acckas::find($args["id"]);   
            $data["type"]=$data["trans"]->type;
            $data["types"]=Acckastype::where("type","=",$data["trans"]->type)->get();
        }
        
        
        return $this->renderer->render($response, 'accounting/kas-form', $data);
        
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

        switch ($postData["type"]) {
            case 1:
                $type="kas";
                break;
            case 2:
                $type="bank";
                break;
            default:
                return $response;
                break;
        }

        //validation
        $this->validation->validate([
            'tanggal|Tanggal' => [convert_date($postData['tanggal']), 'required'],
        ]);

        if (!$this->validation->passes()) 
        {

            $this->session->setFlash('error_messages',$this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if($postData["id"]==""){
                $response->withRedirect($this->router->pathFor('accounting-kas-add',["type"=>$type]));    
            }else{
                $response->withRedirect($this->router->pathFor('accounting-kas-update',["type"=>$type,"id"=>$postData["id"]]));    
            }
            

        }

        if($postData["id"]==""){
            //insert
            $acckas=new Acckas();
            $acckas->users_id=$this->session->get('activeUser')["id"];
        }else{
            //update
            $acckas=Acckas::find($postData["id"]);
            
            $Accprovider=new AccountingServiceProvider();
            $res=$Accprovider->jurnal_delete($acckas->accjurnals_id); //delete jurnal
        }   
        $acckas->users_id_edit=$this->session->get('activeUser')["id"];     

        $jurnal=[ 
                "id"=>"",
                "code" => "",
                "tanggal" => convert_date($postData['tanggal']),
                "nobukti" => @$postData['nobukti'],
                "keterangan" => "Transaksi  ".$type." ".@$postData['nobukti'],
                "details"=>[]
        ];

        
        foreach ($postData["types_id"] as $key => $value) {
            if($value!=0){
            $jurnal["details"][]=["accounts_id"=>$postData["accdebet_id"][$key],
                                    "debet"=>FormaterAdapter::reverse($postData['nominal'][$key]),
                                    "kredit"=>0
                                ]; 
            $jurnal["details"][]=["accounts_id"=>$postData["acckredit_id"][$key],
                                    "debet"=>0,
                                    "kredit"=>FormaterAdapter::reverse($postData['nominal'][$key])
                                ]; 
            }
        }
        
        //save jurnal
        $Accprovider=new AccountingServiceProvider();
        $res=$Accprovider->jurnal_save($jurnal);

        //save transaksi
        $acckas->tanggal=convert_date($postData["tanggal"]);
        $acckas->accjurnals_id=$res["accjurnals_id"];
        $acckas->nobukti=$postData["nobukti"];
        $acckas->penyetor=$postData["penyetor"];
        $acckas->penerima=$postData["penerima"];
        $acckas->remark=$postData["remark"];
        $acckas->type=$postData["type"];
        $acckas->save();        

        $acckasdetails = Acckasdetail::where("acckas_id","=",$acckas->id);   
        $acckasdetails->delete();

        foreach ($postData["types_id"] as $key => $value) {
            if($value!=0){
            $detail=new Acckasdetail();
            $detail->acckas_id=$acckas->id;
            $detail->acckastypes_id=$postData["types_id"][$key];
            $detail->remark=$postData["det_remark"][$key];
            $detail->nominal=FormaterAdapter::reverse($postData["nominal"][$key]);
            $detail->users_id=$this->session->get('activeUser')["id"];
            $detail->save();
            }
        }

            
        $this->session->setFlash('success', 'Transaksi '.$type.' tersimpan');

        return $response->withRedirect($this->router->pathFor('accounting-kas',["type"=>$type]));    
    }


    public function delete(Request $request, Response $response, Array $args)
    {

        $kastype = ["","kas","bank"];

        $Accprovider=new AccountingServiceProvider();

        $acckas = Acckas::find($args['id']);
        $type = @$kastype[@$acckas->type];
        $res=$Accprovider->jurnal_delete($acckas->accjurnals_id);
        $acckas->delete();

        $acckasdetails = Acckasdetail::where("acckas_id","=",$args['id']);   
        

        $acckasdetails->delete();

        $this->session->setFlash('success', 'Transaksi '.$type.' terhapus');
        return $response->withRedirect($this->router->pathFor('accounting-kas',["type"=>$type]));
    }
}


