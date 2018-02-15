<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Menu Terfavorit',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Management',
    'submain_location' => 'Menu Terfavorit'
  ]);

function convert_date($date){
    $exp = explode('-', $date);
    if (count($exp)==3) {
        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
    }
    return $date;
}
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Menu Terfavorit</h3>
            <p class="text-muted m-b-30">Data Menu Terfavorit</p>
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
                    <div class="col-md-2" style="margin-top: 25px;">
                        <div class="form-group">
                            <button class="form-control btn btn-info">Filter</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                <h3 class="box-title">Menu Terfavorit</h3>
                    <div id="morris-line-chart"></div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$( document ).ready(function() {
    var day_data = [
        <?php 
            $total = [];
            foreach ($datas as $key => $data) { 
                $key = $key + 1;
                if (is_numeric($data->menuid)){ 
                    $data[$key] = $data->menu->nama; 
                    $total[$key] = $data->harga; 
                } else { 
                    $data[$key] = $data->menuid; 
                    $total[$key] = $data->harga / $data->bill;
                    $total[$key] = $total[$key] * $data->jumlah;
                } ?>
                {"period": "<?=$data[$key]?>", "penjualan": <?=$total[$key] ?>},
        <?php } ?>
    ];
    Morris.Bar({
      element: 'morris-line-chart',
      data: day_data,
      xkey: 'period',
      ykeys: ['penjualan'],
      labels: ['Penjualan'],
      xLabelAngle: 60
    });




});
</script>
<!--Morris JavaScript -->
<script src="<?=$this->baseUrl()?>plugins/bower_components/raphael/raphael-min.js"></script>
<script src="<?=$this->baseUrl()?>plugins/bower_components/morrisjs/morris.js"></script>