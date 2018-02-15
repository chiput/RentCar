<?php

namespace Kulkul\CodeGenerator;

use App\Model\Hotpinjam;
use Kulkul\CodeGenerator\CodeGeneratorTrait;
use Kulkul\CodeGenerator\CodeGeneratorInterface;

class HousekeepingpinjamCode implements CodeGeneratorInterface
{
    protected static $lastCode;
    protected static $prefix = 'BP.';
    protected static $code;
    protected static $codeLenght = 4;

    use CodeGeneratorTrait;

    public static function getLastCode()
    {
        $menu = Hotpinjam::where('nobukti', 'like', self::$prefix.self::getDate().'%')
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
