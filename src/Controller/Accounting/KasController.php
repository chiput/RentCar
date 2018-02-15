<?php

namespace App\Controller\Accounting;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Accjurnal;
use App\Model\Accjurnaldetail;
use App\Model\Account;
use App\Controller\Controller;
use Kulkul\Accounting\AccountingServiceProvider;


class KasController extends Controller
{

    public function __invoke(Request $request, Response $response, Array $args)
    {

        $postData=$request->getParsedBody();


        $data=[];
        $data['app_profile'] = $this->app_profile;

        if($request->isPost()){
            $data["d_start"]=$postData["start"];
            $data["d_end"]=$postData["end"];
        }else{
            $data["d_start"]=date("Y-m-d");
            $data["d_end"]=date("Y-m-d",strtotime("tomorrow"));
        }
        
        $data["jurnals"]=Accjurnal::whereBetween("tanggal",[$data["d_start"],$data["d_end"]])->get();

        return $this->renderer->render($response, 'accounting/jurnal', $data);

    }

    public function form(Request $request, Response $response, Array $args)
    {
        

        $data=["accounts"=>Account::all()];
        $data['app_profile'] = $this->app_profile;
        

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

        if (!$this->validation->passes()) 
        {

            $this->fail_save($response, $postData,$this->validation->errors()->all());
            return $response->write(print_r($this->validation->errors()->all(),true));

        }

        if(count(@$postData['account_id'])<2||!isset($postData['account_id']))
        {

            $this->fail_save($response, $postData,array("Minimal 2 account di-entry !"));
            return $response->write(print_r(array("Minimal 2 account di-entry !"),true));

        }

        if(array_sum($postData['debet'])!=array_sum($postData['kredit']))
        {

            $this->fail_save($response, $postData,array("Entry tidak balance !"));
            return $response->write(print_r(array("Entry tidak balance !"),true));

        }

        if(array_sum($postData['debet'])<=0 && array_sum($postData['kredit'])<=0)
        {
            
            $this->fail_save($response, $postData,array("Nominal posting kosong !"));
            return $response->write(print_r(array("Nominal posting kosong !"),true));

        }



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
                                "debet"=>$postData['debet'][$key],
                                "kredit"=>$postData['kredit'][$key]];
        }

        //print_r($data);
       
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


