<?php

namespace App\Middleware;

class ExampleMiddleware
{
    public function __invoke($request, $response, $next) {

        $response->write('Example middleware before route <br>');

        $response = $next($request, $response);

        $response->write('<br> Example middleware after route');

        return $response;
    }
}
