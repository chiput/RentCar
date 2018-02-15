<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Tambah Meja',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Restoran',
    'submain_location' => 'Meja'
  ]);

?>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
        <?php if ($this->getSessionFlash('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $this->getSessionFlash('success'); ?>
        </div>
        <?php endif; ?>

         <?php if ($this->getSessionFlash('error_messages')): ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <ul>
              <?php
                foreach($this->getSessionFlash('error_messages') as $key => $error) {
                ?>
                <li><?php echo $error; ?></li>
                <?php
                }
              ?>
              </ul>
            
        </div>
        <?php endif; ?>    
            <h3 class="box-title m-b-0">Form Meja</h3>
            <p class="text-muted m-b-30"></p>
            <form class="form-horizontal" action="<?php echo $this->pathFor('meja-save'); ?>" method="post">
            <input type="hidden" class="form-control" value="<?php echo @$meja->id ?>" name="id">

                <div class="col-md-6">

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Kode Meja</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$meja->kode_meja ?>" name="kode_meja">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Kapasitas Tamu</span></label>
                        <div class="col-md-12">
                            <input type="text" onchange="IsNumber(this.value,this.id)" class="form-control" value="<?php echo @$meja->max_tamu ?>" name="max_tamu">
                        </div>
                    </div>

                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Tipe Meja</span></label>
                        <div class="col-md-12">
                           <input class="form-control" name="tipe_meja" value="<?php echo @$meja->tipe_meja ?>">
                        </div>
                    </div>

                </div>  
                        <div class="form-group m-b-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
                            <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('meja')?>">Batal</a>
                        </div>
                        </div>
            </form>
        </div>
    </div>
</div>
