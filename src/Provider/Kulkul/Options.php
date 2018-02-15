<?php
namespace Kulkul;

use App\Model\Option;

class Options
{
    public static function all()
    {
        $opt = Option::all();

        $Options=[];
        foreach ($opt as $value) {
    		$Options[$value->name] = $value->value;
        }
        return $Options;
    }

}
