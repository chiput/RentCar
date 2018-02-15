<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Analisa Keuangan',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Management',
    'submain_location' => 'Analisa Keuangan'
  ]); 

  // convert date
  function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }
$dates = [];
?>

<?php if ($this->getSessionFlash('success')): ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('success'); ?>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Keuangan</h3>
            <p class="text-muted m-b-30">Data Keuangan</p>
            <form class="form" method="POST">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-daterange input-group" id="date-range" data-date-format="dd-mm-yyyy">
                            <input  type="text" class="form-control" name="start" value="<?=$d_start?>" >
                            <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                            <input type="text" class="form-control" name="end" value="<?=$d_end?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" name="status">
                            <option value="1" <?php if($status==1){echo "selected";}?>>Harian</option>
                            <option value="2" <?php if($status==2){echo "selected";}?>>Bulanan</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="form-control btn btn-info">Filter</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="white-box">
                <h3 class="box-title">Laporan Keuangan</h3>             
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tgl</th>
                                <th>Pendapatan</th>
                                <th>Pengeluaran</th>
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
                                        if($status==1){
                                            echo date('d', strtotime($current_date)); 
                                            echo date('M', strtotime($current_date)); 
                                        } else { 
                                            echo date('M', strtotime($current_date));
                                        } ?>
                                    </center>
                                </td>
                                <td>
                                    Rp. <?= $this->convert($analisa->pendapatan($current_date,$status));?>                                    
                                </td>
                                <td>
                                    Rp. <?= $this->convert($analisa->pengeluaran($current_date,$status));?>   
                                </td>
                            </tr>
                            <?php
                                    $dates[] = $current_date;
                                    if($status==1){
                                        $current_date = date('d-m-Y', strtotime($current_date.'+ 1 day'));
                                    } else {
                                        $current_date = date('d-m-Y', strtotime($current_date.'+ 1 month'));
                                    }
                                endwhile;
                                // date loop
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-8">
                <div class="white-box">
                    <h3 class="box-title">Pendapatan</h3>
                    <div>
                    <canvas id="pendapatan" height="150"></canvas>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="white-box">
                    <h3 class="box-title">Pengeluaran</h3>
                    <div>
                    <canvas id="pengeluaran" height="150"></canvas>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<script src="<?=$this->baseUrl()?>plugins/bower_components/Chart.js/Chart.min.js"></script>
<script type="text/javascript">
    var ctx1 = document.getElementById("pendapatan").getContext("2d");
    var data1 = {
        labels: [
            <?php foreach(@$dates as $current_date){ ?>
                    <?php if($status==1){ ?>
                        "<?=date('d', strtotime($current_date)).' '.date('M', strtotime($current_date));?>",
                    <?php } else { ?>
                        "<?=date('M', strtotime($current_date));?>",
                    <?php } ?>
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
                    <?= $analisa->pendapatan($current_date,$status)?>,
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

    //pengeluaran
    var ctx1 = document.getElementById("pengeluaran").getContext("2d");
    var data1 = {
        labels: [
            <?php foreach(@$dates as $current_date){ ?>
                    <?php if($status==1){ ?>
                        "<?=date('d', strtotime($current_date)).' '.date('M', strtotime($current_date));?>",
                    <?php } else { ?>
                        "<?=date('M', strtotime($current_date));?>",
                    <?php } ?>
            <?php } ?>
        ],
        datasets: [
            {
                label: "My First dataset",
                fillColor: "#fb9678",
                strokeColor: "#ff6849",
                pointColor: "#fb9678",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "#fb9678",
                data: [
                <?php foreach(@$dates as $current_date){ ?>
                    <?= $analisa->pengeluaran($current_date,$status)?>,
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
