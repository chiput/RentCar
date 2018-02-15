<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Tambah Waiter',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Restoran',
    'submain_location' => 'Waiter'
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
            <h3 class="box-title m-b-0">Form Waiter </h3>
            <p class="text-muted m-b-30"></p>
            <form class="form-horizontal" action="<?php echo $this->pathFor('waiter-save'); ?>" method="post">
            <input type="hidden" class="form-control" value="<?php echo @$waiter->id ?>" name="id">

                <div class="col-md-6">

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Kode</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$waiter->kode;echo @$kodewaiter; ?>" name="kode">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Nama</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php  if(@$waiter->nama){ echo @$waiter->nama;}else{echo @$nama;} ?>" name="nama">
                        </div>
                    </div>

                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Telpon</span></label>
                        <div class="col-md-12">
                            <input type="text" onchange="IsNumber(this.value,this.id)" class="form-control" value="<?php if(@$waiter->telepon){ echo @$waiter->telepon;}else{echo @$telpon;}?>" name="telpon">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Alamat</span></label>
                        <div class="col-md-12">
                           <textarea class="form-control" rows="3" name="alamat"><?php if(@$waiter->alamat){ echo @$waiter->alamat;}else{echo @$alamat;} ?></textarea>
                        </div>
                    </div>

                </div>    
                    
                    <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
                    <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('waiter')?>">Batal</a>            
            </form>
        </div>
    </div>
</div>