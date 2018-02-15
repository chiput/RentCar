<?php

namespace Kulkul\Authentication;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Interop\Container\ContainerInterface;
use Kulkul\Authentication\Container;
use Kulkul\Authentication\AuthServiceProvider;

class LoginMiddleware
{
    protected $authenticator;

    public function __construct(ContainerInterface $container)
    {
        Container::setContainer($container);
        $this->authenticator = new AuthServiceProvider();
    }

    public function __invoke(Request $request, Response $response, Callable $next) {

        if ($this->authenticator->reAuth()) return $response = $response->withRedirect(Container::get('router')->pathFor('dashboard'));

        if ($request->getQueryParams()['redirect'] == '') {
            return $response = $response->withRedirect(Container::get('router')->pathFor('dashboard', [], ['redirect' == 'dashboard']));
        }

        $response = $next($request, $response);
        return $response;
    }
}
