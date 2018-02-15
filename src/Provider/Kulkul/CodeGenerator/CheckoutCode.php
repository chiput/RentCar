<?php

namespace Kulkul\CodeGenerator;

use App\Model\CheckOut;
use Kulkul\CodeGenerator\CodeGeneratorTrait;
use Kulkul\CodeGenerator\CodeGeneratorInterface;

class CheckoutCode implements CodeGeneratorInterface
{
    protected static $lastCode;
    protected static $prefix = 'HO.';
    protected static $code;
    protected static $codeLenght = 4;

    use CodeGeneratorTrait;

    public static function getLastCode()
    {
        $reservation = CheckOut::where('checkout_code', 'like', self::$prefix.self::getDate().'%')
                        ->orderBy('checkout_code', 'desc')->first();

        if (is_null($reservation)) {
            self::$lastCode = 0;
        } else {
            self::$lastCode = $reservation->checkout_code;
        }

        return self::$lastCode;
    }

    public static function getDate()
    {
        return date('ym');
    }
}
