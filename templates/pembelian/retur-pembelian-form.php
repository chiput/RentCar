<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Retur Pembelian',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    
  ]); 

?>


<?php if ($this->getSessionFlash('error_messages')): ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
         <ul>
          <?php
            foreach($this->getSessionFlash('error_messages') as $key => $error) {
            ?>
            <li><?php echo $error; ?></li>
            <?php
            }
          ?>
          </ul>
    </div>
    <?php endif; ?>

    <?php
     function convert_date($date){
            $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
            return $date;
        }
    ?>

<div class="row" id="retur-order-app">
    <div class="col-sm-12">
      <div class="white-box">
        <h3 class="box-title m-b-0">Retur Pembelian</h3>
        <p class="text-muted m-b-30"> </p>
        <form class="form-horizontal" action="<?php echo $this->pathFor('retur-pembelian-save') ?>" method="POST">
        <input type="hidden" class="form-control" value="<?=@$retur->id?>" name="id">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Tanggal</span></label>
                <div class="col-md-12">
                <input type="text" class="form-control mydatepicker" value="<?=@$retur->tanggal == ""? date('d-m-Y'):convert_date(@$retur->tanggal)?>" name="tanggal" data-date-format="dd-mm-yyyy">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> No. Bukti</span></label>
                <div class="col-md-12">
                <input readonly type="text" class="form-control" value="<?=@$retur->nobukti?>" name="nobukti">
                </div>
            </div>
            <div class="form-group">
              <label class="col-md-12"> <span class="help"> No. Terima</span></label>
              <div class="col-md-10">
                <input type="hidden" class="form-control" id="terima_id" value="<?=@$retur->terima_id?>" name="terima_id">
                <input type="text" class="form-control" id="terima_name" value="<?=@$retur->receive->nobukti?>" name="terima_name">
              </div>
              <div class="col-md-1">
                <a href="javascript:void(0)" data-toggle="modal" data-target="#terimaModal" class="btn btn-primary"><li class="fa fa-search"></li> Cari</a>
              </div>
            </div>
        </div>
        <div class="col-sm-6">
             <div class="form-group">
                <label class="col-md-12"> <span class="help"> No. Pembelian</span></label>
                <div class="col-md-12">
                <input type="text" class="form-control" value="<?=@$purchase->nobukti?>" name="pembelian_nobukti" disabled="disabled">
                <input type="hidden" value="<?=@$purchase->id?>" name="pembelian_id">
                </div>
            </div>
                <div class="form-group">
                <label class="col-md-12"> <span class="help"> Keterangan</span></label>
                <div class="col-md-12">
                <input type="text" class="form-control" value="<?=@$retur->keterangan?>" name="keterangan">
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <h3 class="box-title m-b-0">Barang</h3>
            <table id="tabledetail" class="table table-bordered table-striped m-b-0">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th> 
                        <th>Satuan</th>
                        <th>Terima</th>
                        <!-- th>Retur</th> -->
                        <th>Kuantitas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(@$retur->details != ''){
                    $total = 0;
                    foreach(@$retur->details as $detail){ ?>
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
                            <?=@$receive_total[$detail->barang_id]?>
                        </td>
<!--                         <td>
                            <?=@$retur_total[$detail->barang_id]?>
                        </td> -->
                        <td>
                            <input type="number" name="kuantitas[]" value="<?=@$detail->kuantitas?>" class="form-control total" step="0.001" max="" min="0"/>
                            <input type="hidden" name="harga[]" value="<?=@$detail->harga?>">
                        </td>
                    </tr>
                    <?php 
                            @$total += $detail->kuantitas;

                        } 
                    } else {
                    ?>
                    <td colspan="9" style="text-align: center">Mohon pilih <strong>No. Terima</strong> terlebih dahulu untuk menampilkan data.</td>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

        </div>
        <div class="col-sm-12">
            <div class="col-sm-4">
                <div class="form-group">
                  <br/>
                  <label class="col-sm-12"> <span class="help"> Total</span></label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" id="total" value="<?=@$total?>" name="total" disabled="disabled">
                  </div>
                </div>
            </div>
            <div class="col-sm-2">
            </div>
            <div class="col-sm-6">
            </div>
        </div>
        <div class="col-sm-2">
        <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Simpan</button>
                        <a class="btn btn-danger waves-effect waves-light m-t-10" href="<?=$this->pathFor('retur-pembelian')?>">Batal</a>
             </div>           
        <div class="row">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="col-md-12">
                        
                    </div>
                </div>
            </div>
        </div>
        </form>
      </div>
    </div>
</div>

<div id="terimaModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myModalLabel">Daftar Terima Barang</h4>
      </div>
      <div class="modal-body">
        <table class="table datatable myDataTable">
            <thead>
                <tr>
                    <th>Aksi</th>
                    <th>Tanggal</th>
                    <th>No. Bukti</th>
                    <th>No. Pembelian</th>
                    <th>Supplier</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                foreach ($receives as $receive): ?>
                <tr>
                    <td>
                        <a href="javascript:void(0)" data-receive-json='<?=$receive?>' data-redetail-json='<?=$receive->details?>'  onclick="getReceive(this)" data-toggle="tooltip" data-original-title="Pilih" data-dismiss="modal"><button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Pilih</button></a>
                    </td>
                    <td><?=convert_date(@$receive->tanggal);?></td>
                    <td><?=@$receive->nobukti?></td>
                    <td><?=@$receive->purchase->nobukti?></td>
                    <td><?=@$receive->purchase->supplier->nama?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div> 
<input type="hidden" id="listGoods" value='<?=@$goods?>' />
<input type="hidden" id="listUnits" value='<?=@$units?>' />
<input type="hidden" id="listPurchases" value='<?=@$purchase->details?>' />
<input type="hidden" id="listReturs" value='<?=@$retur->details?>' />
<script type="text/javascript">
    var format = new curFormatter();
    format.input("[name='total']");
</script>
