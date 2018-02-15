<?php

namespace App\Middleware;

use Slim\Container;

class LoginDataMiddleware
{
    protected $container;

    public function __construct (Container $container)
    {
        $this->container = $container;
        return $this;
    }

    public function __invoke($request, $response, $next)
    {
        $data['app_profile'] = $this->container->settings['app_profile'];

        // add the global data below
        $this->container->renderer->plates()->addData($data);

        $response = $next($request, $response);

        return $response;
    }
}
