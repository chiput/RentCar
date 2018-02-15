<?php

namespace Kulkul\CodeGenerator;

use App\Model\Acckas;
use Kulkul\CodeGenerator\CodeGeneratorTrait;
use Kulkul\CodeGenerator\CodeGeneratorInterface;

class TransBankCode implements CodeGeneratorInterface
{
    protected static $lastCode;
    protected static $prefix = 'TB.';
    protected static $code;
    protected static $codeLenght = 4;

    use CodeGeneratorTrait;

    public static function getLastCode()
    {
        $kas = Acckas::where('nobukti', 'like', self::$prefix.self::getDate().'%')
                        ->orderBy('nobukti', 'desc')->first();

        if (is_null($kas)) {
            self::$lastCode = 0;
        } else {
            self::$lastCode = $kas->nobukti;
        }

        return self::$lastCode;
    }

    public static function getDate()
    {
        return date('ym');
    }
}
