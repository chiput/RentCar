<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Supplier',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Supplier',
    'submain_location' => 'Supplier'
  ]); 
?>



<div class="row">
    <div class="col-sm-12">
      <div class="white-box">
        <?php if ($this->getSessionFlash('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?=$this->getSessionFlash('success'); ?>
        </div>
        <?php endif; ?>

         <?php if ($this->getSessionFlash('error_messages')): ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <ul>
              <?php
                foreach($this->getSessionFlash('error_messages') as $key => $error) {
                ?>
                <li><?=$error?></li>
                <?php
                }
              ?>
              </ul>
            
        </div>
        <?php endif; ?>    
        
        <h3 class="box-title m-b-0">Form Supplier</h3>
        <p class="text-muted m-b-30"></p>
        <form class="form-horizontal" action="<?=$this->pathFor('pembelian-supplier-save'); ?>" method="post">
        <input type="hidden" class="form-control" value="<?=@$supplier->id?>" name="id">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Kode Supplier</span></label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" value="<?=@$supplier->kode?>" name="kode">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Nama Supplier</span></label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" value="<?=@$supplier->nama?>" name="nama">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Alamat</span></label>
                    <div class="col-md-12">
                        <textarea class="form-control" name="alamat" rows="3"><?=@$supplier->alamat?></textarea>
                    </div>
                </div>
                
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Contact Person</span></label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" value="<?=@$supplier->contact?>" name="contact">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-12"> <span class="help">Kota</span></label>
                    <div class="col-md-12">
                        <select  class="form-control select2" name="kotaid">
                        <?php foreach($kotas as $kota) { ?>
                            <option
                            <?=@$supplier->kotaid==$kota->id?'selected="selected"':''?>
                             value="<?=$kota->id?>"><?=$kota->nama?></option>
                        <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Telepon</span></label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" value="<?=@$supplier->telepon?>" name="telepon">
                    </div>
                </div>
            
                <div class="form-group m-b-0">
                    <div class="col-md-12">
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Simpan</button>
                        <a class="btn btn-danger waves-effect waves-light m-t-10" href="javascript:window.history.back();">Batal</a>
        </div>
        </form>
      </div>
    </div>
</div>
