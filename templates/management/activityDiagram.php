<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Activity Diagram',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Management',
    'submain_location' => 'Activity Diagram'
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
        <div class="col-sm-6">
          <div class="white-box">
             <h3 class="box-title m-b-0">Aktifitas Diagram </h3>
             <p class="text-muted m-b-30">Data Aktifitas Diagram</p>
            <div>
              <form class="form-horizontal" method="POST">
                <div class="row">
                    <div class="col-md-12">
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="help" style="float: left; margin-left: 8px;">Sopir</span></label>
                                    <div class="col-md-12">
                                    <?php foreach ($agents as $keys): ?>
                                    <div class="col-md-3">
                                        <label>
                                            <input name="agents[]" value="<?php echo $keys->id ?>" type="checkbox" 
                                            <?php 
                                            if ($z) {
                                                foreach($z as $key) {
                                                    if ($key == $keys->id) {
                                                        echo 'checked="checked"';
                                                        break;
                                                    }
                                                }
                                            }else{
                                                foreach ($keys as $key) {
                                                   if ($key) {
                                                        echo 'checked="checked"';
                                                        break;
                                                    }
                                                }
                                            }
                                            ?>
                                            />
                                            <?php echo $keys->code." - ".$keys->name ?>
                                        </label>
                                    </div>
                                    <?php endforeach; ?>
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
          </div>
        </div>
        <div class="row">
        <div class="col-md-6">
            <div class="white-box">
            <h3 class="box-title">Tabel Activity Diagram</h3>
               <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Kode Sopir</th>
                        <th>Nama Sopir</th>
                        <th>Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                        <?php 
                        $res = 0;
                        foreach($reservations as $key):
                        $res = $res + $key->total;?>
                        <tr>
                            <td><?=@$key->code?></td>
                            <td><?=@$key->name?></td>
                            <td><?=@$key->total + 0?></td>
                        </tr>
                        <?php endforeach; ?>
                <tbody>
            </table>
            <span style="text-align: right;float: right;">
                <br>
                <b>Total Order: <?= $res?> </b>
                <br>
            </span>
            <div class="clear"></div>
            </div>
        </div>
       </div>
        <div class="col-sm-12">
          <div class="white-box">
            <h3 class="box-title">Diagram Activity</h3>
            <div>
              <div class="row">
                <div class="col-md-12 col-lg-12 col-xs-12">
                  <div class="white-box">
                    <div id="morris-bar-chart"></div>
                  </div>
                </div>
              </div>
            <div class="clear"></div>
            </div>
          </div>
        </div>
      </div>
<script src="<?=$this->baseUrl()?>plugins/bower_components/raphael/raphael-min.js"></script>
<script src="<?=$this->baseUrl()?>plugins/bower_components/morrisjs/morris.js"></script>
<script src="<?=$this->baseUrl()?>js/morris-data.js"></script>
<script type="text/javascript">
      Morris.Bar({
        element: 'morris-bar-chart',
        data: [
        <?php foreach ($reservations as $key) : ?>
        {
            y: '<?=@$key->code?> - <?=@$key->name?>',         
            Penjualan: <?=@$key->total + 0?>,          
        },
        <?php endforeach; ?>
        ],
        xkey: 'y',
        ykeys: ['Penjualan'],
        labels: ['Penjualan'],
        barColors: ['#b4c1d7'],
        hideHover: 'auto',
        gridLineColor: '#eef0f2',
        resize: true
    });
</script>