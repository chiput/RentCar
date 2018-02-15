<?php

namespace Kulkul\AccessControl;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Container;

class AccessControlMiddleware
{
    protected $accessControl;
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response, Callable $next) {

        $this->accessControl = new AccessControlProvider($this->container, $request);

        $grantUser = $this->accessControl->isAllowedAccess();

        if (!$grantUser) {
            $forbidenURL = $this->container->router->pathFor('access-forbidden');
            return $response->withRedirect($forbidenURL, 403);
        }

        $response = $next($request, $response);

        return $response;
    }
}
