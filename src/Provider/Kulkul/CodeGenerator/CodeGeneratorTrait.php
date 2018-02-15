<?php

namespace Kulkul\CodeGenerator;

trait CodeGeneratorTrait
{
    public static function generate()
    {
        self::getLastCode();
        return self::$prefix.self::getDate().self::generateLastCode();
    }

    public static function generateLastCode()
    {
        // find last code
        $number = str_replace([self::$prefix.self::getDate()], '', self::$lastCode);
        $number = (int) $number;
        $number++;

        // add 0
        $code = (string) $number;
        while (strlen($code) < self::$codeLenght) {
            $code = '0'.$code;
        }

        return $code;
    }

}
