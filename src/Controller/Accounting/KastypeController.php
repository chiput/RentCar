<?php

namespace App\Controller\Accounting;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Account;
use App\Model\Acckastype;
use App\Model\Acckas;
use App\Model\Acckasdetails;
use App\Controller\Controller;
use Kulkul\Accounting\AccountingServiceProvider;
use Kulkul\Authentication\Session;


class KastypeController extends Controller
{

    public function __invoke(Request $request, Response $response, Array $args)
    {

        //$postData=$request->getParsedBody();
        
        $data=[];
        $data['app_profile'] = $this->app_profile;

        $data["kastypes"]=Acckastype::all();

        return $this->renderer->render($response, 'accounting/kastype', $data);

    }

    public function form(Request $request, Response $response, Array $args)
    {
        

        $data=["accounts"=>Account::all()];
        $data['app_profile'] = $this->app_profile;
        

        if(isset($args["id"])){
            $data["kastype"]=Acckastype::find($args["id"]);   
        }

        return $this->renderer->render($response, 'accounting/kastype-form', $data);
        
    }

    public function save(Request $request, Response $response, Array $args)
    {
        
        $postData = $request->getParsedBody();

        //validation
        $this->validation->validate([
            'name|Nama' => [$postData['name'], 'required'],
            'accdebet_id|Account Debet' => [$postData['accdebet_id'], 'required'],
            'acckredit_id|Account Kredit' => [$postData['acckredit_id'], 'required'],
        ]);

        if (!$this->validation->passes()) 
        {

            $this->session->setFlash('error_messages',$this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            $response->withRedirect($this->router->pathFor('accounting-kastype-add'));

        }

        if($postData["id"]==""){
            //insert
            $kastype=new Acckastype();
            $kastype->users_id=$this->session->get('activeUser')["id"];
        }else{
            $kastype=Acckastype::find($postData["id"]);
            $kastype->users_id_edit=$this->session->get('activeUser')["id"];
        }

        $kastype->name=$postData["name"];
        $kastype->accdebet_id=$postData["accdebet_id"];
        $kastype->acckredit_id=$postData["acckredit_id"];
        $kastype->type=$postData["type"];
        $kastype->save();        
            
        $this->session->setFlash('success', 'Jenis transaksi tersimpan');

        return $response->withRedirect($this->router->pathFor('accounting-kastype'));    
    }


    public function delete(Request $request, Response $response, Array $args)
    {


        $kastype=Acckastype::find($args["id"]);
        $kastype->delete();
        
        $this->session->setFlash('success', 'Jenis transaksi terhapus');

        return $response->withRedirect($this->router->pathFor('accounting-kastype'));
    }
}


