<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Penerimaan Barang',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    
  ]); 
  $receive_item = [];
  if(@$receive->details != "")
  {
    foreach($receive->details as $item){
        $receive_item[$item->barang_id] = $item;
    }
  }
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

<div class="row" id="logistic-receive-app">
    <div class="col-sm-12">
      <div class="white-box">
        <h3 class="box-title m-b-0">Form Penerimaan Barang</h3>
        <p class="text-muted m-b-20 font-13"> </p>
        <form class="form-horizontal" action="<?php echo $this->pathFor('logistic-receive-save') ?>" method="POST">
        <input type="hidden" class="form-control" value="<?=@$receive->id?>" name="id">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> No. Bukti</span></label>
                <div class="col-md-12">
                <input readonly type="text" class="form-control" value="<?=@$receive->nobukti?>" name="nobukti">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Pembelian</span></label>
                <div class="col-md-12">
                <input type="text" class="form-control" value="<?=@$purchase->nobukti?>" name="pembelian_nobukti" disabled="disabled">
                <input type="hidden" value="<?=@$purchase->id?>" name="pembelian_id">
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Gudang</span></label>
                <div class="col-md-12">
                <select class="form-control select2" name="gudang_id">
                <?php foreach($warehouses as $warehouse){ ?>
                    <option value="<?=@$warehouse->id?>" 
                    <?=(@$receive->gudang_id == $warehouse->id ? 'selected="selected"' : '') ?> 
                    ><?=@$warehouse->nama?> | <?=@$warehouse->department->name?></option>
                <?php } ?>
                </select>
                </div>
            </div>
            
        </div>
        <div class="col-sm-6">

            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Tanggal</span></label>
                <div class="col-md-12">
                <input type="text" class="form-control mydatepicker" value="<?=@$receive->tanggal == ""?date('d-m-Y'):convert_date(@$receive->tanggal)?>" name="tanggal" data-date-format="dd-mm-yyyy">
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Keterangan</span></label>
                <div class="col-md-12">
                <textarea class="form-control" rows="3" name="keterangan"><?=@$receive->keterangan?></textarea>
                </div>
            </div>
        </div>
        

        
        <div class="col-sm-12">
            <h3 class="box-title m-b-0">Barang</h3>
            <table class="table table-bordered table-striped" id="tabledetail">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th> 
                        <th>Satuan</th> 
                        <th>Pesan</th>
                        <th>Terima</th>
                        <th>Tanggal Expired</th>
                        <th>Kuantitas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(@$purchase->details != ''){
                    foreach(@$purchase->details as $detail){ ?>
                    <tr>
                        <td>
                            <?=@$detail->good->kode?>
                        </td>
                        <td>
                            <input type="hidden" name="barang_id[]" value="<?=@$detail->barang_id?>">
                            <?=@$detail->good->nama?>
                        </td>
                        <td>
                            <input type="hidden" name="satuan_id[]" value="<?=@$detail->satuan_id?>">                        
                            <?=@$detail->unit->nama?>
                        </td>
                        <td>
                            <?=@$detail->kuantitas?>
                        </td>
                        <td>
                            <?=@$receive_total[$detail->barang_id]?>
                        </td>
                        <td>
                            <?php 
                                $tgl = convert_date(@$receive_item[$detail->barang_id]->tglexpired);
                                $tgl = $tgl=="00-00-0000"?"":$tgl;
                            ?>
                            <input type="text" class="form-control mydatepicker" value="<?=$tgl?>" name="tglexpired[]" data-date-format="dd-mm-yyyy">
                        </td>
                        <td>
                            <?php 
                                $max = @$detail->kuantitas-@$receive_total[$detail->barang_id];
                                $max = @$receive->id == ""?$max: $max + @$receive_item[$detail->barang_id]->kuantitas;
                            ?>
                            <input type="number" name="kuantitas[]" value="<?=@$receive_item[$detail->barang_id]->kuantitas | 0?>" class="form-control" step="0.001" max="<?=$max?>" min="0"/>
                        </td>
                    </tr>
                    <?php } 
                    }
                    ?>
                </tbody>
            </table>

        </div>
        
        <div class="col-sm-12">           
            <div class="form-group">

                <div class="col-md-12">
                    <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Simpan</button>
                    <a class="btn btn-danger waves-effect waves-light m-t-10" href="<?=$this->pathFor('logistic-receive')?>">Batal</a>
                </div>
            </div>
        </div>
            <div class="clear"></div>
            
        </form>
      </div>
    </div>
</div>