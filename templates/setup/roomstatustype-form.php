<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Tipe Status Mobil',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Tipe Status Mobil',
    'submain_location' => 'Tipe Status Mobil'
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
        
        <h3 class="box-title m-b-0">Form Status Mobil</h3>
        <p class="text-muted m-b-30"></p>
        <form class="form-horizontal" action="<?=$this->pathFor('room-status-type-save'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" class="form-control" value="<?=@$roomstatus->id?>" name="id">
 
        <div class="col-md-6">

                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Kode</span></label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" maxlength="3" value="<?=@$roomstatus->code?>" name="code">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Keterangan</span></label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" value="<?=@$roomstatus->desc?>" name="desc">
                    </div>
                </div>

        </div>
        <div class="col-md-6">

                <div class="form-group">
                    <label class="col-md-12"> <span class="help">Status</span></label>
                    <div class="col-md-12">
                        <select  class="form-control" name="status">
                        <?php 
                        $status = array( 0 => "Tidak Aktif", 1 => "Aktif");
                        foreach($status as $key => $value) { ?>
                            <option
                            <?=@$roomstatus->status==$key?'selected="selected"':''?>
                             value="<?=$key?>"><?=$value?></option>
                        <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Ikon</span></label>
                    <div class="col-md-12">
                        <input type="file" class="form-control" name="icon">
                        <br/>
                        <?php if (@$roomstatus->icon != ''): ?>
                            <img src="data:image/png;base64,<?=$roomstatus->icon?>" />
                        <?php endif; ?>
                    </div>
                </div>

        </div>

            <div class="form-group m-b-0">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Simpan</button>
                    <a class="btn btn-danger waves-effect waves-light m-t-10" href="<?=$this->pathFor('setup-room-status-type')?>">Batal</a>
                </div>
            </div>
        </form>
      </div>
    </div>
</div>
