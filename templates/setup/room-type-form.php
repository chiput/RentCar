<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Tambah Jenis Mobil',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Setup',
    'submain_location' => 'Tambah Jenis Mobil'
  ]); 
?>


<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Form Jenis Mobil </h3>
            <p class="text-muted m-b-30"></p>

            <form class="form-horizontal" action="<?php echo $this->pathFor('setup-room-type-save'); ?>" method="post">
            <input type="hidden" class="form-control" value="<?php echo @$room_type->id ?>" name="id">

            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Nama Jenis Mobil</span></label>
                <div class="col-md-6">
                    <input type="text" class="form-control" value="<?php echo @$room_type->name ?>" name="name">
                </div>
            </div>

            <div class="form-group hidden">
                <div class="col-md-12">
                  <div class="checkbox checkbox-success">
                  <?php if (!isset($room_type)): ?>
                    <input id="is_active" name="is_active" type="checkbox" checked="checked" value="1"/>
                    <label for="is_active"> Active</label>
                  <?php else: ?>
                    <input id="is_active" name="is_active" type="checkbox" <?php echo(($room_type->is_active == 1) ? 'checked="checked"' : ''); ?> value="1" />
                    <label for="is_active"> Active</label>
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
