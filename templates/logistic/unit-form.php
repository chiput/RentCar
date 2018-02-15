<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Tambah Data Satuan',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Logistik',
    'submain_location' => 'Tambah Data Satuan'
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
        <h3 class="box-title m-b-0">Form Unit</h3>
        <p class="text-muted m-b-20 font-13"> </p>
        <form class="form-horizontal" action="<?php echo $this->pathFor('logistic-unit-save') ?>" method="POST">
        <input type="hidden" class="form-control" value="<?=@$unit->id?>" name="id">
        <div class="form-group col-md-6">
            <label class="col-md-12"> <span class="help"> Nama</span></label>
            <div class="col-md-12">
              <input type="text" class="form-control" value="<?=@$unit->nama?>" name="nama">
            </div>
        </div>
        
        <div class="form-group m-b-0">
            <div class="col-md-12">
                <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Simpan</button>
                <a class="btn btn-danger waves-effect waves-light m-t-10" href="<?=$this->pathFor('logistic-unit')?>">Batal</a>
            </div>
        </div>
            
        </form>
      </div>
    </div>
</div>
