<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Tambah Extension Telepon',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Management',
    'submain_location' => 'Biaya Telepon'
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
            <h3 class="box-title m-b-0">Form Biaya Telepon </h3>
            <p class="text-muted m-b-30"></p>
            <form class="form-horizontal" action="<?php echo $this->pathFor('telpextention-save'); ?>" method="post">
            <input type="hidden" class="form-control" value="<?php echo @$extion->id ?>" name="id">

            <div class="col-md-6">

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Extention</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$extion->extno;?>" name="ext">
                        </div>
                    </div>

            </div>
            <div class="col-md-6">

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Kamar</span></label>
                        <div class="col-md-12">
                            <select  class="form-control select2" name="room">
                                <option>Pilih Kamar</option>
                                <?php foreach($kamar as $kamar) { ?>
                                    <option value="<?=$kamar->id;?>" <?php if($kamar->id==@$extion->roomid){ echo "selected"; } ?>><?=$kamar->number?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

            </div>

                    <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
                    <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('telpextention')?>">Batal</a>
                   
            </form>
        </div>
    </div>
</div>