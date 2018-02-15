<?php

namespace Kulkul\CodeGenerator;

use App\Model\Reservationdetail;
use Kulkul\CodeGenerator\CodeGeneratorTrait;
use Kulkul\CodeGenerator\CodeGeneratorInterface;

class CheckinCode implements CodeGeneratorInterface
{
    protected static $lastCode;
    protected static $prefix = 'HI.';
    protected static $code;
    protected static $codeLenght = 4;

    use CodeGeneratorTrait;

    public static function getLastCode()
    {
        $reservation = Reservationdetail::where('checkin_code', 'like', self::$prefix.self::getDate().'%')
                        ->orderBy('checkin_code', 'desc')->first();

        if (is_null($reservation)) {
            self::$lastCode = 0;
        } else {
            self::$lastCode = $reservation->checkin_code;
        }

        return self::$lastCode;
    }

    public static function getDate()
    {
        return date('ym');
    }
}
