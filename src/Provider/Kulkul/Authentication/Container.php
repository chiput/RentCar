<?php

namespace Kulkul\Authentication;

use Interop\Container\ContainerInterface;

class Container
{
    static $container;

    public static function setContainer(ContainerInterface $container)
    {
        self::$container = $container;
    }

    public static function get($name)
    {
        return self::$container->get($name);
    }
}
