<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Layanan Terfavorit',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Management',
    'submain_location' => 'Layanan Terfavorit'
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
            <h3 class="box-title m-b-0">Layanan Terfavorit</h3>
            <p class="text-muted m-b-30">Data Layanan Terfavorit</p>
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
            <div class="col-md-6">
                <div class="white-box">
                <h3 class="box-title">Layanan Terfavorit</h3>
                    <canvas id="chart3" height="150"></canvas>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="white-box">
                <h3 class="box-title">Layanan Terfavorit Tabel</h3>
                   <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Layanan</th>
                                <th>Kuantitas</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            foreach ($datas as $data) { ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $data->layanan->nama_layanan; ?></td>
                                    <td><?= $data->jumlah; ?></td>
                                    <td>Rp. <?= $this->convert($data->harga); ?></td>
                                </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }

    function random_color() {
        return random_color_part() . random_color_part() . random_color_part();
    }
?>
<script type="text/javascript">
    $(function(){
        var ctx3 = document.getElementById("chart3").getContext("2d");
        var data3 = [
            <?php foreach ($datas as $data) { $color = random_color();?>
                {
                    value: <?= $data->jumlah; ?>,
                    color:"#<?=$color?>",
                    highlight: "#<?=$color?>",
                    label: "<?= $data->layanan->nama_layanan; ?>"
                },
            <?php } ?>
        ];
        
        var myPieChart = new Chart(ctx3).Pie(data3,{
            segmentShowStroke : true,
            segmentStrokeColor : "#fff",
            segmentStrokeWidth : 0,
            animationSteps : 100,
            tooltipCornerRadius: 0,
            animationEasing : "easeOutBounce",
            animateRotate : true,
            animateScale : false,
            legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>",
            responsive: true
        });
    });
</script>
<script src="<?=$this->baseUrl()?>plugins/bower_components/Chart.js/Chart.min.js"></script>
