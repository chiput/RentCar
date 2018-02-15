<?php

namespace Kulkul\CodeGenerator;

use App\Model\Laundry;
use Kulkul\CodeGenerator\CodeGeneratorTrait;
use Kulkul\CodeGenerator\CodeGeneratorInterface;

class LaundryCode implements CodeGeneratorInterface
{
    protected static $lastCode;
    protected static $prefix = 'LA.';
    protected static $code;
    protected static $codeLenght = 4;

    use CodeGeneratorTrait;

    public static function getLastCode()
    {
        $menu = Laundry::where('nobukti', 'like', self::$prefix.self::getDate().'%')
                        ->orderBy('nobukti', 'desc')->first();

        if (is_null($menu)) {
            self::$lastCode = 0;
        } else {
            self::$lastCode = $menu->nobukti;
        }

        return self::$lastCode;
    }

    public static function getDate()
    {
        return date('ym');
    }
}
