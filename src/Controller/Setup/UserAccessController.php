<?php

namespace App\Controller\Setup;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\User;
use App\Model\UserPermission;
use App\Model\Resource;
use App\Model\ResourceAction;
use App\Model\ResourceCategory;

class UserAccessController extends Controller
{

    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data=[];
        if(null != $this->session->getFlash('postData')){
            $data["user"]=(object)$this->session->getFlash('postData');
        }
        $data["categories"]=ResourceCategory::orderBy('name','ASC')->get();
        $data["user"]=User::find($args["userId"]);
        $permission=UserPermission::where("user_id",$args["userId"])->get();
        $data["permission"]=[];
        foreach ($permission as $value) {
            $data["permission"][$value->resource_action_id]=$value;
        }
        //print_r($permission);
        //var_dump($data);
        return $this->renderer->render($response, 'setup/user-access', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        
        $permission=UserPermission::where("user_id",$postData["user_id"]);
        $permission->delete();
        

        foreach ($postData["act"] as $act) {
            $permission=new UserPermission();
            $permission->user_id=$postData["user_id"];
            $permission->resource_action_id=$act;
            $permission->save();
        }

        return $response->withRedirect($this->router->pathFor('setup-user'));
    }

}
