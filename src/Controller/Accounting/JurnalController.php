<?php

namespace App\Controller\Accounting;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Accjurnal;
use App\Model\Accjurnaldetail;
use App\Model\Account;
use App\Controller\Controller;
use Kulkul\Accounting\AccountingServiceProvider;
use Kulkul\CodeGenerator\JurnalCode;
use Kulkul\CurrencyFormater\FormaterAdapter;

class JurnalController extends Controller
{

    public function __invoke(Request $request, Response $response, Array $args)
    {

        $postData=$request->getParsedBody();

                function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }

        $data=[];
        $data['app_profile'] = $this->app_profile;

        if($request->isPost()){
            $data["d_start"]=($postData["start"]);
            $data["d_end"]=($postData["end"]);
        }else{
            $data["d_start"]=date("d-m-Y");
            $data["d_end"]=date("d-m-Y",strtotime("tomorrow"));
        }
        
        $data["jurnals"]=Accjurnal::whereBetween("tanggal",[convert_date($data["d_start"]),convert_date($data["d_end"])])->orderBy('id','desc')->get();

        return $this->renderer->render($response, 'accounting/jurnal', $data);

    }

    public function form(Request $request, Response $response, Array $args)
    {
        
        $data=["accounts"=>Account::all()];
        $data['app_profile'] = $this->app_profile;
        
        $data["jurnal"]=(object)["code"=>JurnalCode::generate(),"tanggal"=>date("Y-m-d")];

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['jurnal'] = (object) $this->session->getFlash('post_data');
        }

        if(isset($args["id"])){
            $data["jurnal"]=Accjurnal::where('id',$args["id"])->first();   

            $jurnaldetail=Accjurnaldetail::where("accjurnals_id","=",$args["id"])->get();
            $arr=[];
            foreach ($jurnaldetail as $key => $entry) {
                $arr[]=(object)[
                    "id"=>$entry->account->id,
                    "code"=>$entry->account->code,
                    "name"=>$entry->account->name,
                    "debet"=>$entry->debet,
                    "kredit"=>$entry->kredit,
                ];
            }
            $data["jurnaldetail"]=$arr;    
        }

        return $this->renderer->render($response, 'accounting/jurnal-form', $data);
        
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

        //validation
        $this->validation->validate([
            'tanggal|Tanggal' => [convert_date($postData['tanggal']), 'required'],
            'code|Code' => [$postData['code'], 'required'],
        ]);

        if (!$this->validation->passes()) return $this->fail_save($response, $postData,$this->validation->errors()->all());

        //check account
        if(count(@$postData['account_id'])<2||!isset($postData['account_id'])) return $this->fail_save($response, $postData,array('Minimal 2 account di-entry !'));

        //check balance
        if(array_sum($postData['debet'])!=array_sum($postData['kredit'])) return $this->fail_save($response, $postData,array('Posting tidak balance'));
        //check total debet & kredit
        if(array_sum($postData['debet'])<=0 || array_sum($postData['kredit'])<=0) return $this->fail_save($response, $postData,array('Nominal posting kosong !'));
            
        //insert
        $data=[ 
                "id"=>$postData["id"],
                "code" => $postData['code'],
                "tanggal" => convert_date($postData['tanggal']),
                "nobukti" => @$postData['nobukti'],
                "keterangan" => @$postData['keterangan'],
                "details"=>[]
            ];

        foreach ($postData["account_id"] as $key => $value) {
            $data["details"][]=["accounts_id"=>$value,
                                "debet"=>FormaterAdapter::reverse($postData['debet'][$key]),
                                "kredit"=>FormaterAdapter::reverse($postData['kredit'][$key])
                                ];
        }

        // var_dump($data);
       
        $Accprovider=new AccountingServiceProvider();
            
        $res=$Accprovider->jurnal_save($data);
        $this->session->setFlash('success', 'Jurnal tersimpan');

        return $response->withRedirect($this->router->pathFor('accounting-jurnal'));    
    }

    public function fail_save($response, $postData,$mess){

        $this->session->setFlash('error_messages',$mess); 
        $this->session->setFlash('post_data', $postData);

        if ($postData['id'] == '') {
            return $response->withRedirect($this->router->pathFor('accounting-jurnal-add'));
        } else {
            return $response->withRedirect($this->router->pathFor('accounting-jurnal-update',["id"=>$postData['id']]));
        }

        
        return $response;
    }

    public function delete(Request $request, Response $response, Array $args)
    {


        $Accprovider=new AccountingServiceProvider();
        $res=$Accprovider->jurnal_delete($args['id']);

        $this->session->setFlash($res["stat"], $res["mess"]);
        return $response->withRedirect($this->router->pathFor('accounting-jurnal'));
    }

    public function posted(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();
        $jurnal=Accjurnal::find($postData["id"]);
        $jurnal->posted=$postData["posted"];
        $jurnal->save();
        return $response;
    }
}


