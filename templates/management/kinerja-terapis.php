<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Kinerja Terapis',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Management',
    'submain_location' => 'Kinerja Terapis'
  ]); 
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
            <h3 class="box-title m-b-0">Kinerja Terapis</h3>
            <p class="text-muted m-b-30">Data Kinerja Terapis</p>
            <div class="tab-content">
                <form class="form" method="POST">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Tanggal</span></label>
                            <div class="col-md-6">
                            <div class="input-daterange input-group" id="date-range" data-date-format="dd-mm-yyyy">
                                <input  type="text" class="form-control" name="start" value="<?=$d_start?>" >
                                <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                                <input type="text" class="form-control" name="end" value="<?=$d_end?>">
                            </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button class="form-control btn btn-info">Filter</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="white-box">
            <table class="table table-striped myDataTable table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Terapis</th>
                        <th>Melayani</th>
                        <th>Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no=1; foreach ($kinerja as  $data): ?>
                    <tr id="trow-<?php echo $data->id; ?>">
                        <td><?php echo $no; ?>.</td>
                        <td><?php echo $data->terapis->nama; ?></td>
                        <td><?php echo $data->kuantitas; ?></td>
                        <td><?php echo "Rp. ".$this->convert($data->total); ?></td>
                    </tr>
                <?php $no++; endforeach; ?>
                </tbody>                           
            </table>
        </div>
    </div>
    <div class="col-md-8">
        <div class="white-box">
            <div id="morris-bar-chart"></div>
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
<script src="<?=$this->baseUrl()?>plugins/bower_components/raphael/raphael-min.js"></script>
<script src="<?=$this->baseUrl()?>plugins/bower_components/morrisjs/morris.js"></script>
<script src="<?=$this->baseUrl()?>js/morris-data.js"></script>
<script type="text/javascript">
      Morris.Bar({
        element: 'morris-bar-chart',
        data: [
        <?php foreach ($kinerja as $data) : ?>
        {
            y: '<?=$data->terapis->nama?>',         
            Penjualan: <?=@$data->total?>,          
        },
        <?php endforeach; ?>
        ],
        xkey: 'y',
        ykeys: ['Penjualan'],
        labels: ['Penjualan'],
        barColors: ['#8f7ac6'],
        hideHover: 'auto',
        gridLineColor: '#eef0f2',
        resize: true
    });
</script>

