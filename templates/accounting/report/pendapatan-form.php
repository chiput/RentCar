<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => $judul,
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Akunting',
    'submain_location' => 'Tambah Data Header Account'
  ]); 
?>

<div class="error">
    <?php print_r(@$errors) ?>
</div>

<div class="row">
    <div class="col-sm-12">
      <div class="white-box">

        <h3 class="box-title m-b-0"><?= $judul; ?></h3>
        <p class="text-muted m-b-20 font-13"> </p>
        <?php if($pendapatan == 'restorante'){ ?>
            <form class="form-horizontal" action="<?php echo $this->pathFor('pendapatan-restorante') ?>" method="POST" target="_blank">
        <?php } elseif($pendapatan == 'whitehouse'){ ?>
            <form class="form-horizontal" action="<?php echo $this->pathFor('pendapatan-whitehouse') ?>" method="POST" target="_blank">
        <?php } elseif($pendapatan == 'spa'){ ?>
            <form class="form-horizontal" action="<?php echo $this->pathFor('pendapatan-spa') ?>" method="POST" target="_blank">
        <?php } elseif($pendapatan == 'checkout'){ ?>
            <form class="form-horizontal" action="<?php echo $this->pathFor('pendapatan-checkout') ?>" method="POST" target="_blank">
        <?php } elseif($pendapatan == 'rekap'){ ?>
            <form class="form-horizontal" action="<?php echo $this->pathFor('pendapatan-rekap') ?>" method="POST" target="_blank">
        <?php } ?>
            <div class="form-group">    
                <label class="col-md-12"> 
                    <span class="help"> Tanggal Laporan </span>
                </label>
                <div class="col-md-6">
                <div class="input-daterange input-group" id="date-range" data-date-format="dd-mm-yyyy">
                    
                        <input  type="text" class="form-control" name="start" value="01-<?=date("m-Y")?>" />
                    <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                        <input type="text" class="form-control" name="end" 
                        value="<?=date("t-m-Y")?>" />
                </div>
               </div> 
            </div>

        <div class="form-group m-b-0">
            <div class="col-md-12">
                <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Tampilkan</button>
            </div>
        </div>
            
        </form>
      </div>
    </div>
</div>
