<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Kinerja Waiter',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Management',
    'submain_location' => 'Kinerja Waiter'
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
<?php if ($this->getSessionFlash('success')): ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('success'); ?>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Kinerja Waiter</h3>
            <p class="text-muted m-b-30">Data Kinerja Waiter</p>
            <form class="form" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <label class="col-md-12"> <span class="help"> Tanggal</span></label>
                        <div class="col-md-12">
                            <div class="input-daterange input-group" id="date-range" data-date-format="dd-mm-yyyy">
                                <input  type="text" class="form-control" name="start" value="<?=$d_start?>" >
                                    <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                                <input type="text" class="form-control" name="end" value="<?=$d_end?>">
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
                <h3 class="box-title">Kinerja Waiter</h3>             
                    <div id="morris-bar-chart"></div>
                    <div class="clear"></div>
                </div>
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
$( document ).ready(function() {
    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: 'Kinerja Waiter',
            <?php foreach ($kinerja as  $key => $waiter) { $key = $key + 1;?>
                <?php $waiter[$key] = random_color(); ?>
                <?=str_replace(' ', '', $waiter->waiter->nama)?>: <?=$waiter->total?>,
            <?php } ?>
        }],
        xkey: 'y',
        ykeys: [
            <?php foreach ($kinerja as  $waiter) { ?>
                '<?=str_replace(' ', '', $waiter->waiter->nama)?>',
            <?php } ?>
        ],
        labels: [
            <?php foreach ($kinerja as  $waiter) { ?>
                '<?=$waiter->waiter->nama?>',
            <?php } ?>
        ],
        barColors:[
            <?php foreach ($kinerja as  $key => $waiter) { $key = $key+1;?>
                '#<?=$waiter[$key]?>',
            <?php } ?>],
        hideHover: 'auto',
        gridLineColor: '#eef0f2',
        resize: true
    });

});
</script>
<!--Morris JavaScript -->
<script src="<?=$this->baseUrl()?>plugins/bower_components/raphael/raphael-min.js"></script>
<script src="<?=$this->baseUrl()?>plugins/bower_components/morrisjs/morris.js"></script>