<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Konversi',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
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
        <h3 class="box-title m-b-0">Form Konversi Satuan</h3>
        <p class="text-muted m-b-20 font-13"> </p>
        <form class="form-horizontal" action="<?php echo $this->pathFor('logistic-conversion-save') ?>" method="POST">
        <input type="hidden" class="form-control" value="<?=@$conversion->id?>" name="id">

        <div class="form-group col-md-4">
            <label class="col-md-12"> <span class="help"> Satuan 1</span></label>
            <div class="col-md-12">
                <select class="form-control select2" name="brgsatuan_id1">
                <?php foreach($units as $unit){ ?>
                    <option value="<?=@$unit->id?>" 
                    <?=(@$conversion->brgsatuan_id1 == $unit->id ? 'selected="selected"' : '') ?> 
                    ><?=@$unit->nama?></option>
                <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group col-md-4">
                <label class="col-md-12"> <span class="help"> Nilai Satuan <small>(Satuan 1 = nilai x Satuan 2)</small></span></label>
                <div class="col-md-12">
                <input type="text" class="form-control" value="<?=@$conversion->nilai?>" name="nilai">
                </div>
        </div>
        <div class="form-group col-md-4">
            <label class="col-md-12"> <span class="help"> Satuan 2</span></label>
            <div class="col-md-12">
                <select class="form-control select2" name="brgsatuan_id2">
                <?php foreach($units as $unit){ ?>
                    <option value="<?=@$unit->id?>" 
                    <?=(@$conversion->brgsatuan_id2 == $unit->id ? 'selected="selected"' : '') ?> 
                    ><?=@$unit->nama?></option>
                <?php } ?>
                </select>
            </div>
        </div>
        
        <div class="form-group m-b-0">
            <div class="col-md-12">
                <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Simpan</button>
                <a class="btn btn-danger waves-effect waves-light m-t-10" href="<?=$this->pathFor('logistic-conversion')?>">Batal</a>
            </div>
        </div>
            
        </form>
      </div>
    </div>
</div>
