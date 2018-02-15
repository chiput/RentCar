<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use Kulkul\Test\TestServiceProvider;

class TestController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $testProvider = new TestServiceProvider();
        $response = $testProvider->writeCompanyName($response);
        $response->write('<br>');
        $response = $testProvider->writeCompanyService($response);
        return $response;
    }

    public function session(Request $request, Response $response, Array $args)
    {
        $sessionString = 'Tirta';
        $this->session->set('user', $sessionString);
        return $response->write($this->session->set('user'));
    }

    public function template(Request $request, Response $response, Array $args)
    {
        // Sample log message
        $this->logger->info("Slim-Skeleton '/' route");

        // Render index view
        return $this->renderer->render($response, 'index', $args);
    }

    public function database(Request $request, Response $response, Array $args)
    {
        echo '<pre>';
        print_r($this->db);
    }

    public function encrypter(Request $request, Response $response, Array $args)
    {
        return $response->write($this->encrypter->encrypt('kulkul.id'));
    }

    public function hash(Request $request, Response $response, Array $args)
    {
        echo $this->hash->make('LOLOLOLOLOLOLOLOLOL');
    }
}
