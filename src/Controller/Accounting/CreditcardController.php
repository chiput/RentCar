<?php

namespace App\Controller\Accounting;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Account;
use App\Model\Bank;
use App\Model\Creditcard;
use App\Controller\Controller;
use Kulkul\Accounting\AccountingServiceProvider;
use Kulkul\Authentication\Session;


class CreditcardController extends Controller
{

    public function __invoke(Request $request, Response $response, Array $args)
    {

        //$postData=$request->getParsedBody();
        
        $data=[];
        $data['app_profile'] = $this->app_profile;

        $data["creditcards"]=Creditcard::all();

        return $this->renderer->render($response, 'accounting/creditcard', $data);

    }

    public function form(Request $request, Response $response, Array $args)
    {
        

        $data["banks"]=Bank::all();
        $data['app_profile'] = $this->app_profile;
        

        if(isset($args["id"])){
            $data["creditcards"]=Creditcard::find($args["id"]);   
        }

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['creditcards'] = (object) $this->session->getFlash('post_data');
        }

        return $this->renderer->render($response, 'accounting/creditcard-form', $data);
        
    }

    public function save(Request $request, Response $response, Array $args)
    {
        
        $postData = $request->getParsedBody();

        //validation
        $this->validation->validate([
            'name|Nama' => [$postData['name'], 'required'],
        ]);

        if (!$this->validation->passes()) 
        {

            $this->session->setFlash('error_messages',$this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            return $response->withRedirect($this->router->pathFor('accounting-creditcard-add'));

        }

        if($postData["id"]==""){
            //insert
            $cc = new Creditcard();
        }else{
            $cc = Creditcard::find($postData["id"]);
        }

        // `id`, `name`, `banks_id`, `biaya`, `jenis`, `is_active`, `users_id`, `created_at`, `updated_at`
        $cc->name=$postData["name"];
        $cc->biaya=$postData["biaya"];
        $cc->banks_id=0;
        $cc->jenis=1;
        $cc->is_active=1;
        $cc->users_id=$this->session->get('activeUser')["id"];
        $cc->save();        
            
        $this->session->setFlash('success', 'Data kartu kredit tersimpan');

        return $response->withRedirect($this->router->pathFor('accounting-creditcard'));    
    }


    public function delete(Request $request, Response $response, Array $args)
    {


        $cc=Creditcard::find($args["id"]);
        $cc->delete();
        
        $this->session->setFlash('success', 'Data kartu kredit telah terhapus');

        return $response->withRedirect($this->router->pathFor('accounting-creditcard'));
    }
}


