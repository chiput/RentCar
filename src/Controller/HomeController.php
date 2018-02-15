<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class HomeController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        // Sample log message
        $this->logger->info("Slim-Skeleton '/' route");

        // Render index view
        return $this->renderer->render($response, 'index', $args);
    }
}
