<?php

namespace App\Extension\League\Plates;

use League\Plates\Engine as PlatesEngine;
use League\Plates\Extension\ExtensionInterface;

class FormValueExtension implements ExtensionInterface
{
    public function __construct()
    {
    }

    public function register(PlatesEngine $engine)
    {
        $engine->registerFunction('formValue', [$this, 'formValue']);
    }

    public function formValue($value, $default = '')
    {
        if (empty($value)) {
            if (is_callable($default))
            {
                return $default();
            } else {
                return $default;
            }
        }

        return $value;
    }
}
