<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Reservasi Kamar',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Management',
    'submain_location' => 'Reservasi Kamar'
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
            <h3 class="box-title m-b-0">Management </h3>
            <p class="text-muted m-b-30">Analisa Reservasi</p>
            <form class="form-horizontal" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Tanggal</span></label>
                            <div class="col-md-12">
                                <div class="input-daterange input-group" id="date-range" data-date-format="dd-mm-yyyy">
                                    <input  type="text" class="form-control" name="start" value="<?=$d_start?>" >
                                    <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                                    <input type="text" class="form-control" name="end" value="<?=$d_end?>">
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
    </div>
    <div class="row">
            <div class="col-md-4">
                <div class="white-box">
                <h3 class="box-title">Laporan Reservasi</h3>             
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Reservasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // date loop
                                $current_date = convert_date($d_start);
                                while ( strtotime(convert_date($d_end)) >= strtotime($current_date) ):
                            ?>
                            <tr colspan="2" width="50">
                                <td>
                                    <center>
                                        <?php 
                                            echo date('d', strtotime($current_date)).' '; 
                                            echo date('M', strtotime($current_date)); ?>
                                    </center>
                                </td>
                                <td>
                                    <?= $analisa->analisa_reservasi($current_date)?>                                  
                                </td>
                            </tr>
                            <?php
                                    $dates[] = $current_date;
                                    $current_date = date('d-m-Y', strtotime($current_date.'+ 1 day'));
                                endwhile;
                                // date loop
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-8">
                <div class="white-box">
                    <h3 class="box-title">Reservasi</h3>
                    <div>
                    <canvas id="reservasi" height="150"></canvas>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
</div>
<script src="<?=$this->baseUrl()?>plugins/bower_components/Chart.js/Chart.min.js"></script>
<script type="text/javascript">
    var ctx1 = document.getElementById("reservasi").getContext("2d");
    var data1 = {
        labels: [
            <?php foreach(@$dates as $current_date){ ?>
                    "<?=date('d', strtotime($current_date)).' '.date('M', strtotime($current_date));?>",
            <?php } ?>
        ],
        datasets: [
            {
                label: "My First dataset",
                fillColor: "rgba(152,235,239,0.8)",
                strokeColor: "rgba(152,235,239,0.8)",
                pointColor: "rgba(152,235,239,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(152,235,239,1)",
                data: [
                <?php foreach(@$dates as $current_date){ ?>
                    <?= $analisa->analisa_reservasi($current_date)?>,
                <?php } ?>
                ]
            }
            
        ]
    };
    
    var chart1 = new Chart(ctx1).Line(data1, {
        scaleShowGridLines : true,
        scaleGridLineColor : "rgba(0,0,0,.005)",
        scaleGridLineWidth : 0,
        scaleShowHorizontalLines: true,
        scaleShowVerticalLines: true,
        bezierCurve : true,
        bezierCurveTension : 0.4,
        pointDot : true,
        pointDotRadius : 4,
        pointDotStrokeWidth : 1,
        pointHitDetectionRadius : 2,
        datasetStroke : true,
        tooltipCornerRadius: 2,
        datasetStrokeWidth : 2,
        datasetFill : true,
        legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
        responsive: true
    });
</script>