<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class DashboardController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
    	// app profile
        $data['app_profile'] = $this->app_profile;

        return $this->renderer->render($response, 'dashboard', $data);
    }
}
