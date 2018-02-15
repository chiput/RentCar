<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Kelompok Aktiva',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Akunting',
    'submain_location' => 'Tambah Aktiva'
  ]); 
?>

<?php if ($this->getSessionFlash('success')): ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('success'); ?>
</div>
<?php endif; ?>
<?php if ($this->getSessionFlash('error')): ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $this->getSessionFlash('error'); ?>
        </div>
<?php endif; ?>


<div class="row">
    <div class="col-sm-12">
      <div class="white-box">
        <h3 class="box-title m-b-0">Form Kelompok Aktiva</h3>
        <p class="text-muted m-b-20 font-13"> </p>
        <form class="form-horizontal" action="<?php echo $this->pathFor('accounting-aktiva-group-save') ?>" method="POST">
        <input type="hidden" class="form-control" value="<?=@$group->id?>" name="id">

        <div class="col-md-6">
        <div class="form-group">
            <label class="col-md-12"> <span class="help"> Nama</span></label>
            <div class="col-md-12">
              <input type="text" class="form-control" value="<?=@$group->nama?>" name="nama">
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
<script type="text/javascript">
    //$(document).ready(function(){
        
    //});
</script>