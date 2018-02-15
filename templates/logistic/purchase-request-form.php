<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Permintaan Barang',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    
  ]); 
  //echo($purReq->details);
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
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$vad = explode('/', $actual_link);
?>

<?php if ($this->getSessionFlash('success')): ?>
<div class="row">
    <div class="alert alert-success alert-dismissable col-sm-12">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $this->getSessionFlash('success'); ?>
    </div>
</div>
<?php endif; ?>
<div class="row" id="logistic-purchase-request-app">
    <div class="col-sm-12">
      <div class="white-box">
        <h3 class="box-title m-b-0">Form Permintaan Barang</h3>
        <p class="text-muted m-b-20 font-13"> </p>
        <form class="form-horizontal" action="<?php echo $this->pathFor('logistic-purchase-request-save') ?>" method="POST">
        <input type="hidden" class="form-control" value="<?=@$purReq->id?>" name="id">
        <input type="hidden" name="vad" value="<?= $vad[5]?>">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> No. Bukti</span></label>
                <div class="col-md-12">
                <input readonly type="text" class="form-control" value="<?=@$purReq->nobukti?>" name="nobukti">
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Departemen</span></label>
                <div class="col-md-12">
                <select class="form-control select2" name="department_id">
                <?php foreach($departments as $department){ ?>
                    <option value="<?=@$department->id?>" 
                    <?=(@$purReq->department_id == $department->id ? 'selected="selected"' : '') ?> 
                    ><?=@$department->name?></option>
                <?php } ?>
                </select>
                </div>
            </div>
            
        </div>
        <div class="col-sm-6">

            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Tanggal</span></label>
                <div class="col-md-12">
                <input type="text" class="form-control mydatepicker" value="<?=@$purReq->tanggal == ""?date('d-m-Y'):convert_date(@$purReq->tanggal)?>" name="tanggal" data-date-format="dd-mm-yyyy">
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Keterangan</span></label>
                <div class="col-md-12">
                <textarea class="form-control" rows="3" name="keterangan"><?=@$purReq->keterangan?></textarea>
                </div>
            </div>
            
            
        </div>
        

        
        <div class="col-sm-12">
            <h3 class="box-title m-b-0">Barang</h3>
            <table class="table table-bordered table-striped" id="tabledetail">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nama</th>
                        <th>Satuan</th>
                        <th>Kuantitas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(@$purReq->details != ''){
                    foreach(@$purReq->details as $detail){ ?>
                    <tr>
                        <td>
                            <a href="#" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>
                        </td>
                        <td>
                            <input type="hidden" name="barang_id[]" value="<?=$detail->barang_id?>">
                            <?=$detail->good->nama?>
                        </td>
                        <td>
                            <select name="satuan_id[]" class="form-control">
                                <?php foreach($units as $unit){ ?>
                                <option value="<?=$unit->id?>" 
                                <?=$unit->id == $detail->satuan_id?'selected="selected"':''?>
                                ><?=$unit->nama?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <input type="number" name="kuantitas[]" value="<?=$detail->kuantitas?>" class="form-control"/>
                        </td>
                    </tr>
                    <?php } 
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#goods-modal" data-original-title="Tambah"> <i class="fa fa-plus-circle"></i> </a>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <div class="form-group">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Simpan</button>
                    <a class="btn btn-danger waves-effect waves-light m-t-10" href="<?=$this->pathFor('logistic-purchase-request')?>">Batal</a>
                </div>
            </div>
        </div>
        
                    
        <div class="form-group m-b-0">
            
        </div>
            
        </form>
      </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;" id="goods-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="">Daftar Barang</h4>
            </div>
            <div class="modal-body">
                <table class="table myDataTable">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($goods as $good){ ?>
                        <tr>
                            <td><a href="javascript:void(0)" data-id="<?=$good->id?>" data-satuan="<?=$good->unit->id?>" data-dismiss="modal"><?=$good->nama?></a></td>
                            <td><?=$good->unit->nama?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
            </div> -->
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<input type="hidden" id="listUnits" value='<?=$units?>'/>
<input type="hidden" id="konversi" value='<?=$konversi?>'/>
    <!-- /.modal-dialog -->
<script type="text/javascript">
 

</script>