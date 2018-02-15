<?php

namespace App\Extension\League\Plates;

use League\Plates\Engine as PlatesEngine;
use Slim\Http\Response;

class Engine
{
    private $platesEngine;

    public function __construct($directory = null, $fileExtension = 'php')
    {
        $this->platesEngine = new PlatesEngine($directory, $fileExtension);
        return $this;
    }

    public function render(Response $response, $name, array $data = array())
    {
        $response->write($this->platesEngine->render($name, $data));
        return $response;
    }

    public function plates()
    {
        return $this->platesEngine;
    }
}
