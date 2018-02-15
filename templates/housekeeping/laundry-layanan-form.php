<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Data Barang',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    //'main_location' => 'Akunting',
    //'submain_location' => 'Tambah Data Header Account'
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

<form class="form-horizontal" action="<?php echo $this->pathFor('housekeeping-laundry-layanan-save'); ?>" method="post">
<div class="row">
        <div class="white-box">
            <h3 class="box-title m-b-0">Tambah Layanan Laundry</h3>
            <p class="text-muted m-b-30">Form Layanan Laundry</p>
            <div class="row">
              <div class="col-md-6">
              <input type="hidden" class="form-control" value="<?php echo @$menus->id ?>" name="id"></input>

              <div class="form-group">
              <label class="col-md-12"> <span class="help">Kode</span></label>
                  <div class="col-md-12"><input type="text" class="form-control" rows="3" name="kode" value="<?php echo @$menus->kode?>"></input></div>
              </div>

              <div class="form-group">
              <label class="col-md-12"> <span class="help">Nama</span></label>
                  <div class="col-md-12"><input type="text" class="form-control" rows="3" name="nama" value="<?php echo @$menus->nama?>"></input></div>
              </div>

              <div class="form-group">
                  <div class="col-md-12">
                    <div class="checkbox checkbox-success">
                    <?php if (!isset($menus)): ?>
                      <input id="aktif" name="aktif" type="checkbox" checked="checked" />
                      <label for="aktif"> Aktif</label>
                    <?php else: ?>
                      <input id="aktif" name="aktif" type="checkbox" <?php echo(($menus->aktif == 1) ? 'checked="checked"' : ''); ?> />
                      <label for="aktif"> Aktif</label>
                    <?php endif; ?>
                    </div>
                  </div>
              </div>

              <input type="hidden" class="form-control" rows="3" name="user" value="admin"></input>
              <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
              <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('housekeeping-laundry-layanan')?>">Batal</a>
          </div>
      </div>
    </div>
</div>

</form>
