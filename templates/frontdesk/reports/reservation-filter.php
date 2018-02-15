<?php
    $dataLayout  = [
      // app profile
      'title' => 'Laporan Reservasi',
      'app_name' => $app_profile['name'],
      'author' => $app_profile['author'],
      'description' => $app_profile['description'],
      'developer' => $app_profile['developer'],
      // breadcrumb
      'main_location' => 'FrontDesk',
      'submain_location' => 'Laporan'
  ];

  if (isset($customDataLyout)) {
      $dataLayout = array_merge($dataLayout, $customDataLyout);
  }

  $this->layout('layouts/main', $dataLayout);
?>



<div class="row">
    <div class="col-sm-12">
      <div class="white-box">
        <h3 class="box-title m-b-0">Filter Report</h3>
        <p class="text-muted m-b-20 font-13"></p>
            <form class="form-horizontal" action="<?php echo $submit_form ?>" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12">
                                <span class="help"> Tanggal Laporan </span>
                            </label>
                            <div class="col-md-12">
                            <div class="input-daterange input-group" id="date-range" data-date-format="dd-mm-yyyy">

                                    <input  type="text" class="form-control" name="start" value="<?=isset($postData['start'])? $postData['start']:'01'.date("-m-Y")?>" />
                                <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                                    <input type="text" class="form-control" name="end"
                                    value="<?=isset($postData['end'])?$postData['end']:date("t-m-Y")?>" />
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                    <?php if(isset($room_types)){ ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12">
                                <span class="help"> Jenis Mobil</span>
                            </label>
                            <div class="col-md-12">
                            <select class="form-control select2" name="room_type" >
                                <option value="0"> - Semua Jenis - </option>
                                <?php foreach($room_types as $type){ ?>
                                <option value="<?=$type->id?>" <?=@$postData['room_type']==$type->id?'selected="selected"':''?>><?=$type->name?></option>
                                <?php } ?>
                            </select>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <!-- <?php if(isset($building)){ ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12">
                                <span class="help"> Sopir</span>
                            </label>
                            <div class="col-md-12">
                            <select class="form-control select2" name="building" >
                                <option value="0"> - Semua Sopir - </option>
                                <?php foreach($building as $buildings){ ?>
                                <option value="<?=$buildings->id?>" <?=@$postData['building']==$buildings->id?'selected="selected"':''?>><?=$buildings->name?></option>
                                <?php } ?>
                            </select>
                            </div>
                        </div>
                    </div>
                    <?php } ?> -->
                    </div>
                    </div>
                    </div>
                        <div class="form-group m-b-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Tampilkan</button>
                            </div>
                        </div>

                </div>
            </form>
      </div>
    </div>
<?php if(count((is_array(@$postData)?@$postData:[]))>0) {?>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box" style="overflow:auto">
                    <?php
                        $dates = [];
                    ?>
                    <table border ="0">
                        <tbody>
                            <tr>
                              <td class="reserve moveable" width="30"></td><td>&nbsp;: Reservation (Moveable) &nbsp;</td>
                              <td class="reserve fixed" width="30"></td><td>&nbsp;: Reservation (Unmoveable) &nbsp;</td>
                              <td class="reserve unpaid" width="30"></td><td>&nbsp;: Reservation (Unpaid) &nbsp;</td>
                              <td class="inhouse" width="30"></td><td>&nbsp;: In House&nbsp;</td>
                              <td class="checkedout" width="30"></td><td>&nbsp;: Pengembalian &nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="outer">
                        <div class="inner">  
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="fake fake2" style="line-height: 40px;">Nama Mobil</th>
                                        <?php
                                            // date loop
                                            $current_date = ($date_range['start']);

                                            while ( strtotime(($date_range['end'])) >= strtotime($current_date) ):
                                        ?>
                                        <th colspan="2" width="50">
                                            <?php echo date('d', strtotime($current_date)); ?><br/>
                                            <?php echo date('M', strtotime($current_date)); ?>
                                        </th>
                                        <?php
                                                $dates[] = $current_date;
                                                $current_date = date('Y-m-d', strtotime($current_date.'+ 1 day'));
                                            endwhile;
                                            // date loop
                                        ?>
                                    </tr>
                                </thead>

                                <!-- room loop -->
                                <tbody>
                                <?php foreach ($rooms as $room): ?>
                                <tr class="room-<?php echo $room->id ?>">
                                    <th class="fake">
                                        <?php echo $room->number; ?> / <?php echo $room->level; ?>
                                    </th>
                                    <?php
                                        foreach($dates as $current_date){
                                            if(isset($reservationDetails[$room->id][$current_date])){
                                                $curRes = $reservationDetails[$room->id][$current_date];
                                                if(count($curRes) == 2){
                                                    $kata = explode(" ", $curRes["checkin"]->res->reservation->guest->name);
                                                    // echo "<td>".$curRes["checkout"]->res->id."</td>";
                                                    // echo "<td>".$curRes["checkin"]->res->id."</td>";
                                                    echo "<td class='".$curRes["checkout"]->class." checkout'>".substr($current_date,-2)."</td>";
                                                    echo "<td class='".$curRes["checkin"]->class." checkin'>".$kata[0]."</td>";
                                                }else{
                                                    $res = array_values($curRes)[0];
                                                    switch(key($curRes)){
                                                        case "checkin":
                                                        $kata = explode(" ", $res->res->reservation->guest->name);
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
                                </tbody>
                                <!-- / room loop -->
                            </table>
                        </div>
                    </div>
                    <style>
                        .outer {
                            position: relative;
                        }
                        .inner {
                            overflow-x: scroll;
                            overflow-y: visible;
                            width: calc(100% - 200px);
                            margin-left: 199px;
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
                            width: 200px;
                            height: 52px;
                        }

                        td.inhouse{
                            background-color: #0a7f9d;
                            color:#fff;
                        }

                        td.reserve.moveable{
                            background-color: #fee161;
                            color:#fff;
                        }
                        td.reserve.fixed{
                            background-color: #f32222;
                            color:#fff;
                        }
                        td.unpaid{
                            background-color: #8bc34a;
                            color:#fff;
                        }
                        td.checkedout{
                            background-color: #ff6000;
                            color:#fff;
                        }
                        td.no, td.checkin, td.checkout{
                            border-left:none;
                            border-right:none;
                        }
                    </style>

            </div>
        </div>
    </div>
<?php }?>
</div>
