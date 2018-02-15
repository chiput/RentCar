<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Mobil Terfavorit',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Management',
    'submain_location' => 'Mobil Terfavorit'
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
            <h3 class="box-title m-b-0">Mobil Terfavorit </h3>
            <p class="text-muted m-b-30">Data Mobil Terfavorit</p>
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
                    <div class="col-md-2">
                        <label class="col-md-12"><span class="help">Sorting</span></label>
                        <div class="col-md-12">
                            <select class="form-control" name="sorting">
                                <option value="">-- pilih --</option>
                                <option value="5" <?=@$sorting==5?'selected="selected"':''?>>Top 5</option>
                                <option value="10" <?=@$sorting==10?'selected="selected"':''?>>Top 10</option>
                                <option value="20" <?=@$sorting==20?'selected="selected"':''?>>Top 20</option>
                            </select>
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
            <div class="col-md-3">
                <div class="white-box">
                    <h3 class="box-title">Keterangan Warna</h3>
                    <div class="col-md-12">
                      <ul class="list-inline m-t-30">
                        <?php foreach ($datas as $key => $data) { 
                             $key = $key + 1;
                             $data[$key] = random_color();?>
                            <li class="p-r-20">
                              <h5 class="text-muted"><i class="fa fa-circle" style="color: #<?= $data[$key]?>;"></i> <?= $data->room->number?></h5>
                            </li>
                        <?php } ?>
                        </ul>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="white-box">
                <h3 class="box-title">Mobil Terfavorit</h3>
                    <canvas id="chart2" height="150"></canvas>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
<?php 
    function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }

    function random_color() {
        return random_color_part() . random_color_part() . random_color_part();
    }
?>
$( document ).ready(function() {
    var ctx2 = document.getElementById("chart2").getContext("2d");

    var data2 = {
        labels: ["Mobil Terfavorit"],
        datasets: [
        <?php foreach ($datas as $key => $data) { 
            $key = $key + 1;
            ?>
            {
                label: "<?= $data->room->number?>",
                fillColor: '#<?= $data[$key]?>',
                strokeColor: '#<?= $data[$key]?>',
                highlightFill: '#<?= $data[$key]?>',
                highlightStroke: '#<?= $data[$key]?>',
                data: [<?= $data->jumlah; ?>]
            },
        <?php } ?>
        ]
    };

    var chart2 = new Chart(ctx2).Bar(data2, {
        scaleBeginAtZero : true,
        scaleShowGridLines : true,
        scaleGridLineColor : "rgba(0,0,0,.005)",
        scaleGridLineWidth : 0,
        scaleShowHorizontalLines: true,
        scaleShowVerticalLines: true,
        barShowStroke : true,
        barStrokeWidth : 0,
        tooltipCornerRadius: 2,
        barDatasetSpacing : 3,
        legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
        responsive: true
    });
});
</script>
<script src="<?=$this->baseUrl()?>plugins/bower_components/Chart.js/Chart.min.js"></script>