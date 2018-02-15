<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Revisi Stok Barang',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    
  ]); 
  //echo($revision->details);
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

<div class="row" id="logistic-revision-app">
    <div class="col-sm-12">
      <div class="white-box">
        <h3 class="box-title m-b-0">Form Revisi Stok Barang</h3>
        <p class="text-muted m-b-20 font-13"> </p>
        <form class="form-horizontal" action="<?php echo $this->pathFor('logistic-revision-save') ?>" method="POST">
        <input type="hidden" class="form-control" value="<?=@$revision->id?>" name="id">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> No. Bukti</span></label>
                <div class="col-md-12">
                <input readonly type="text" class="form-control" value="<?=@$revision->nobukti?>" name="nobukti">
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Gudang</span></label>
                <div class="col-md-12">
                <select class="form-control" name="gudang_id" readonly="readonly">
                <?php foreach($warehouses as $warehouse){ 
                    if(@$revision->gudang_id == $warehouse->id ){
                    ?>
                    <option value="<?=@$warehouse->id?>" 
                    <?=(@$revision->gudang_id == $warehouse->id ? 'selected="selected"' : '') ?> 
                    ><?=@$warehouse->nama?> | <?=@$warehouse->department->name?></option>
                <?php } } ?>
                </select>
                </div>
            </div>
            
        </div>
        <div class="col-sm-6">

            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Tanggal</span></label>
                <div class="col-md-12">
                <input type="text" class="form-control mydatepicker" value="<?=@$revision->tanggal == ""?date('d-m-Y'): convert_date(@$revision->tanggal)?>" name="tanggal" data-date-format="dd-mm-yyyy" readonly="readonly">
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Keterangan</span></label>
                <div class="col-md-12">
                <textarea class="form-control" name="keterangan"><?=@$revision->keterangan?></textarea>
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
                        <th>Pengurangan / Penambahan</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(@$revision->details != ''){
                    foreach(@$revision->details as $detail){ ?>
                    <tr>
                        <td>
                            <a href="#" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>
                        </td>
                        <td>
                            <input type="hidden" name="barang_id[]" value="<?=$detail->barang_id?>">
                            <?=$detail->good->nama?>
                        </td>
                        <td>
                            <input name="satuan_id[]" value="<?=$detail->satuan_id?>" type="hidden"/>
                            <?=$detail->good->unit->nama?>
                        </td>
                        <td>
                            <input type="number" name="kuantitas[]" value="<?=$detail->kuantitas?>" class="form-control"  step="0.001"/>
                        </td>
                        <td>
                            <input type="text" name="harga[]" value="<?=$this->convert($detail->harga)?>" class="form-control hidden"/>
                            <?=$this->convert($detail->harga)?>
                        </td>
                    </tr>
                    <?php } 
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#goods-modal" data-original-title="Tambah"> <i class="fa fa-plus-circle"></i> </a>
                        </td>
                    </tr>
                </tfoot>
            </table>

            <small>Isi kolom stok untuk menambah stok barang, gunakan tanda (-) untuk mengurangi stok barang.</small>

            <div class="form-group">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Simpan</button>
                    <a class="btn btn-danger waves-effect waves-light m-t-10" href="<?=$this->pathFor('logistic-revision')?>">Batal</a>
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
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data as $good){ ?>
                        <tr>
                            <td><a href="javascript:void(0)" 
                            data-id="<?=$good->id?>" 
                            data-harga="<?=$this->convert($good->hargastok)?>" 
                            data-unitid="<?=$good->brgsatuan_id?>" 
                            data-unitname="<?=$good->satuan?>" 
                            data-dismiss="modal"><?=$good->nama?></a></td>
                            <td><?=$good->satuan?></td>
                            <td><?=$this->convert($good->hargastok)?></td>
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
    <!-- /.modal-dialog -->
<script type="text/javascript">
 

</script>