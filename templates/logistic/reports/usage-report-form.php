<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Laporan Pemakaian Barang',
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
            <h3 class="box-title m-b-0">Laporan Pemakaian Barang</h3>
            <p class="text-muted m-b-20 font-13"> </p>           
            <form class="form-horizontal" method="POST" target="_blank">
                <div class="row">
                    <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Tanggal Laporan</span></label>
                        <div class="col-md-12">
                            <div class="input-daterange input-group" id="date-range" data-date-format="dd-mm-yyyy">

                                    <input  type="text" class="form-control" name="d_start" value="<?="01".date("-m-Y")?>" >
                                <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                                    <input type="text" class="form-control" name="d_end"
                                    value="<?=date("t-m-Y")?>">
                            </div>
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