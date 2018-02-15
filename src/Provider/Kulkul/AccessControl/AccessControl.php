<?php
namespace Kulkul\AccessControl;

use Slim\Container;
use Slim\Http\Request;
use App\Model\ResourceAction;
use App\Model\UserPermission;

class AccessControl {

    protected $routeName;
    protected $user;

    public function __construct($routeName, $user){
        $this->routeName = $routeName;
        $this->user = $user;

    }

    private function getCurrentResourceAction(){

        // get resource action
        $resourceAction = ResourceAction::where('route_name', $this->routeName);

        return $resourceAction->get();
    }

    public function is_allowed_access(){
        // the resource action
        $resourceAction = $this->getCurrentResourceAction();


        // if action is not registered then allow all user
        if ($resourceAction->count() == 0) return true;


        // validate
        $userAccess = UserPermission::where('user_id', $this->user->id)
                                    ->where('resource_action_id', $resourceAction->first()->id)
                                    ->get();

        //return true;
        return $userAccess->count() !== 0;
    }
}