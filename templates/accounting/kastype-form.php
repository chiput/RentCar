<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Tipe Transaksi',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Akunting',
    'submain_location' => 'Tipe Transaksi'
  ]); 
?>

<?php if (@$errors!=""): ?>
<div class="row">
    <div class="alert alert-danger alert-dismissable col-sm-12">
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
        <h3 class="box-title m-b-0">Form Tipe Transaksi</h3>
        <p class="text-muted m-b-30 font-13"> </p>
        <form class="form-horizontal" action="<?php echo $this->pathFor('accounting-kastype-save') ?>" method="POST">
        <input type="hidden" class="form-control" value="<?=@$kastype->id?>" name="id">

        <div class="col-md-6">

                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Nama</span></label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" value="<?=@$kastype->name?>" name="name">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Account Debet</span></label>
                    <div class="col-md-12">
                      <select class="form-control select2" name="accdebet_id">
                        <?php foreach($accounts as $account){ ?>
                            <option <?=@$kastype->accdebet_id==@$account->id?'selected="selected"':''?> 
                                value="<?=$account->id?>">
                                <?=$account->code?> | <?=$account->name?>    
                            </option>
                        <?php }?>
                      </select>
                    </div>
                </div>

        </div>
        <div class="col-md-6">

                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Account Kredit</span></label>
                    <div class="col-md-12">
                      <select class="form-control select2" name="acckredit_id">
                        <?php foreach($accounts as $account){ ?>
                            <option <?=@$kastype->acckredit_id==@$account->id?'selected="selected"':''?> 
                                value="<?=$account->id?>">
                                <?=$account->code?> | <?=$account->name?>    
                            </option>
                        <?php }?>
                      </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Tipe</span></label>
                    <div class="col-md-12">
                      <select class="form-control" name="type">
                        <option value="1">Kas</option>
                        <option value="2" <?=(@$kastype->type==2?'selected="selected"':'')?>>Bank</option>
                      </select>
                    </div>
                </div>

        </div>
                <div class="form-group m-b-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
                        <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?php echo $this->pathFor('accounting-kastype'); ?>">Batal</a>
                    </div>
                </div>    
        </form>
      </div>
    </div>
</div>
