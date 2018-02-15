<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Tambah Data Account',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Akunting',
    'submain_location' => 'Tambah Data Account'
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
        <h3 class="box-title m-b-0">Form Accounts</h3>
        <p class="text-muted m-b-30 font-13"> </p>
        <form class="form-horizontal" action="<?php echo $this->pathFor('accounting-accounts-save') ?>" method="POST">
        <input type="hidden" class="form-control" value="<?=@$account->id?>" name="id">

        <div class="col-md-6">

                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Header</span></label>
                    <div class="col-md-12">
                      <select class="form-control" name="accheaders_id">
                        <?php foreach($headers as $header){ ?>
                            <option <?=$header->id==@$account->accheaders_id?'selected="selected"':''?> 
                                value="<?=$header->id?>">
                                <?=$header->code?> | <?=$header->name?>    
                            </option>
                        <?php }?>
                      </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Kode</span></label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" value="<?=@$account->code?>" name="code">
                    </div>
                </div>

        </div>
        <div class="col-md-6">

                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Nama</span></label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" value="<?=@$account->name?>" name="name">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Tipe</span></label>
                    <div class="col-md-12">
                      <select class="form-control" name="type">
                        <option value="Debet">Debet</option>
                        <option <?=@$account->type=='Kredit'?'selected="selected"':''?> value="Kredit">Kredit</option>
                      </select>
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
