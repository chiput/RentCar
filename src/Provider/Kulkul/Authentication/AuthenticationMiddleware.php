<?php

namespace Kulkul\Authentication;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Interop\Container\ContainerInterface;
use Kulkul\Authentication\Container;
use Kulkul\Authentication\AuthServiceProvider;

class AuthenticationMiddleware
{
    protected $authenticator;

    public function __construct(ContainerInterface $container)
    {
        Container::setContainer($container);
        $this->authenticator = new AuthServiceProvider();
    }

    public function __invoke(Request $request, Response $response, Callable $next) {

        if (!$this->authenticator->reAuth()){
            $redirectQuery = $request->getAttribute('route')->getName();
            $redirectTo = Container::get('router')->pathFor('login', [], ['redirect' => $redirectQuery]);
            return $response->withRedirect($redirectTo, 401);
        }

        $response = $next($request, $response);
        return $response;
    }
}
