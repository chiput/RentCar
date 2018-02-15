<?php
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Reservation Chart",
  ]);
?>
<?php

function convert_date($date){
    $exp = explode('-', $date);
    if (count($exp)==3) {
        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
    }
    return $date;
}
    
$dates = [];


?>
<h1>Reservation Chart</h1>
<div class="outer">
    <div class="inner">
<table>
    <tbody>
        <tr><td class="inhouse">In House</td></tr>
        <tr><td class="reserve">Reservation</td></tr>
        <tr><td class="checkedout">Pengembalian</td></tr>
    </tbody>
</table>
<table>
    <tr>
        <th class="fake fake2">Nama Mobil</th>
        <?php
            // date loop
            $current_date = convert_date(@$date_range['start']);

            while ( strtotime(convert_date(@$date_range['end'])) >= strtotime($current_date) ):
        ?>
        <th colspan="2" width="50">
            <?php echo date('d', strtotime($current_date)); ?><br/>
            <?php echo date('M', strtotime($current_date)); ?>
        </th>
        <?php
                $dates[] = $current_date;
                $current_date = date('d-m-Y', strtotime($current_date.'+ 1 day'));
            endwhile;
            // date loop
        ?>
    </tr>
    <!-- room loop -->
    <?php foreach (@$rooms as $room): ?>
    <tr class="room-<?php echo $room->id ?>">
        <th class="fake">
            <?php echo $room->number; ?>
        </th>
        <?php
            foreach(@$dates as $current_date){
                if(isset($reservationDetails[$room->id][$current_date])){
                    $curRes = $reservationDetails[$room->id][$current_date];
                    if(count($curRes) == 2){
                        $kata = explode(" ", $res->reservation->guest->name);

                        echo "<td>".$curRes["checkout"]->id."</td>";
                        echo "<td>".$curRes["checkin"]->id."</td>";
                    }else{
                        $res = array_values($curRes)[0];
                        switch(key($curRes)){
                            case "checkin":
                                echo "<td>&nbsp;</td>";
                                echo "<td class='".$res->class." ".key($curRes)."'>".$kata[0]."</td>";
                                break;
                            case "checkout":
                                echo "<td class='".$res->class." ".key($curRes)."'>".substr($current_date,-2)."</td>";
                                echo "<td>&nbsp;</td>";
                                break;
                            default:
                                echo "<td class='".$res->class." ".key($curRes)."' colspan='2'>".substr($current_date,-2)."</td>";
                        }
                    }
                }else{
                    echo "<td colspan='2'>".substr($current_date,-2)."</td>";
                }

            }

        ?>
    </tr>
    <?php   //unset($resDetail); ?>
    <?php endforeach; ?>
    <!-- / room loop -->
</table>
</div>
</div>
<style>
    body {
        font-family: sans-serif;

    }

    table {
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #777;
        text-align: center;

    }

    td.green {
        background-color: blue;
        color: #fff;
    }
    .outer {
        position: relative;
    }
    .inner {
        overflow-x: scroll;
        overflow-y: visible;
        width: calc(100% - 150px);
        margin-left: 150px;
    }
    td.fake{
        position: relative;
        height: 60px !important;
    }
    .fake2 {
        border-top: 1px solid #ddd !important;
        height: 72px !important;
        top: 0px !important;
    }
    th, td {
        text-align: center;
    }
    th.fake{
        position: absolute;
        left: 0;
        width: 152px;
        height: 52px;
    }

    td.inhouse{
        background-color: #0a7f9d;
    }
    td.reserve{
        background-color: #fee161;
    }
    td.checkedout{
        background-color: #f32222;
    }
    td.no, td.checkin, td.checkout{
        border-left:none;
        border-right:none;
    }
</style>
