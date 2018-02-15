<?php

namespace Kulkul\CodeGenerator;

use App\Model\Accjurnal;
use Kulkul\CodeGenerator\CodeGeneratorTrait;
use Kulkul\CodeGenerator\CodeGeneratorInterface;

class JurnalCode implements CodeGeneratorInterface
{
    protected static $lastCode;
    protected static $prefix = 'JN.';
    protected static $code;
    protected static $codeLenght = 4;

    use CodeGeneratorTrait;

    public static function getLastCode()
    {
        $jurnal = Accjurnal::where('code', 'like', self::$prefix.self::getDate().'%')
                        ->orderBy('code', 'desc')->first();

        if (is_null($jurnal)) {
            self::$lastCode = 0;
        } else {
            self::$lastCode = $jurnal->code;
        }

        return self::$lastCode;
    }

    public static function getDate()
    {
        return date('ym');
    }
}
