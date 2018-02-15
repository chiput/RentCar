<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Tambah Menu Kategori',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Restoran',
    'submain_location' => 'Menu Kategori'
  ]);

?>

<?php if (@$errors!=""): ?>
<div class="row">
    <div class="alert alert-danger alert-dismissable col-sm-4">
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
            <h3 class="box-title m-b-0">Form Menu Kategori </h3>
            <p class="text-muted m-b-30"></p>
            <form class="form-horizontal" action="<?php echo $this->pathFor('menukategori-save'); ?>" method="post">
            <input type="hidden" class="form-control" value="<?php echo @$menu->id ?>" name="id">
                <div class="col-md-6">
                     <div class="form-group">
                        <label class="col-md-12"> <span class="help">Kode</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$menu->kode ?>" name="kode">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="checkbox checkbox-success">
                            <input id="active" type="checkbox" value="1" <?php if(@$menu->is_active==1||@$aktif==2){echo 'checked="checked"';}  ?>  name="is_active">
                            <label for="active"> Aktif </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">    
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Nama</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$menu->nama ?>" name="nama">
                        </div>
                    </div>
                </div>
                <div class="form-group m-b-0">
                    <div class="col-md-12">
                    <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
                    <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('menukategori')?>">Batal</a>
                    </div>
                </div>    
            </form>
        </div>
    </div>
</div>
