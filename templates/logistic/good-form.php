<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Data Barang',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    
  ]); 
  //echo($units);
?>


<?php if (@$errors!=""): ?>
<div class="row">
    <div class="alert alert-danger alert-dismissable">
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
        <h3 class="box-title m-b-0">Form Barang</h3>
        <p class="text-muted m-b-20 font-13"> </p>
        <form class="form-horizontal" action="<?php echo $this->pathFor('logistic-good-save') ?>" method="POST">
        <input type="hidden" class="form-control" value="<?=@$good->id?>" name="id">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Kode</span></label>
                <div class="col-md-12">
                <input type="text" class="form-control" value="<?=@$good->kode?>" name="kode">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Nama</span></label>
                <div class="col-md-12">
                <input type="text" class="form-control" value="<?=@$good->nama?>" name="nama">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Satuan</span></label>
                <div class="col-md-12">
                <select class="form-control select2" name="brgsatuan_id">
                <?php foreach($units as $unit){ ?>
                    <option value="<?=@$unit->id?>" 
                    <?=(@$good->brgsatuan_id == $unit->id ? 'selected="selected"' : '') ?> 
                    ><?=@$unit->nama?></option>
                <?php } ?>
                </select>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox checkbox-success">
                    <input id="expired" type="checkbox" value="1" name="expired" <?=@$good->expired==1?'checked="checked"':''?>>
                    <label for="expired"> Expired </label>
                </div>
            </div>
            <div class="form-group hidden">
                <label class="col-md-12"> <span class="help"> Account</span></label>
                <div class="col-md-12">
                <select class="form-control select2" name="account_id">
                <?php foreach($accounts as $account){ ?>
                    <option value="<?=@$account->id?>" 
                    <?=(@$good->account_id == $account->id ? 'selected="selected"' : '') ?> 
                    ><?=@$account->code?> || <?=@$account->name?></option>
                <?php } ?>
                </select>
                </div>
            </div>
            
            
            <div class="form-group hidden">
                <label class="col-md-12"> <span class="help"> Account Penjualan</span></label>
                <div class="col-md-12">
                <select class="form-control select2" name="accpenjualan">
                <?php foreach($accounts as $account){ ?>
                    <option value="<?=@$account->id?>" 
                    <?=(@$good->accpenjualan == $account->id ? 'selected="selected"' : '') ?> 
                    ><?=@$account->code?> || <?=@$account->name?></option>
                <?php } ?>
                </select>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            
            <div class="form-group hidden">
                <label class="col-md-12"> <span class="help"> Account HPP</span></label>
                <div class="col-md-12">
                <select class="form-control select2" name="acchpp">
                <?php foreach($accounts as $account){ ?>
                    <option value="<?=@$account->id?>" 
                    <?=(@$good->acchpp == $account->id ? 'selected="selected"' : '') ?> 
                    ><?=@$account->code?> || <?=@$account->name?></option>
                <?php } ?>
                </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Stok Minimal</span></label>
                <div class="col-md-12">
                <input type="number" class="form-control" value="<?=@$good->minimal?>" name="minimal">
                </div>
            </div>

            <div class="form-group hidden">
                <label class="col-md-12"> <span class="help"> Harga Jual</span></label>
                <div class="col-md-12">
                <input type="text" class="form-control" value="1" name="hargajual">
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Harga Awal</span></label>
                <div class="col-md-12">
                <input type="text" class="form-control" id="hargastok" value="<?=@$good->hargastok?>" name="hargastok">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Kategori</span></label>
                <div class="col-md-12">
                <select class="form-control select2" name="brgkategori_id">
                <?php foreach($categories as $cat){ ?>
                    <option value="<?=@$cat->id?>" 
                    <?=(@$good->brgkategori_id == $cat->id ? 'selected="selected"' : '') ?> 
                    ><?=@$cat->nama?></option>
                <?php } ?>
                </select>
                </div>
            </div>
            <div class="form-group hidden">
                <div class="checkbox checkbox-success">
                    <input id="inventaris" type="checkbox" value="1" name="inventaris" <?=@$good->inventaris==1?'checked="checked"':''?>>
                    <label for="inventaris"> Inventaris </label>
                </div>
            </div>
            
        </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Simpan</button>
                    <a class="btn btn-danger waves-effect waves-light m-t-10" href="<?=$this->pathFor('logistic-good')?>">Batal</a>
                </div>
        <div class="form-group m-b-0">            
        </div>         
        </form>
      </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    var format = new curFormatter();
    format.input('#hargastok');
    });
</script>
