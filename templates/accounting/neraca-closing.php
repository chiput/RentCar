<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Tutup Buku',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Akunting',
    'submain_location' => 'Tutup Buku'
  ]); 

setlocale(LC_TIME, 'id_ID');
//$month_name = date('F', mktime(0, 0, 0, $i));
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
<?php if (@$success!=""): ?>
<div class="row">
    <div class="alert alert-success alert-dismissable col-sm-12">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?=$success?>
    </div>
</div>
<?php endif; ?>


<div class="row">
    <div class="col-sm-12">
      <div class="white-box">
        <h3 class="box-title m-b-0">Tutup Buku</h3>
        <p class="text-muted m-b-30 font-13"> Data Tutup Buku </p>
        <form class="form-horizontal" action="<?php echo $this->pathFor('accounting-neraca-tutup-buku') ?>" method="POST">
        <input type="hidden" class="form-control" value="<?=@$jurnal->id?>" name="id">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Periode</span></label>
                    <div class="col-md-12">
                      <select class="form-control" name="bulan">
                        <?php 
                            $months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                            foreach($months as $month => $name){ ?>
                                <option value="<?=$month+1?>"
                                <?=date('m')==$month+1?'selected="selected"':''?>
                                ><?=$name?></option>
                            <?php } 
                        ?>
                      </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> &nbsp;</span></label>
                    <div class="col-md-12">
                      <select class="form-control" name="tahun">
                        <?php for($i=date("Y")-3;$i<=date("Y")+3;$i++){
                        echo '<option value="'.$i.'" '.($i==date("Y")?'selected="selected"':'').'>'.$i.'</option>';
                            }?>
                      </select>
                    </div>
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
        <a class="btn btn-danger waves-effect waves-light m-r-10" href="javascript:window.history.back();">Kembali</a>

        </form>
      </div>
    </div>
</div>
