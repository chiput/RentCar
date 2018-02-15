<?php

namespace App\Controller;

use Slim\Container;

class Controller
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function __get($name)
    {
        return $this->getContainer()->get($name);
    }

    public function getContainer()
    {
        return $this->container;
    }
}
