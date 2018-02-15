<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Pembelian',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
  ]); 
?>

<div class="row">
    <?php if ($this->getSessionFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $this->getSessionFlash('success'); ?>
    </div>
    <?php endif; ?>

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
    <?php endif; 
     function convert_date($date){
            $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
            return $date;
        }
        ?>
</div>

<div class="row" id="purchase-app">
    <div class="col-sm-12">
      <div class="white-box"> 
        <h3 class="box-title m-b-0">Form Pembelian</h3>
        <p class="text-muted m-b-30"></p>
        <form class="form-horizontal" action="<?php echo $this->pathFor('daftar-pembelian-save'); ?>" method="post">
        <input type="hidden" class="form-control" value="<?=@$order->id?>" name="id">
        <div class="col-sm-6">
          <div class="form-group">
            <label class="col-md-12"><span class="help">
            Tanggal</span></label>
            <div class="col-md-12">
            <input type="text" class="form-control mydatepicker" value="<?=@$order->tanggal == ""?date('d-m-Y'):(@$order->tanggal)?>" name="tanggal" data-date-format="dd-mm-yyyy">
            </div>
          </div>
          <div class="form-group">
              <label class="col-md-12"> <span class="help"> No. Bukti</span></label>
              <div class="col-md-12">
              <input readonly type="text" class="form-control" value="<?=@$order->nobukti?>" name="nobukti">
              </div>
          </div>
          <div class="form-group">
              <label class="col-md-12"> <span class="help"> No. Permintaan</span></label>
              <div class="col-md-10">
                <input type="hidden" class="form-control" value="<?=@$order->permintaan_id?>" name="permintaan_id">
                <input type="text" class="form-control" value="<?=@$order->purchase->nobukti?>" name="permintaan_name">
              </div>
              <div class="col-md-2">
                <a href="javascript:void(0)" data-toggle="modal" data-target="#permintaanModal" class="btn btn-primary"><li class="fa fa-search"></li> Cari</a>
              </div>
          </div>
          <div class="form-group">
              <label class="col-md-12"> <span class="help"> Department</span></label>
              <div class="col-md-12">
              <input type="hidden" class="form-control" value="<?=@$order->department_id?>" name="department_id">
              <input type="text" class="form-control" value="<?=@$order->department_name?>" name="department_name" disabled>
              </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group" id="supplierInfo">
              <label class="col-md-12"> <span class="help"> Supplier</span></label>
              <div class="col-md-10">
                <input type="hidden" class="form-control" value="<?=@$order->supplier_id?>" name="supplier_id">
                <input type="text" class="form-control" value="<?=@$order->supplier_name?>"  name="supplier_name">
              </div>
              <div class="col-md-1">
                <a href="javascript:void(0)" data-toggle="modal" data-target="#supplierModal" class="btn btn-primary"><li class="fa fa-search"></li> Cari</a>
              </div>
              <div class="col-md-3">
                
              </div>
          </div>
          <div class="form-group">
              <label class="col-md-12"> <span class="help">&nbsp;</span></label>
              <div class="col-md-12">
                <label class="col-sm-1 control-label"> <span class="help"> Tunai</span></label>
                <div class="col-sm-1">
                  <input type="checkbox" id="tunai" class="form-control" name="tunai" <?=@$order->tunai != 1 ?"":"checked"?>>
                </div>
                  <label class="col-sm-2 control-label"> <span class="help"> Tempo</span></label>
                <div class="col-sm-3">
                  <input type="number" id="tempo" class="form-control" value="<?=@$order->tempo == ""?"0":$order->tempo ?>" name="tempo">
                </div>
                  <label class="col-sm-0 control-label"> <span class="help"> Hari</span></label>
              </div>
         </div>
         <div class="form-group">
              <label class="col-md-12"> <span class="help">&nbsp;</span></label>
              <div class="col-md-12">
                <div class="col-md-1">
                </div>
                  <label class="col-md-3 control-label"> <span class="help"> Jatuh Tempo</span></label>
                <div class="col-md-5">
                <?php 
                  $dated = strtotime(@$order->tanggal);
                  $dated = strtotime("+".@$order->tempo." day", $dated)?>
                  <input type="text" class="form-control mydatepicker" id="duedate" value="<?=@$order->tanggal == ""?date('d-m-Y'):date('d-m-Y', $dated)?>" data-date-format="dd-mm-yyyy">
                </div>
                <div class="col-md-3">
                
              </div>
              </div>
         </div>
         <div class="form-group">
              <label class="col-md-12"> <span class="help"> Keterangan</span></label>
              <div class="col-md-12">
              <input type="text" class="form-control" value="<?=@$order->keterangan?>" name="keterangan">
              </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <h3 class="box-title m-b-0">Barang</h3>
            <table id="tablePurchase" class="table editable-table table-bordered table-striped m-b-0">
              <thead>
                <tr>
                 <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Satuan</th>
                  <th>Minta</th>
                  <th>Order</th>
                  <th>Terima</th>
                  <th>Kuantitas</th>
                  <th>Harga</th>
                  <th>Jumlah</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  if(@$order->details != '') {
                    $total_harga = 0;
                    foreach ($order->details as $detail) {
                        $total = $detail->kuantitas*$detail->harga;
                      ?>
                      <tr class="item_barang">
                        <td><input type="hidden" name="barang_id[]" value="<?=$detail->barang_id?>"/><?=$detail->good->kode?></td>
                        <td><?=$detail->good->nama?></td>
                        <td><input type="hidden" name="satuan_id[]" value="<?=$detail->satuan_id?>" /><?=$detail->unit->nama?></td>
                        <td><?=$detail->request->sum('kuantitas')?></td>
                        <td><?=$detail->order->sum('kuantitas')?></td>
                        <td><?=@$goodterima[$detail->barang_id]->kuantitas?></td>
                        <td><input type="number" name="kuantitas[]" value="<?=$detail->kuantitas?>" class="form-control qty sub"/></td>
                        <td><input type="text" name="harga[]" value="<?=$detail->harga?>" class="form-control price sub"/></td>
                        <td><input type="text" class="total form-control" value="<?=$total?>" disabled="disabled"></td>
                      </tr>
                      <?php 
                        $total_harga += $total;
                    }
                  } else {
                ?>
                <td colspan="9" style="text-align: center">Mohon pilih <strong>No. Permintaan</strong> terlebih dahulu untuk menampilkan data.</td>
                <?php 
                  } 

                  @$subtotal = $total_harga - $order->diskon;
                  // @$subtotal = $this->convert($a);
                  @$ppn_harga = ($subtotal*($order->ppn/100));
                  // @$ppn_harga = $this->convert($b);
                  @$ppn_hasil = $subtotal + $ppn_harga;
                  // @$ppn_hasil = $this->convert($c);
                  @$total_hasil = $ppn_hasil + $order->ongkos;
                  // @$total_hasil = $this->convert($d);
                ?>
              </tbody>
            </table>            
            </div>
        </div>
        <div class="row" style="margin-top: 20px">
            <div class="col-md-4">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="col-sm-6 control-label"> <span class="help"> Diskon</span></label>
                  <div class="col-sm-6">
                    <input type="hidden" id="total" value="<?=@$total_harga?>" name="total_harga" />
                    <input type="text" class="form-control" id="diskon" value="<?=@$order->diskon == ""?"0":$order->diskon?>" name="diskon">
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label class="col-sm-6 control-label"> <span class="help"> Subtotal</span></label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="subtotal" value="<?=@$subtotal?>" name="subtotal" disabled="disabled">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="col-sm-4 control-label"> <span class="help"> PPN</span></label>
                  <div class="col-sm-3">
                    <input type="number" class="form-control" id="ppn" value="<?=@$order->ppn == ""?"0":$order->ppn?>" name="ppn">
                  </div>
                  <label class="col-sm-1 control-label"> <span class="help"> %</span></label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="ppn_hasil" name="ppn_hasil" value="<?=@$ppn_harga?>" readonly>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label class="col-sm-6 control-label"> <span class="help"> Ongkos Kirim</span></label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="ongkos_kirim" value="<?=@$order->ongkos == ""?"0":$order->ongkos?>" name="ongkos">
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label class="col-sm-6 control-label"> <span class="help"> Total</span></label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="total_harga" value="<?=@$total_hasil?>" name="total_hasil" disabled="disabled">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
            </div>
        </div>
             <div class="col-md-3">
            <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Simpan</button>
            <a class="btn btn-danger waves-effect waves-light m-t-10" href="<?=$this->pathFor('daftar-pembelian')?>">Batal</a>
        <div class="col-md-12">
          <div class="col-md-3">
          </div>
          <div class="col-md-3">
          </div>
          <div class="col-md-3">
          </div>
     
          </div>
        </div>
        <div class="form-group m-b-0">
        </div>
        </form>
      </div>
    </div>
</div>

<div id="supplierModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myModalLabel">Daftar Supplier</h4>
      </div>
      <div class="modal-body">
        <table class="table datatable myDataTable">
            <thead>
                <tr>
                    <th></th>
                    <th>Kode Supplier</th>
                    <th>Nama Supplier</th>
                    <th>Kontak Person</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($suppliers as $supplier): ?>
                <tr>
                    <td>
                        <a href="javascript:void(0)" data-supplier-json='<?=$supplier?>'  onclick="getSupplier(this)" data-toggle="tooltip" data-original-title="Pilih" data-dismiss="modal"> <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Pilih</button></a>
                    </td>
                    <td style="padding: 25px 8px;"><?=$supplier->kode?></td>
                    <td style="padding: 25px 8px;"><?=$supplier->nama?></td>
                    <td style="padding: 25px 8px;"><?=$supplier->contact?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>-->
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>   
<style type="text/css">
  .hidebro {
    display: none;
  }
</style>
<div id="permintaanModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myModalLabel">Daftar Permintaan</h4>
      </div>
      <div class="modal-body">
        <table class="table datatable myDataTable">
            <thead>
                <tr>
                    <th>Aksi</th>
                    <th>Tanggal</th>
                    <th>No Bukti</th>
                    <th>Departemen</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($purchases as $purchase): 
                  if($purchase->po->status == 1){
                ?>
                <tr>
                    <td>
                        <a href="javascript:void(0)" data-purchase-json='<?=$purchase->po?>' data-department-json='<?=$purchase->po->department?>' data-podetail-json='<?=$purchase->po->details?>'' data-units-json='<?=$units?>' onclick="getPurchase(this)" data-toggle="tooltip" data-original-title="Pilih" data-dismiss="modal"><button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Pilih</button></a>
                    </td>
                    <td style="padding: 25px 8px;"><?=convert_date(@$purchase->tanggal)?></td>
                    <td style="padding: 25px 8px;"><?=@$purchase->po->nobukti?></td>
                    <td style="padding: 25px 8px;"><?=@$purchase->po->department->name?></td>
                </tr>
                <?php } endforeach; ?>
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>-->
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div> 
<input type="hidden" id="listGoods" value='<?=@$goods?>' />
<input type="hidden" id="listUnits" value='<?=@$units?>' />
<input type="hidden" id="listOrderDetails" value='<?=@$orderdetails?>' />
<input type="hidden" id="listTerimaDetails" value='<?=@$terimadetails?>' />
<script type="text/javascript">
  $(document).ready(function(){
    var format = new curFormatter();
    format.input("[name='subtotal']");
    format.input("[name='total_hasil']");
    format.input("[name='ppn_hasil']");
    format.input("[name='ongkos']");
    format.input("[name='diskon']");
    format.input("[name='harga[]']");
    format.input(".total");
  });
</script>