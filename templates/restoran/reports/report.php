<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Laporan '.$jenis_laporan,
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
  ]);
?>

<?php if ($this->getSessionFlash('success')): ?>
<div class="row">
    <div class="alert alert-success alert-dismissable col-sm-12">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $this->getSessionFlash('success'); ?>
    </div>
</div>
<?php endif; ?>

<?php
if ($jenis_laporan=='Penjualan Menu'){
    $action=$this->pathFor('menu-penjualan-report');
}else if($jenis_laporan=='Pemakaian Bahan'){
     $action=$this->pathFor('pemakaianbahan-report');
}else if($jenis_laporan=='Penjualan Restoran'){
     $action=$this->pathFor('restoran-penjualan-report');
}else if($jenis_laporan=='Laba Penjualan Restoran'){
     $action=$this->pathFor('restoran-labapenjualan-report');
}
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0"><?=$jenis_laporan?></h3>
            <p class="text-muted m-b-5">Laporan <?=$jenis_laporan?></p>          
            <form class="form" method="POST" action="<?=$action?>">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-daterange input-group" id="date-range" data-date-format="yyyy-mm-dd">

                                <input  type="text" class="form-control" name="d_start" value="<?=date("Y-m-d")?>" >
                            <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                                <input type="text" class="form-control" name="d_end"
                                value="<?=date("Y-m-d")?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="form-control btn btn-info">Tampilkan</button>
                    </div>
                </div>
            </form>
        </div>
        
    </div>
</div>