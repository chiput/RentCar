<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Tingkat Hunian',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Management',
    'submain_location' => 'Tingkat Hunian'
  ]);

function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }

//print_r($reservations);
$arrStatus=["Out Of Service","Dirty"];
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Tingkat Hunian </h3>
            <p class="text-muted m-b-30">Data Tingkat Hunian</p>
            <form class="form-horizontal" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Tanggal</span></label>
                            <div class="col-md-12">
                                <div class="input-daterange input-group" id="date-range" data-date-format="dd-mm-yyyy">
                                        <input  type="text" class="form-control" name="start" value="<?php echo @convert_date($start) ?>" >
                                    <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                                        <input type="text" class="form-control" name="end"
                                        value="<?php echo @convert_date($end) ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="help"> Tipe Kamar</span></label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="room_type_id">
                                            <option value="">-Pilih Tipe-</option>
                                        <?php foreach ($room_types as $key => $type) { ?>
                                            <option value="<?=$type->id?>" <?=($type->id==$room_type_id?'selected="selected"':'')?>><?=$type->name?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="help"> Gedung</span></label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="building_id">
                                            <option value="">-Pilih Gedung-</option>
                                        <?php foreach ($buildings as $building) { ?>
                                            <option value="<?=$building->id?>" <?=($building->id==$building_id?'selected="selected"':'')?>><?=$building->name?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2" style="float: left; margin-left: 8px;">
                        <div class="form-group">
                            <button class="form-control btn btn-info">Filter</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
        <div class="col-md-6">
            <div class="white-box">
            <h3 class="box-title">Tabel Tingkat Hunian</h3>
            <?php 
            $startTimeStamp = strtotime($start);
            $endTimeStamp = strtotime($end);
            $timeDiff = abs($endTimeStamp - $startTimeStamp);
            $numberDays = $timeDiff/86400; 
            $numberDays = intval($numberDays)+1;
            if($numberDays == 0){
                $numberDays = 1;
            }
            ?>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Room No</th>
                            <th>Status</th>
                            <th>Jumlah</th>
                            
                        </tr>
                    </thead>
                     
                    <span style="text-align: right;float: right;">
                        <br>
                        <?php
                        $kamar = 0;
                            
                        ?>
                        <b>Total Room : <?=count($z);?></b>
                        <b>Total Day : <?=$numberDays?></b>
                        <br>
                    </span>
                    <tbody>
                        <?php 
                           $total = 0;$check_in = 0;$avaliable = 0; 
                            foreach ($z as $room): 
                                ?>
                                <tr>
                                    <td rowspan="2"><?php echo $room->number; ?></td>
                                    <td>Check In</td>
                                    <td>
                                        <?php
                                            $strong = 0;
                                            foreach ($room->checkins($start,$end,$room->id) as $key) {
                                               if(isset($key->reservation->checkin)){
                                                    if (((strtotime($start)) >= (strtotime($key->reservation->checkin))) && (strtotime($end) < strtotime($key->reservation->checkout))){

                                                        $strong = $strong + intval(abs(strtotime($end) - strtotime($start))/86400)+1;

                                                    } else  if((strtotime($start)) >= (strtotime($key->reservation->checkin))){
                                                        $strong = $strong + intval(abs(strtotime($key->reservation->checkout) - strtotime($start))/86400);

                                                    } else  if((strtotime($start)) < (strtotime($key->reservation->checkin)) && (strtotime($end) < strtotime($key->reservation->checkout))){
                                                        $strong = $strong + intval(abs(strtotime($end) - strtotime($key->reservation->checkin))/86400)+1;

                                                    } else {
                                                        $strong = $strong + intval(abs(strtotime($key->reservation->checkout) - strtotime($key->reservation->checkin))/86400);

                                                    } 
                                                } else {
                                                    $strong = $strong + 0;
                                                }
                                            }
                                            echo $strong;
                                        ?>
                                        
                                    </td>
                                </tr>
                                    <td>Occupancy</td>
                                    <td>
                                        <?php
                                            $roomnya = (1 * $numberDays) - $strong;
                                            $avaliable = $avaliable + $roomnya;
                                            $check_in = $check_in + $strong;
                                            $total = $check_in + $avaliable;

                                            $persentase = round($strong/$numberDays*100);
                                            echo $persentase;
                                        ?>
                                        %
                                    </td>
                                </tr>

                         <?php 
                            // } 
                         //endforeach;
                                endforeach; 

                                ?>

                    </tbody>
                </table>
                <span style="text-align: right;float: right;">
                    <br>
                    <b>Total Room Days: </b><?php echo $total; ?>
                    <b>Total Check in: </b><?php echo $check_in; ?>
                    <b>Total Occupancy: </b><?php echo round($check_in/$total*100); ?>%
                    <br>
                </span>
                <div class="clear"></div>
            </div>
        </div>
        <div class="col-md-6">
          <div class="white-box">
              <h3 class="box-title">Chart Tingkat Hunian</h3>
              <div id="morris-donut-chart" class="ecomm-donute" style="height: 317px;">
              </div>
              <ul class="list-inline m-t-30 text-center">
                <li class="p-r-20">
                  <h5 class="text-muted"><i class="fa fa-circle" style="color: #4F5467;"></i> Room Days</h5>
                  <h4 class="m-b-0"><?php echo $total; ?></h4>
                </li>
                <li class="p-r-20">
                  <h5 class="text-muted"><i class="fa fa-circle" style="color: #fb9678;"></i> Check in</h5>
                  <h4 class="m-b-0"><?php echo $check_in; ?></h4>
                </li>
                <li>
                  <h5 class="text-muted"> <i class="fa fa-circle" style="color: #01c0c8;"></i> Avaliable</h5>
                  <h4 class="m-b-0"><?php echo $avaliable; ?></h4>
                </li>
            </ul>
          </div>
       </div>
       </div>         
      </div>
</div>

<script src="<?=$this->baseUrl()?>plugins/bower_components/raphael/raphael-min.js"></script>
<script src="<?=$this->baseUrl()?>plugins/bower_components/morrisjs/morris.js"></script>
<script src="<?=$this->baseUrl()?>js/morris-data.js"></script>

<script type="text/javascript">
   Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "Occupancy",
            value: Math.round(<?=$check_in/$total*100;?>),
        }, {
            label: "Avaliable",
            value: Math.round(<?=$avaliable/$total*100;?>),
        }],
        resize: true,
        colors:['#fb9678', '#01c0c8', '#4F5467'],

        formatter: function(x){return x + "%"}
    });
 $('.vcarousel').carousel({
            interval: 3000
         })
$(".counter").counterUp({
        delay: 100,
        time: 1200
    });

</script>