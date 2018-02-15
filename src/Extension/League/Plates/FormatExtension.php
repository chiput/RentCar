<?php

namespace App\Extension\League\Plates;

use League\Plates\Engine as PlatesEngine;
use League\Plates\Extension\ExtensionInterface;
use Kulkul\CurrencyFormater\FormaterAdapter as Format;



class FormatExtension implements ExtensionInterface
{

    // private $format;

    public function __construct()
    {
        
    }

    public function register(PlatesEngine $engine)
    {
        $engine->registerFunction('convert', [$this, 'convert']);
        $engine->registerFunction('reverse', [$this, 'reverse']);
    }

    public function convert($val, $currency = "", $decimal = 0){
        return Format::convert($val, $currency, $decimal);
    }

    public function reverse($val, $currency){
        return Format::reverse($val, $currency);        
    }

    
}
