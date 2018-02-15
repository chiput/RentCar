<?php

namespace App\Controller\Accounting;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Account;
use App\Model\Accheader;
use App\Controller\Controller;


class AccountController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {

        $data=["accounts"=>$this->getData()->get()];
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'accounting/account', $data);
        return $response;
    }

    private function getData()
    {
        $account = $this->db->table('accounts')
                        ->join('accheaders', 'accounts.accheaders_id', '=', 'accheaders.id')
                        ->join('accgroups', 'accheaders.accgroups_id', '=', 'accgroups.id')
                        ->select('accounts.id', 'accounts.code', 'accounts.name', 'accounts.type', 'accounts.accheaders_id','accheaders.name as headerName', 'accgroups.name as groupName')
                        ->where('accounts.deleted_at','=',null);
                        
        return $account;
    }

    public function ajax(Request $request, Response $response, Array $args)
    {
        return $response->write(json_encode($this->getData()->get()));
    }

    public function form(Request $request, Response $response, Array $args)
    {
        
        $data=[
            "account"=>Account::where('id', '=', $args["id"])->first(),
            "headers"=>Accheader::all(),
        ];
        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['account'] = (object) $this->session->getFlash('post_data');
        }
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'accounting/account-form', $data);
        
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
                return $response->withRedirect($this->router->pathFor('accounting-accounts-add'));
            } else {
                return $response->withRedirect($this->router->pathFor('accounting-accounts-update',["id"=>$postData['id']]));
            }
        }

        // insert
        if ($postData['id'] == '') {
            $this->session->setFlash('success', 'Account tersimpan');
            $account = new Account();
        } else {
        // update
            $this->session->setFlash('success', 'Account terupdate');
            $account = Account::find($postData['id']);
        }
        $account->code = $postData['code'];
        $account->name = $postData['name'];
        $account->type = $postData['type'];
        $account->accheaders_id = $postData['accheaders_id'];
        $account->users_id=$this->session->get('activeUser')["id"];
        $account->save();

        return $response->withRedirect($this->router->pathFor('accounting-accounts'));
    
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $account = Account::find($args['id']);
        $account->delete();
        $this->session->setFlash('success', 'Accounts terhapus');
        return $response->withRedirect($this->router->pathFor('accounting-accounts'));
    }
}


