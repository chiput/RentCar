<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Tambah Fasilitas Kamar',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Setup',
    'submain_location' => 'Tambah Fasilitas Kamar'
  ]); 
?>


<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Form Fasilitas Kamar </h3>
            <p class="text-muted m-b-30"></p>

            <form class="form-horizontal" action="<?php echo $this->pathFor('setup-room-facility-save'); ?>" method="post">
            <input type="hidden" class="form-control" value="<?php echo @$room_facility->id ?>" name="id">

            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Nama Fasilitas Kamar</span></label>
                <div class="col-md-6">
                    <input type="text" class="form-control" value="<?php echo @$room_facility->name ?>" name="name">
                </div>
            </div>

            <div class="form-group hidden">
                <label class="col-md-12"> <span class="help"> Active</span></label>
                <div class="col-md-3">
                    <label><input type="radio" name="is_active" value="1" <?php if (!isset($room_facility) || @$room_facility->is_active == 1) { echo 'checked'; } ?> /> Aktif</label>
                    <label><input type="radio" name="is_active" value="0" <?php if (isset($room_facility) && $room_facility->is_active == 0) { echo 'checked'; } ?> /> Tidak Aktif</label>
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
