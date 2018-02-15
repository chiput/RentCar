<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Status Meja',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Restoran',
    'submain_location' => 'Status Meja'
  ]);

?>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Form Data Meja </h3>
            <p class="text-muted m-b-30">Menambah Data Meja</p>
            <?php if (!is_null($errors)): ?>
            <div>
                <p>
                    Error:
                </p>
                <p>
                    <?php echo implode('<br>', $errors); ?>
                </p>
            </div>
            <?php endif; ?>
            <form class="form-horizontal" action="<?php echo $this->pathFor('meja-save'); ?>" method="post">
            <input type="hidden" class="form-control" value="<?php echo @$meja->id ?>" name="id">
            <div class="row">
                <div class="col-md-4">


                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Kapasitas</span></label>
                        <div class="col-md-12">
                            <input type="number" class="form-control" value="<?php echo @$meja->orang ?>" name="kapasitas">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Keterangan</span></label>
                        <div class="col-md-12">
                           <textarea class="form-control" name="keterangan"><?php echo @$meja->keterangan ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="checkbox checkbox-success">
                            <input id="active" type="checkbox" value="1" <?=@$meja->aktif==1?'checked="checked"':''?> name="is_active">
                            <label for="active"> Aktif </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
                    <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('meja')?>">Batal</a>
                </div>
            </div>
            
            

            </form>
        </div>
    </div>
</div>
