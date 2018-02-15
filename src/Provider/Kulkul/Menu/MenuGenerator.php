<?php
namespace Kulkul\Menu;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Container;

class MenuGenerator {
    protected $container;

    public function __construct(Container $container){
        $this->container = $container;
        return $this;
    }
    public function generate(){
        return "adasdasd";
    }
}