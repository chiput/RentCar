<?php

namespace App\Controller\Accounting;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Account;
use App\Model\Bank;
use App\Controller\Controller;
use Kulkul\Accounting\AccountingServiceProvider;
use Kulkul\Authentication\Session;


class BankController extends Controller
{

    public function __invoke(Request $request, Response $response, Array $args)
    {

        //$postData=$request->getParsedBody();
        
        $data=[];
        $data['app_profile'] = $this->app_profile;

        $data["banks"]=Bank::all();

        return $this->renderer->render($response, 'accounting/bank', $data);

    }

    public function form(Request $request, Response $response, Array $args)
    {
        

        $data=["accounts"=>Account::all()];
        $data['app_profile'] = $this->app_profile;
        

        if(isset($args["id"])){
            $data["bank"]=Bank::find($args["id"]);   
        }

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['bank'] = (object) $this->session->getFlash('post_data');
        }

        return $this->renderer->render($response, 'accounting/bank-form', $data);
        
    }

    public function save(Request $request, Response $response, Array $args)
    {
        
        $postData = $request->getParsedBody();

        //validation
        $this->validation->validate([
            'name|Nama' => [$postData['name'], 'required'],
            'accno|No Rekening' => [$postData['accno'], 'required'],
            'accname|Atas Nama' => [$postData['accname'], 'required'],
            'accounts_id|Account Bank' => [$postData['accounts_id'], 'required'],
            'accadmin|Biaya Admin' => [$postData['accadmin'], 'required'],
        ]);

        if (!$this->validation->passes()) 
        {

            $this->session->setFlash('error_messages',$this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            return $response->withRedirect($this->router->pathFor('accounting-bank-add'));

        }

        if($postData["id"]==""){
            //insert
            $bank=new Bank();
        }else{
            $bank=Bank::find($postData["id"]);
        }

        $bank->name=$postData["name"];
        $bank->accno=$postData["accno"];
        $bank->accname=$postData["accname"];
        $bank->code=$postData["code"];
        $bank->accounts_id=$postData["accounts_id"];
        $bank->accadmin=$postData["accadmin"];
        $bank->users_id=$this->session->get('activeUser')["id"];
        $bank->save();        
            
        $this->session->setFlash('success', 'Data bank tersimpan');

        return $response->withRedirect($this->router->pathFor('accounting-bank'));    
    }


    public function delete(Request $request, Response $response, Array $args)
    {


        $bank=Bank::find($args["id"]);
        $bank->delete();
        
        $this->session->setFlash('success', 'Data bank telah terhapus');

        return $response->withRedirect($this->router->pathFor('accounting-bank'));
    }
}


