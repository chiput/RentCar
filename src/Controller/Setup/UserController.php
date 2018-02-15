<?php

namespace App\Controller\Setup;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\User;

class UserController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['users'] = User::all();
        return $this->renderer->render($response, 'setup/user', $data);
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data=[];
        if(null != $this->session->getFlash('postData')){
            $data["user"]=(object)$this->session->getFlash('postData');
        }
        $data['errors'] = $this->session->getFlash('error_messages');

        //var_dump($data);
        return $this->renderer->render($response, 'setup/user-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        // validation
        $val=[
            'code|Username' => [$postData['code'], 'required'],
            'name|Nama' => [$postData['name'], 'required'],
            'email|Email' => [$postData['email'], 'required|email'],
        ];
        if($postData["id"]==""){
            $val['password|Password']=[$postData['password'], 'required'];
        }
        $this->validation->validate($val);

        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('postData', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('setup-user-new'));
            } else {
                return $response->withRedirect($this->router->pathFor('setup-user-update',["id"=>$postData["id"]]));
            }
        }

        // insert
        if ($postData['id'] == '') {
            $this->session->setFlash('success', 'User tersimpan');
            $user = new User();
        } else {
        // update
            $this->session->setFlash('success', 'User terbaharui');
            $user = User::find($postData['id']);
        }

        $user->code = $postData['code'];
        $user->name = $postData['name'];
        $user->email = $postData['email'];
        if($postData["id"]==""){
            $this->session->setFlash('postData', $postData);
            if($postData['password']==""){
                $this->session->setFlash('error_messages', 'Password jangan kosong');
                return $response->withRedirect($this->router->pathFor('setup-user-new'));
            }
            $user->password = $this->encrypter->encrypt($postData['password']);    
        }else{
            if($postData['password']!=""){
                $user->password = $this->encrypter->encrypt($postData['password']);    
            }
        }
        

        try
        {
            $user->save();    
        }catch (\Exception $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                $this->session->setFlash('error_messages', "Duplikat data");
                $this->session->setFlash('postData', $postData);
                if ($postData['id'] == '') {
                    return $response->withRedirect($this->router->pathFor('setup-user-new'));
                } else {
                    return $response->withRedirect($this->router->pathFor('setup-user-update',["id"=>$postData["id"]]));
                }
            }
        }


        return $response->withRedirect($this->router->pathFor('setup-user'));
    }

    public function update(Request $request, Response $response, Array $args)
    {
        
        //print_r($user);
        $data=[];
        $data['user'] = User::find($args['id']);
        return $this->renderer->render($response, 'setup/user-form', $data);
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $user=User::find($args["id"]);
        $user->delete();
        $this->session->setFlash('success', 'User terhapus');
        return $response->withRedirect($this->router->pathFor('setup-user'));
    }

    public function profile(Request $request, Response $response, Array $args)
    {
        $data=[];


        $data['user'] = User::find($this->session->get('activeUser')["id"]);

        return $this->renderer->render($response, 'setup/profile-form', $data);

    }

    public function saveprofile(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        // validation
        $val=[
            'code|Username' => [$postData['code'], 'required'],
            'name|Nama' => [$postData['name'], 'required'],
            'email|Email' => [$postData['email'], 'required|email'],
        ];
        $this->validation->validate($val);

        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('postData', $postData);

            return $response->withRedirect($this->router->pathFor('setup-user-profile'));
        }

        
        $this->session->setFlash('success', 'User terbaharui');


        $user = User::find($this->session->get('activeUser')["id"]);

        $user->code = $postData['code'];
        $user->name = $postData['name'];
        $user->email = $postData['email'];

        if($postData['password']!=""){
            $user->password = $this->encrypter->encrypt($postData['password']);    
        }
        

        try
        {
            $user->save();    
        }catch (\Exception $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                $this->session->setFlash('error_messages', "Duplikat data");
                $this->session->setFlash('postData', $postData);
                
                return $response->withRedirect($this->router->pathFor('setup-user-profile'));
  
            }
        }

        return $response->withRedirect($this->router->pathFor('setup-user-profile'));

    }
}
