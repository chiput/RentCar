<?php
namespace Harmoni\DateConverter;

class DateConverterProvider {

  public static function convert($date)
  {
    $exp = explode('-', $date);
    if (count($exp)==3) {
        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
    }
    return $date;
  }

}



 ?>
