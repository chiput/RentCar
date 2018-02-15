<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Kartu Kredit',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Akunting',
    'submain_location' => 'Kartu Kredit'
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
        <h3 class="box-title m-b-0">Form Kartu Kredit</h3>
        <p class="text-muted m-b-20 font-13"> </p>
        <form class="form-horizontal" action="<?php echo $this->pathFor('accounting-creditcard-save') ?>" method="POST">
        <input type="hidden" class="form-control" value="<?=@$creditcards->id?>" name="id">

        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Nama</span></label>
                <div class="col-md-12">
                  <input type="text" class="form-control" value="<?=@$creditcards->name?>" name="name">
                </div>
            </div>
        </div>

        <!-- <div class="form-group">
            <label class="col-md-12"> <span class="help"> Bank</span></label>
            <div class="col-md-12">
              <select class="form-control select2" name="banks_id">
                <?php foreach($banks as $bank){ ?>
                    <option <?=@$bank->id==@$creditcard->banks_id?'selected="selected"':''?> 
                        value="<?=$bank->id?>">
                        <?=$bank->name?>    
                    </option>
                <?php }?>
              </select>
            </div>
        </div> -->

        <div class="form-group hidden">
            <label class="col-md-12"> <span class="help">Biaya</span></label>
            <div class="col-md-12">
              <input type="text" class="form-control" value="<?=@$creditcard->biaya|0?>" name="biaya">
            </div>
        </div>

       <div class="form-group m-b-0">
            <div class="col-md-12">
                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
                <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('accounting-creditcard')?>">Batal</a>
            </div>
        </div>        
            
        </form>
      </div>
    </div>
</div>
