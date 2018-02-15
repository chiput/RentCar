<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Tambah Data Header Account',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Akunting',
    'submain_location' => 'Form Data Header Account'
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
        <h3 class="box-title m-b-0">Form Headers</h3>
        <p class="text-muted m-b-30 font-13"> </p>
        <form class="form-horizontal" action="<?php echo $this->pathFor('accounting-headers-save') ?>" method="POST">
        <input type="hidden" class="form-control" value="<?=@$header->id?>" name="id">

        <div class="col-md-6">

                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Group</span></label>
                    <div class="col-md-12">
                      <select class="form-control" name="accgroups_id">
                        <?php foreach($groups as $group){ ?>
                            <option <?=$group->id==@$header->accgroups_id?'selected="selected"':''?> 
                                value="<?=$group->id?>"> <?=$group->name?>    
                            </option>
                        <?php }?>
                      </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Kode</span></label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" value="<?=@$header->code?>" name="code">
                    </div>
                </div>

        </div>
        <div class="col-md-6">

                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Nama</span></label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" value="<?=@$header->name?>" name="name">
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Keterangan</span></label>
                    <div class="col-md-12">
                      <textarea class="form-control" rows="3" value="<?=@$header->remark?>" name="remark"></textarea>
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