<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Tambah Aktiva',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Akunting',
    'submain_location' => 'Tambah Aktiva'
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
<?php endif; 

function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }

?>

<div class="row">
    <div class="col-sm-12">
      <div class="white-box">
        <h3 class="box-title m-b-0">Form Aktiva</h3>
        <p class="text-muted m-b-20 font-13"> </p>
        <form class="form-horizontal" action="<?php echo $this->pathFor('accounting-aktiva-save') ?>" method="POST">
        <input type="hidden" class="form-control" value="<?=@$aktiva->id?>" name="id">
        <input type="hidden" class="form-control" value="<?=@$aktiva->accjurnals_id?>" name="accjurnals_id">
        
        <div class="col-md-6">
            
                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Tanggal</span></label>
                    <div class="col-md-12">
                    <input type="text" class="form-control mydatepicker" data-date-format="dd-mm-yyyy" value="<?=convert_date(@$aktiva->tanggal)?>" name="tanggal">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Nama</span></label>
                    <div class="col-md-12">
                    <input type="text" class="form-control" value="<?=@$aktiva->nama?>" name="nama">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Harga Beli</span></label>
                    <div class="col-md-12">
                    <input type="text" class="form-control" value="<?= $this->convert(@$aktiva->harga)?>" id="hargabeli" name="harga">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Nilai Residu</span></label>
                    <div class="col-md-12">
                    <input type="text" class="form-control" value="<?= $this->convert(@$aktiva->residu)?>" id="nilairesidu" name="residu">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Umur Aktiva (Dalam tahun)</span></label>
                    <div class="col-md-12">
                    <input type="text" class="form-control" value="<?=@$aktiva->umur?>" name="umur">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Metode</span></label>
                    <div class="col-md-12">
                    <input type="text" readonly="readonly" class="form-control" value="Garis Lurus" name="metode">
                    </div>
                </div>

        </div>
        <div class="col-md-6">

                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Kelompok</span></label>
                    <div class="col-md-12">
                    <select class="form-control select2" name="accaktivagroups_id">
                            <option value="0"> -- Pilih Kelompok -- </option>
                        <?php foreach($accaktivagroups as $aktivagrup){ ?>
                            <option <?=$aktivagrup->id==@$aktiva->accaktivagroups_id?'selected="selected"':''?> 
                                value="<?=$aktivagrup->id?>">
                                <?=$aktivagrup->nama?>    
                            </option>
                        <?php }?>
                    </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Account Aktiva</span></label>
                    <div class="col-md-12">
                    <select class="form-control select2" name="accaktiva_id">
                            <option value="0"> -- Pilih Account -- </option>
                        <?php foreach($accounts as $account){ ?>
                            <option <?=$account->id==@$aktiva->accaktiva_id?'selected="selected"':''?> 
                                value="<?=$account->id?>">
                                <?=$account->code?> | <?=$account->name?>
                            </option>
                        <?php }?>
                    </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Account Kas</span></label>
                    <div class="col-md-12">
                    <select class="form-control select2" name="acckas_id">
                            <option value="0"> -- Pilih Account -- </option>
                        <?php foreach($accounts as $account){ ?>
                            <option <?=$account->id==@$aktiva->acckas_id?'selected="selected"':''?> 
                                value="<?=$account->id?>">
                                <?=$account->code?> | <?=$account->name?>
                            </option>
                        <?php }?>
                    </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Account Akumulasi</span></label>
                    <div class="col-md-12">
                    <select class="form-control select2" name="accakumulasi_id">
                            <option value="0"> -- Pilih Account -- </option>
                        <?php foreach($accounts as $account){ ?>
                            <option <?=$account->id==@$aktiva->accakumulasi_id?'selected="selected"':''?> 
                                value="<?=$account->id?>">
                                <?=$account->code?> | <?=$account->name?>
                            </option>
                        <?php }?>
                    </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Account Penyusutan</span></label>
                    <div class="col-md-12">
                    <select class="form-control select2" name="accpenyusutan_id">
                            <option value="0"> -- Pilih Account -- </option>
                        <?php foreach($accounts as $account){ ?>
                            <option <?=$account->id==@$aktiva->accpenyusutan_id?'selected="selected"':''?> 
                                value="<?=$account->id?>">
                                <?=$account->code?> | <?=$account->name?>
                            </option>
                        <?php }?>
                    </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Kondisi</span></label>
                    <div class="col-md-12">
                    <select class="form-control" name="kondisi">
                        <option value="BAIK">Baik</option>
                        <option value="RUSAK" <?=@$aktiva->kondisi=="RUSAK"?'selected="selected"':''?> >Rusak</option>
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
<script type="text/javascript">
    $(document).ready(function(){
        var format = new curFormatter();
        format.input('#hargabeli');
        format.input('#nilairesidu');
    });
</script>