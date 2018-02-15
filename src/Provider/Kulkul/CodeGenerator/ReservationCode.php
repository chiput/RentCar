<?php

namespace Kulkul\CodeGenerator;

use App\Model\Reservation;
use Kulkul\CodeGenerator\CodeGeneratorTrait;
use Kulkul\CodeGenerator\CodeGeneratorInterface;

class ReservationCode implements CodeGeneratorInterface
{
    protected static $lastCode;
    protected static $prefix = 'RC.';
    protected static $code;
    protected static $codeLenght = 4;

    use CodeGeneratorTrait;

    public static function getLastCode()
    {
        $reservation = Reservation::where('nobukti', 'like', self::$prefix.self::getDate().'%')
                        ->orderBy('nobukti', 'desc')->first();

        if (is_null($reservation)) {
            self::$lastCode = 0;
        } else {
            self::$lastCode = $reservation->nobukti;
        }

        return self::$lastCode;
    }

    public static function getDate()
    {
        return date('ym');
    }
}
