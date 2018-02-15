<?php

namespace Kulkul\CodeGenerator;

use App\Model\Pembelian;
use Kulkul\CodeGenerator\CodeGeneratorTrait;
use Kulkul\CodeGenerator\CodeGeneratorInterface;

class PurchaseOrderCode implements CodeGeneratorInterface
{
    protected static $lastCode;
    protected static $prefix = 'PO.';
    protected static $code;
    protected static $codeLenght = 4;

    use CodeGeneratorTrait;

    public static function getLastCode()
    {
        $pembelian = Pembelian::where('nobukti', 'like', self::$prefix.self::getDate().'%')
                        ->orderBy('nobukti', 'desc')->first();

        if (is_null($pembelian)) {
            self::$lastCode = 0;
        } else {
            self::$lastCode = $pembelian->nobukti;
        }

        return self::$lastCode;
    }

    public static function getDate()
    {
        return date('ym');
    }
}
