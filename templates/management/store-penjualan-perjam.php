<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Penjualan Perjam',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Management',
    'submain_location' => 'Penjualan Perjam'
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
            <h3 class="box-title m-b-0">Penjualan Perjam </h3>
            <p class="text-muted m-b-30">Data Penjualan Perjam</p>
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
            <div class="col-md-4">
                <div class="white-box">
                    <h3 class="box-title">Keterangan</h3>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $jml_01 = 0; $jml_02 = 0; $jml_03 = 0; $jml_04 = 0; 
                            $jml_05 = 0; $jml_06 = 0; $jml_07 = 0; $jml_08 = 0;
                            $jml_09 = 0; $jml_10 = 0; $jml_11 = 0; $jml_12 = 0;
                            $jml_13 = 0; $jml_14 = 0; $jml_15 = 0; $jml_16 = 0;
                            $jml_17 = 0; $jml_18 = 0; $jml_19 = 0; $jml_20 = 0;
                            $jml_21 = 0; $jml_22 = 0; $jml_23 = 0; $jml_00 = 0;
                            $jam=array();
                            $jumlah=array();
                            foreach ($datas as $key => $data) { 
                                $jam[] = $data->hour;
                                $jumlah[] = $data->jumlah;
                            }

                            $count = count($jam);
                            for ($i=0; $i < $count; $i++) { 
                                if ($jam[$i] == "1" ) {
                                    $a = array_search($jam[$i], $jam);
                                    $jml_01 = $jumlah[$a];
                                }
                                if ($jam[$i] == "2") {
                                    $a = array_search($jam[$i], $jam);
                                    $jml_02 = $jumlah[$a];
                                }
                                if ($jam[$i] == "3") {
                                    $a = array_search($jam[$i], $jam);
                                    $jml_03 = $jumlah[$a];
                                }
                                if ($jam[$i] == "4") {
                                    $a = array_search($jam[$i], $jam);
                                    $jml_04 = $jumlah[$a];
                                }
                                if ($jam[$i] == "5") {
                                    $a = array_search($jam[$i], $jam);
                                    $jml_05 = $jumlah[$a];
                                }
                                if ($jam[$i] == "6") {
                                    $a = array_search($jam[$i], $jam);
                                    $jml_06 = $jumlah[$a];
                                }
                                if ($jam[$i] == "7") {
                                    $a = array_search($jam[$i], $jam);
                                    $jml_07 = $jumlah[$a];
                                }
                                if ($jam[$i] == "8") {
                                    $a = array_search($jam[$i], $jam);
                                    $jml_08 = $jumlah[$a];
                                }
                                if ($jam[$i] == "9") {
                                    $a = array_search($jam[$i], $jam);
                                    $jml_09 = $jumlah[$a];
                                }
                                if ($jam[$i] == "10") {
                                    $a = array_search($jam[$i], $jam);
                                    $jml_10 = $jumlah[$a];
                                }
                                if ($jam[$i] == "11") {
                                    $a = array_search($jam[$i], $jam);
                                    $jml_11 = $jumlah[$a];
                                }
                                if ($jam[$i] == "12") {
                                    $a = array_search($jam[$i], $jam);
                                    $jml_12 = $jumlah[$a];
                                }
                                if ($jam[$i] == "13") {
                                    $a = array_search($jam[$i], $jam);
                                    $jml_13 = $jumlah[$a];
                                }
                                if ($jam[$i] == "14") {
                                    $a = array_search($jam[$i], $jam);
                                    $jml_14 = $jumlah[$a];
                                }
                                if ($jam[$i] == "15") {
                                    $a = array_search($jam[$i], $jam);
                                    $jml_15 = $jumlah[$a];
                                }
                                if ($jam[$i] == "16") {
                                    $a = array_search($jam[$i], $jam);
                                    $jml_16 = $jumlah[$a];
                                }
                                if ($jam[$i] == "17") {
                                    $a = array_search($jam[$i], $jam);
                                    $jml_17 = $jumlah[$a];
                                }
                                if ($jam[$i] == "18") {
                                    $a = array_search($jam[$i], $jam);
                                    $jml_18 = $jumlah[$a];
                                }
                                if ($jam[$i] == "19") {
                                    $a = array_search($jam[$i], $jam);
                                    $jml_19 = $jumlah[$a];
                                }
                                if ($jam[$i] == "20") {
                                    $a = array_search($jam[$i], $jam);
                                    $jml_20 = $jumlah[$a];
                                }
                                if ($jam[$i] == "21") {
                                    $a = array_search($jam[$i], $jam);
                                    $jml_21 = $jumlah[$a];
                                }
                                if ($jam[$i] == "22") {
                                    $a = array_search($jam[$i], $jam);
                                    $jml_22 = $jumlah[$a];
                                }
                                if ($jam[$i] == "23") {
                                    $a = array_search($jam[$i], $jam);
                                    $jml_23 = $jumlah[$a];
                                }
                                if ($jam[$i] == "0") {
                                    $a = array_search($jam[$i], $jam);
                                    $jml_00 = $jumlah[$a];
                                }
                            }
                            ?>
                            <tr>
                                <td>00:00</td>
                                <td>Rp. <?= $this->convert($jml_00); ?></td>
                            </tr>
                            <tr>
                                <td>01:00</td>
                                <td>Rp. <?= $this->convert($jml_01); ?></td>
                            </tr>
                            <tr>
                                <td>02:00</td>
                                <td>Rp. <?= $this->convert($jml_02); ?></td>
                            </tr>
                            <tr>
                                <td>03:00</td>
                                <td>Rp. <?= $this->convert($jml_03); ?></td>
                            </tr>
                            <tr>
                                <td>04:00</td>
                                <td>Rp. <?= $this->convert($jml_04); ?></td>
                            </tr>
                            <tr>
                                <td>05:00</td>
                                <td>Rp. <?= $this->convert($jml_05); ?></td>
                            </tr>
                            <tr>
                                <td>06:00</td>
                                <td>Rp. <?= $this->convert($jml_06); ?></td>
                            </tr>
                            <tr>
                                <td>07:00</td>
                                <td>Rp. <?= $this->convert($jml_07); ?></td>
                            </tr>
                            <tr>
                                <td>08:00</td>
                                <td>Rp. <?= $this->convert($jml_08); ?></td>
                            </tr>
                            <tr>
                                <td>09:00</td>
                                <td>Rp. <?= $this->convert($jml_09); ?></td>
                            </tr>
                            <tr>
                                <td>10:00</td>
                                <td>Rp. <?= $this->convert($jml_10); ?></td>
                            </tr>
                            <tr>
                                <td>11:00</td>
                                <td>Rp. <?= $this->convert($jml_11); ?></td>
                            </tr>
                            <tr>
                                <td>12:00</td>
                                <td>Rp. <?= $this->convert($jml_12); ?></td>
                            </tr>
                            <tr>
                                <td>13:00</td>
                                <td>Rp. <?= $this->convert($jml_13); ?></td>
                            </tr>
                            <tr>
                                <td>14:00</td>
                                <td>Rp. <?= $this->convert($jml_14); ?></td>
                            </tr>
                            <tr>
                                <td>15:00</td>
                                <td>Rp. <?= $this->convert($jml_15); ?></td>
                            </tr>
                            <tr>
                                <td>16:00</td>
                                <td>Rp. <?= $this->convert($jml_16); ?></td>
                            </tr>
                            <tr>
                                <td>17:00</td>
                                <td>Rp. <?= $this->convert($jml_17); ?></td>
                            </tr>
                            <tr>
                                <td>18:00</td>
                                <td>Rp. <?= $this->convert($jml_18); ?></td>
                            </tr>
                            <tr>
                                <td>19:00</td>
                                <td>Rp. <?= $this->convert($jml_19); ?></td>
                            </tr>
                            <tr>
                                <td>20:00</td>
                                <td>Rp. <?= $this->convert($jml_20); ?></td>
                            </tr>
                            <tr>
                                <td>21:00</td>
                                <td>Rp. <?= $this->convert($jml_21); ?></td>
                            </tr>
                            <tr>
                                <td>22:00</td>
                                <td>Rp. <?= $this->convert($jml_22); ?></td>
                            </tr>
                            <tr>
                                <td>23:00</td>
                                <td>Rp. <?= $this->convert($jml_23); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="white-box">
                <h3 class="box-title">Penjualan Perjam</h3>
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
        { period: '00:00', value: <?=$jml_00?>},
        { period: '01:00', value: <?=$jml_01?>},
        { period: '02:00', value: <?=$jml_02?>},
        { period: '03:00', value: <?=$jml_03?>},
        { period: '04:00', value: <?=$jml_04?>},
        { period: '05:00', value: <?=$jml_05?>},
        { period: '06:00', value: <?=$jml_06?>},
        { period: '07:00', value: <?=$jml_07?>},
        { period: '08:00', value: <?=$jml_08?>},
        { period: '09:00', value: <?=$jml_09?>},
        { period: '10:00', value: <?=$jml_10?>},
        { period: '11:00', value: <?=$jml_11?>},
        { period: '12:00', value: <?=$jml_12?>},
        { period: '13:00', value: <?=$jml_13?>},
        { period: '14:00', value: <?=$jml_14?>},
        { period: '15:00', value: <?=$jml_15?>},
        { period: '16:00', value: <?=$jml_16?>},
        { period: '17:00', value: <?=$jml_17?>},
        { period: '18:00', value: <?=$jml_18?>},
        { period: '19:00', value: <?=$jml_19?>},
        { period: '20:00', value: <?=$jml_20?>},
        { period: '21:00', value: <?=$jml_21?>},
        { period: '22:00', value: <?=$jml_22?>},
        { period: '23:00', value: <?=$jml_23?>}
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