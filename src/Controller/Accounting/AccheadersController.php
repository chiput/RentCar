<?php

namespace App\Controller\Accounting;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Accgroup;
use App\Model\Accheader;
use App\Controller\Controller;


class AccheadersController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {

        //$data=["headers"=>Accheader::first()];
        $data=["headers"=>$this->getData()->get()];
        //print_r($data["headers"]->accgroup());
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'accounting/accheader', $data);
    }

    private function getData()
    {
        $account = $this->db->table('accheaders')
                        ->join('accgroups', 'accheaders.accgroups_id', '=', 'accgroups.id')
                        ->select('accheaders.id', 'accheaders.code', 'accheaders.name', 'accheaders.remark', 'accgroups.name as groupName')
                        ->where('accheaders.deleted_at','=',null);
                        
        return $account;
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data=[
            "header"=>Accheader::where('id', '=', $args["id"])->first(),
            "groups"=>Accgroup::all(),
        ];

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['header'] = (object) $this->session->getFlash('post_data');
        }
        
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'accounting/accheader-form', $data);
        //return $response;
        
    }

    public function save(Request $request, Response $response, Array $args)
    {
        
        $postData = $request->getParsedBody();

        // validation
        $this->validation->validate([
            'code|Code' => [$postData['code'], 'required'],
            'name|Name' => [$postData['name'], 'required'],
        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('accounting-headers-add'));
            } else {
                return $response->withRedirect($this->router->pathFor('accounting-headers-update',["id"=>$postData['id']]));
            }
        }

        // insert
        if ($postData['id'] == '') {
            $this->session->setFlash('success', 'Account tersimpan');
            $header = new Accheader();
        } else {
        // update
            $this->session->setFlash('success', 'Account terupdate');
            $header = Accheader::find($postData['id']);
        }
        $header->code = $postData['code'];
        $header->name = $postData['name'];
        $header->remark = $postData['remark'];
        $header->accgroups_id = $postData['accgroups_id'];
        $header->users_id=$this->session->get('activeUser')["id"];
        $header->save();

        return $response->withRedirect($this->router->pathFor('accounting-headers'));
    
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        
        $header = Accheader::find($args['id']);
        $header->delete();
        $this->session->setFlash('success', 'Accounts terhapus');
        return $response->withRedirect($this->router->pathFor('accounting-headers'));

    }
}


