<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Pelanggan Terfavorit',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Management',
    'submain_location' => 'Pelanggan Terfavorit'
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
            <h3 class="box-title m-b-0">Pelanggan Terfavorit </h3>
            <p class="text-muted m-b-30">Data Pelanggan Terfavorit</p>
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
                    <h3 class="box-title">Pelanggan Terfavorit</h3>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Reservasi</th>
                                <th>Negara</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            foreach ($datas as $data) { ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $data->guest->name; ?></td>
                                    <td><?= $data->jumlah; ?></td>
                                    <td><?= $data->guest->country->nama; ?></td>
                                </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <div class="white-box">
                    <h3 class="box-title">Grafik Pelanggan Terfavorit</h3>
                    <div id="morris-donut-chart"></div>
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
    $(function() {
        Morris.Donut({
            element: 'morris-donut-chart',
            data: [
                <?php foreach ($datas as $data) { ?>
                    {
                        label: "<?= $data->guest->name; ?>",
                        value: <?= $data->jumlah; ?>,

                    },
                <?php } ?>
            ],
            resize: true,
            colors:[
                <?php foreach ($datas as $key => $data) { ?>
                    '#<?= random_color()?>',
                <?php } ?>
            ]
        });
    });
</script>
