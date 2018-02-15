<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Tambah Departemen',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Setup',
    'submain_location' => 'Tambah Departemen'
  ]); 
?>

<?php if (@$errors!=""): ?>
<div class="row">
    <div class="alert alert-danger alert-dismissable col-sm-6">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php foreach($errors as $error){
            echo $error."<br>";
        } ?>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Form Departement </h3>
            <p class="text-muted m-b-30"></p>
            <form class="form-horizontal" method="post" action="<?php echo $this->pathFor('setup-department-save') ?>">
            <input name="id" class="form-control" type="hidden" value="<?php echo @$department->id; ?>" />

            <div class="col-md-6">

                <div class="form-group">
                <label class="col-md-12"> <span class="help"> Kode </span></label>
                    <div class="col-md-12">
                    <input name="code" class="form-control" value="<?php echo @$department->code; ?>" type="text" />
                    </div>
                </div>
                <div class="form-group">
                <label class="col-md-12"> <span class="help"> Nama</span></label>
                    <div class="col-md-12">
                    <input name="name" class="form-control" value="<?php echo @$department->name; ?>" type="text" />
                    </div>
                </div>

            </div>
            <div class="col-md-6">

                <div class="form-group">
                <label class="col-md-12"> <span class="help"> Keterangan</span></label>
                    <div class="col-md-12">
                    <textarea name="ket" rows="3" class="form-control" value="<?php echo @$department->ket; ?>" type="text" /></textarea>
                    </div>
                </div>

            </div>

                <div class="form-group">
                    <div class="col-md-12">
                      <div class="checkbox checkbox-success">
                      <?php if (!isset($department)): ?>
                        <input id="is_active" name="is_active" type="checkbox" checked="checked" />
                        <label for="is_active"> Aktif</label>
                      <?php else: ?>
                        <input id="is_active" name="is_active" type="checkbox" <?php echo(($department->is_active == 1) ? 'checked="checked"' : ''); ?> />
                        <label for="is_active"> Aktif</label>
                      <?php endif; ?>
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