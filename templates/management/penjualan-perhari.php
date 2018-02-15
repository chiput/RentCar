<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Penjualan Perhari',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Management',
    'submain_location' => 'Penjualan Perhari'
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
            <h3 class="box-title m-b-0">Penjualan Perhari </h3>
            <p class="text-muted m-b-30">Data Penjualan Perhari</p>
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
<!--                     <div class="col-md-2">
                        <label class="col-md-12"><span class="help">Sorting</span></label>
                        <div class="col-md-12">
                            <select class="form-control" name="sorting">
                                <option value="">-- pilih --</option>
                                <option value="5" <?=@$sorting==5?'selected="selected"':''?>>Top 5</option>
                                <option value="10" <?=@$sorting==10?'selected="selected"':''?>>Top 10</option>
                                <option value="20" <?=@$sorting==20?'selected="selected"':''?>>Top 20</option>
                            </select>
                        </div>
                    </div> -->
                    <div class="col-md-2" style="margin-top: 25px;">
                        <div class="form-group">
                            <button class="form-control btn btn-info">Filter</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>    
        <div class="row">
            <div class="col-md-4">
                <div class="white-box">
                    <h3 class="box-title">Keterangan</h3>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $jml_senin = 0; $jml_selasa = 0; $jml_rabu = 0; $jml_kamis = 0; 
                            $jml_jumat = 0; $jml_sabtu = 0; $jml_minggu = 0;
                            $hari=array();
                            $jumlah=array();
                            foreach ($datas as $key => $data) { 
                                $hari[] = $data->date;
                                $jumlah[] = $data->jumlah;
                            }
                            $count = count($hari);
                            for ($i=0; $i < $count; $i++) { 
                                if ($hari[$i] == "Monday" ) {
                                    $a = array_search($hari[$i], $hari);
                                    $jml_senin = $jumlah[$a];
                                }
                                if ($hari[$i] == "Tuesday") {
                                    $a = array_search($hari[$i], $hari);
                                    $jml_selasa = $jumlah[$a];
                                }
                                if ($hari[$i] == "Wednesday") {
                                    $a = array_search($hari[$i], $hari);
                                    $jml_rabu = $jumlah[$a];
                                }
                                if ($hari[$i] == "Thursday") {
                                    $a = array_search($hari[$i], $hari);
                                    $jml_kamis = $jumlah[$a];
                                }
                                if ($hari[$i] == "Friday") {
                                    $a = array_search($hari[$i], $hari);
                                    $jml_jumat = $jumlah[$a];
                                }
                                if ($hari[$i] == "Saturday") {
                                    $a = array_search($hari[$i], $hari);
                                    $jml_sabtu = $jumlah[$a];
                                }
                                if ($hari[$i] == "Sunday") {
                                    $a = array_search($hari[$i], $hari);
                                    $jml_minggu = $jumlah[$a];
                                }
                            }
                            ?>
                            <tr>
                                <td>Senin</td>
                                <td>Rp. <?= $this->convert($jml_senin); ?></td>   
                            </tr>
                            <tr>
                                <td>Selasa</td>
                                <td>Rp. <?= $this->convert($jml_selasa); ?></td>   
                            </tr>
                            <tr>
                                <td>Rabu</td>
                                <td>Rp. <?= $this->convert($jml_rabu); ?></td>   
                            </tr>
                            <tr>
                                <td>Kamis</td>
                                <td>Rp. <?= $this->convert($jml_kamis); ?></td>   
                            </tr>
                            <tr>
                                <td>Jumat</td>
                                <td>Rp. <?= $this->convert($jml_jumat); ?></td>   
                            </tr>
                            <tr>
                                <td>Sabtu</td>
                                <td>Rp. <?= $this->convert($jml_sabtu); ?></td>   
                            </tr>
                            <tr>
                                <td>Minggu</td>
                                <td>Rp. <?= $this->convert($jml_minggu); ?></td>   
                            </tr>
                        </tbody>
                    </table>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="white-box">
                <h3 class="box-title">Penjualan Perhari</h3>
                    <div id="chart" class="ecomm-donute" style="height: 317px;"></div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?=$this->baseUrl()?>plugins/bower_components/raphael/raphael-min.js"></script>
<script src="<?=$this->baseUrl()?>plugins/bower_components/morrisjs/morris.js"></script>
<script src="<?=$this->baseUrl()?>js/morris-data.js"></script>

<script type="text/javascript">
<?php 
    function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }

    function random_color() {
        return random_color_part() . random_color_part() . random_color_part();
    }
?>
  Morris.Line({
      element: 'chart',
      data: [
        { period: 'Senin', value: <?=$jml_senin?>},
        { period: 'Selasa', value: <?=$jml_selasa?>},
        { period: 'Rabu', value: <?=$jml_rabu?>},
        { period: 'Kamis', value: <?=$jml_kamis?>},
        { period: 'Jumat', value: <?=$jml_jumat?>},
        { period: 'Sabtu', value: <?=$jml_sabtu?>},
        { period: 'Minggu', value: <?=$jml_minggu?>}
      ],
      lineColors: ['#fc8710'],
      xkey: 'period',
      ykeys: ['value'],
      labels: ['Penjualan'],
      parseTime: false,
      hideHover:true,
      lineWidth:'3px',
      stacked: true,
      resize: true
    });
</script>