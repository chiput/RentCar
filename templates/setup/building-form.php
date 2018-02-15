<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Gedung',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Setup',
    'submain_location' => 'Form Gedung'
  ]); 
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Form Gedung </h3>
            <p class="text-muted m-b-30"></p>

            <?php if (!is_null($errors)): ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php print_r($errors); ?>
            </div>
            <?php endif; ?>

            <form class="form-horizontal" method="post" action="<?php echo $this->pathFor('setup-building-save') ?>">
            <input name="id" class="form-control" type="hidden" value="<?php echo @$building->id; ?>" />
                
            <div class="col-md-6">

                <div class="form-group">
                <label class="col-md-12"> <span class="help"> Nama Gedung</span></label>
                    <div class="col-md-12">
                    <input name="name" class="form-control" value="<?php echo @$building->name; ?>" type="text" />
                    </div>
                </div>

            </div>
            <div class="col-md-6">

                <div class="form-group">
                <label class="col-md-12"> <span class="help"> Keterangan</span></label>
                    <div class="col-md-12">
                    <textarea name="desc" rows="3" class="form-control"><?php echo @$building->desc; ?></textarea>
                    </div>
                </div>

            </div>

                <div class="form-group m-b-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Simpan</button>
                        <a class="btn btn-danger waves-effect waves-light m-t-10" href="javascript:window.history.back();">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>