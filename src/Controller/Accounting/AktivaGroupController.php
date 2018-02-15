<?php

namespace App\Controller\Accounting;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Accjurnal;
use App\Model\Accjurnaldetail;
use App\Model\Accaktiva;
use App\Model\Accaktivagroup;
use App\Model\Accaktivajurnal;
use App\Model\Accaktivajurnaldetail;
use App\Model\Account;
use App\Controller\Controller;
use Kulkul\Accounting\AccountingServiceProvider;
use Kulkul\Authentication\Session;


class AktivaGroupController extends Controller
{
    

    public function __invoke(Request $request, Response $response, Array $args)
    {

        $data=["groups"=>Accaktivagroup::all()];//$this->getData()->get()];
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'accounting/aktiva-group', $data);

    }

    public function form(Request $request, Response $response, Array $args)
    {
        
        $data['app_profile'] = $this->app_profile;
        if(isset($args["id"])){
            $data["group"]=Accaktivagroup::where("id",$args["id"])->first();   
        }

        return $this->renderer->render($response, 'accounting/aktiva-group-form', $data);
        
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $user = Session::getActiveUser();
        
        $postData = $request->getParsedBody();

        //validation
        $this->validation->validate([
            'nama|Nama' => [$postData['nama'], 'required'],
        ]);

        if (!$this->validation->passes()) 
        {
            $this->fail_save($response, $postData,$this->validation->errors()->all());
            return $response->write(print_r($this->validation->errors()->all(),true));
        }

        if($postData['id']==""){
            // new
            $group=new Accaktivagroup();
        }else{
            // update
            $group = Accaktivagroup::find($postData['id']);    
        }
                
        $group->nama = $postData['nama'];        
        $group->users_id=$this->session->get('activeUser')["id"];

        $group->save();

        return $response->withRedirect($this->router->pathFor('accounting-aktiva-group'));
    
    }

    

    public function delete(Request $request, Response $response, Array $args)
    {

        $group = Accaktivagroup::find($args['id']);


        $group->delete(); //softdelete


        $this->session->setFlash('success', 'Kelompok aktiva terhapus');
        return $response->withRedirect($this->router->pathFor('accounting-aktiva-group'));
    }

}


