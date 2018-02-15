<?php
namespace Kulkul\CurrencyFormater;


class FormaterAdapter {

    private function __construct(){

    }

    public static function convert($value, $currency='idr',$decimal = 0){
        switch($currency){
            case 'idr':
                $cur = Toidr::convert($value, $decimal);
                break;
            default:
                $cur = Toidr::convert($value, $decimal);
        }
        return $cur;
    }
    public static function reverse($value, $currency='idr'){
        switch($currency){
            case 'idr':
                $cur = Toidr::reverse($value);
                break;
            default:
                $cur = Toidr::reverse($value);
        }
        
        return $cur;
    }

}