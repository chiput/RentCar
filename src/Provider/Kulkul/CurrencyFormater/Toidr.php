<?php
namespace Kulkul\CurrencyFormater;

class Toidr {
    private function __construct(){

    }

    public static function convert($val,$decimal){
        return number_format($val,$decimal,",",".");
    }

    public static function reverse($val){
        $real = implode("",explode(".",$val));
        $real = implode(".",explode(",",$real));
        return $real;
    }
}