<?php

namespace Kulkul\CodeGenerator;

use App\Model\Addcharge;
use Kulkul\CodeGenerator\CodeGeneratorTrait;
use Kulkul\CodeGenerator\CodeGeneratorInterface;

class AddchargeCode implements CodeGeneratorInterface
{
    protected static $lastCode;
    protected static $prefix = 'BI.';
    protected static $code;
    protected static $codeLenght = 4;

    use CodeGeneratorTrait;

    public static function getLastCode()
    {
        $charge = Addcharge::where('nobukti', 'like', self::$prefix.self::getDate().'%')
                        ->orderBy('nobukti', 'desc')->first();

        if (is_null($charge)) {
            self::$lastCode = 0;
        } else {
            self::$lastCode = $charge->nobukti;
        }

        return self::$lastCode;
    }

    public static function getDate()
    {
        return date('ym');
    }
}
