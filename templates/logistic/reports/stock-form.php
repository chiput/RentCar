<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Laporan Stok',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
  ]);
?>

<?php if ($this->getSessionFlash('success')): ?>
<div class="row">
    <div class="alert alert-success alert-dismissable col-sm-12">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $this->getSessionFlash('success'); ?>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Laporan Stok</h3>
            <p class="text-muted m-b-20 font-13"> </p>         
            <form class="form-horizontal" method="POST" target="_blank">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Periode Laporan</span></label>
                            <div class="col-md-6">
                                <select class="form-control select2" name="month">
                                <?php 
                                $months = ['januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember'];
                                foreach($months as $month => $name){ ?>
                                    <option value="<?=$month+1?>"
                                    <?=date('m')==$month+1?'selected="selected"':''?>
                                    ><?=$name?></option>
                                <?php } 
                                ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control select2" name="year">
                                <?php 
                                
                                for($year = 2014; $year <= date('Y')+2; $year++){ ?>
                                    <option value="<?=$year?>" 
                                    <?=date('Y')==$year?'selected="selected"':''?>
                                    ><?=$year?></option>
                                <?php } 
                                ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Gudang </span></label>
                            <div class="col-md-12">
                                <select class="form-control select2" name="gudang_id">
                                    <option value="0"> - Semua Gudang - </option>
                                <?php foreach($warehouses as $warehouse){ ?>
                                    <option value="<?=$warehouse->id?>"><?=$warehouse->nama?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Stok </span></label>
                            <div class="col-md-12">
                                <select class="form-control select2" name="stok">
                                    <option value="2"> > 0 </option>
                                    <option value="1"> <= Minimal </option>
                                    <option value="0"> 0 </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Kategori </span></label>
                            <div class="col-md-12">
                                <select class="form-control select2" name="kategori_id">
                                    <option value="0"> - Semua Kategori - </option>
                                <?php foreach($categories as $cat){ ?>
                                    <option value="<?=$cat->id?>"><?=$cat->nama?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Barang </span></label>
                            <div class="col-md-12">
                                <select class="form-control select2" name="barang_id">
                                    <option value="0"> - Semua Barang - </option>
                                <?php foreach($goods as $good){ ?>
                                    <option value="<?=$good->id?>"><?=$good->nama?></option>
                                <?php } ?>
                                </select>
                            </div>
                            </div>        
                        </div>   
                    </div>

                    <div class="form-group m-b-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Tampilkan</button>
                        </div>
                    </div>
                
                </div>
            </form>
        </div>
        
    </div>
</div>