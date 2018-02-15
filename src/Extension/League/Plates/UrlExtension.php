<?php

namespace App\Extension\League\Plates;

use League\Plates\Engine as PlatesEngine;
use League\Plates\Extension\ExtensionInterface;
use Psr\Http\Message\UriInterface;
use Slim\Interfaces\RouterInterface;
use Kulkul\Authentication\AuthServiceProvider;
use Kulkul\AccessControl\AccessControl;


class UrlExtension implements ExtensionInterface
{
    private $router;
    private $authProvider;
    private $uri;
    private $accessControl;

    public function __construct(RouterInterface $router, UriInterface $uri)
    {
        $this->router = $router;
        $this->uri = $uri;
        $this->authProvider = new AuthServiceProvider();
        
    }

    public function register(PlatesEngine $engine)
    {
        $engine->registerFunction('baseUrl', [$this, 'baseUrl']);
        $engine->registerFunction('uriFull', [$this, 'uriFull']);
        $engine->registerFunction('pathFor', [$this->router, 'pathFor']);
        $engine->registerFunction('basePath', [$this->uri, 'getBasePath']);
        $engine->registerFunction('uriScheme', [$this->uri, 'getScheme']);
        $engine->registerFunction('uriHost', [$this->uri, 'getHost']);
        $engine->registerFunction('uriPort', [$this->uri, 'getPort']);
        $engine->registerFunction('uriPath', [$this->uri, 'getPath']);
        $engine->registerFunction('uriQuery', [$this->uri, 'getQuery']);
        $engine->registerFunction('uriFragment', [$this->uri, 'getFragment']);
        $engine->registerFunction('menuLink', [$this, 'menuLink']);
    }

    public function baseUrl($permalink = '')
    {
        return $this->uri->getBaseUrl().'/'.ltrim($permalink);
    }

    public function uriFull()
    {
        return (string) $this->uri;
    }
    public function menuLink($routeName,$args = [],$text = '')
    {

        $user = $this->authProvider->user()->first();

        $this->accessControl = new AccessControl($routeName, $user);
        $grant = $this->accessControl->is_allowed_access();
        if(!$grant){
            return '';    
        }
        return '<a href="' . $this->router->pathFor($routeName,$args) . '" class="boom waves-effect">'.$text.'</a>';
        // . '" class="waves-effect">Transaksi Kas</a>';
    }
}
