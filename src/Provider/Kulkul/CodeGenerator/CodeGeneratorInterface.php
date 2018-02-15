<?php

namespace Kulkul\CodeGenerator;

interface CodeGeneratorInterface
{
    /*
    protected static $lastCode;
    protected static $prefix;
    protected static $code;
    protected static $codeLenght;
    */

    public static function generate();

    public static function generateLastCode();

    public static function getLastCode();

    public static function getDate();
}
