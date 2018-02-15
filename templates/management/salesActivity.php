<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Aktifitas Penjualan',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Management',
    'submain_location' => 'Aktifias Penjualan'
  ]);

//print_r($reservations);
$arrStatus=["Out Of Service","Dirty"];
?>
             <?php
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
            <h3 class="box-title m-b-0">Aktifitas Penjualan </h3>
            <p class="text-muted m-b-30">Data Aktifitas Penjualan</p>
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="help"> Sopir</span></label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="agent">
                                            <option value="">-Pilih Tipe-</option>
                                        <?php foreach ($agents as $key => $type) { ?>
                                            <option value="<?=$type->id?>" <?=($type->id==$agent?'selected="selected"':'')?>><?=$type->name?></option>
                                        <?php } ?>
                                        </select>
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
            <div class="col-md-12">
                <div class="white-box">
                    <div>
                    <canvas id="salesactivity" height="150"></canvas>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="white-box">
                     <h3 class="box-title">Tabel Aktifitas Penjualan</h3>
                       <table class="table table-striped myDataTable">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>No. Bukti</th>
                                <th>Peminjaman</th>
                                <th>Pengembalian</th>
                                <th>Pelanggan</th>
                                <th>No. Telephon</th>
                                <th>Sopir</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php 
                                $res = 0;$total = 0;$days = 0;
                                foreach($reservations as $reservation):
                                $res = $res + 1;?>
                                <tr>
                                    <td><?php echo convert_date(substr($reservation->tanggal,0,10))?></td>
                                    <td><?=$reservation->nobukti?></td>
                                    <td><?php echo convert_date(substr($reservation->checkin,0,10))?></td>
                                    <td><?php echo convert_date(substr($reservation->checkout,0,10))?></td>
                                    <td><?=@$reservation->guest->name?></td>
                                    <td><?=@$reservation->guest->phone?></td>
                                    <td><?=@$reservation->agent->name?></td>
                                    <td>
                                        <?php
                                            foreach ($reservation->details as $detail) {
                                                $days = $days + intval(abs(strtotime($reservation->checkin) - strtotime($reservation->checkout))/86400);
                                            }
                                            $total = $total + $reservation->prices + $reservation->priceExtras;
                                            echo 'Rp. '.$this->convert($reservation->prices + $reservation->priceExtras); 
                                        ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                        <tbody>
                    </table>
                    <span style="text-align: right;float: right;">
                        <br>
                        <b>Total Reservasi: <?= $res?> </b>
                        <b>Total Room Night: <?= $days?> </b>
                        <b>Total Revenue: <?= 'Rp. '.$this->convert($total); ?> </b>
                        <br>
                    </span> 
                    <div class="clear"></div>
                </div>
            </div>
       </div>        
      </div>
</div>
<script src="<?=$this->baseUrl()?>plugins/bower_components/Chart.js/Chart.min.js"></script>
<script type="text/javascript">
    var ctx1 = document.getElementById("salesactivity").getContext("2d");
    var data1 = {
        labels: [
            <?php foreach($reservations as $reservation){ ?>
                        "<?=@$reservation->guest->name;?>",
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
                <?php foreach($reservations as $reservation){ ?>
                        "<?=$reservation->prices + $reservation->priceExtras?>",
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
