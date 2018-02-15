<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class AccessForbiddenController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        return $this->renderer->render($response, 'errors/403');
        //return $response;
    }
}
