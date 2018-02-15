<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Perusahaan',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Frontdesk',
    'submain_location' => 'Perusahaan'
  ]);

?>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Form Perusahaan </h3>
            <p class="text-muted m-b-30"></p>
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
            <form class="form-horizontal" action="<?php echo $this->pathFor('frontdesk-company-save'); ?>" method="post">
            <input type="hidden" class="form-control" value="<?php echo @$company->id ?>" name="id">
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Nama</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$company->name ?>" name="name">
                        </div>
                    </div>

                    <div class="form-group hidden">
                        <div class="checkbox checkbox-success">
                            <input id="active" type="checkbox" value="1" <?=@$company->is_active==1?'checked="checked"':''?> name="is_active">
                            <label for="active"> Aktif </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
                    <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('frontdesk-company')?>">Batal</a>
                </div>
            </div>
            
            

            </form>
        </div>
    </div>
</div>
