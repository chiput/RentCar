<?php

namespace Kulkul\AccessControl;

use Slim\Container;
use Slim\Http\Request;
use App\Model\ResourceAction;
use App\Model\UserPermission;
use Kulkul\Authentication\AuthServiceProvider;

class AccessControlProvider
{
    protected $container;
    protected $request;
    protected $authProvider;
    protected $accessControl;

    public function __construct(Container $container, Request $request)
    {
        $this->container = $container;
        $this->request = $request;
        $this->authProvider = new AuthServiceProvider();
    }

    public function getCurrentResourceAction()
    {
        // get route name
        $route = $this->request->getAttribute('route');
        $nameName = $route->getName();

        // get resource action
        $resourceAction = ResourceAction::where('route_name', $nameName);

        return $resourceAction->get();
    }

    public function isAllowedAccess()
    {
        $route = $this->request->getAttribute('route');
        $routeName = $route->getName();
        $user = $this->authProvider->user()->first();
        
        $this->accessControl = new AccessControl($routeName, $user);

        return $this->accessControl->is_allowed_access();


        // the resource action
        // $resourceAction = $this->getCurrentResourceAction();
        

        // // if action is not registered then allow all user
        // if ($resourceAction->count() == 0) return true;

        // // get username
        // $user = $this->authProvider->user()->first();

        // // check if there is no user access then allow all
        // //$allUserAccessCount = UserPermission::where('user_id', $user->id)
        // //                                ->get();
        //                                 //->count();
        // //if ($allUserAccessCount == 0) return false;

        // // validate
        // $userAccess = UserPermission::where('user_id', $user->id)
        //                             ->where('resource_action_id', $resourceAction->first()->id)
        //                             ->get();

        // //return true;
        // return $userAccess->count() !== 0;
    }
}
