<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Kasir Laundry',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    //'main_location' => 'Akunting',
    //'submain_location' => 'Tambah Data Header Account'
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

<form class="form-horizontal" action="<?php echo $this->pathFor('housekeeping-laundry-kasirsave'); ?>" method="post">
<div class="row">
<div class="white-box">
<div class="modal-dialog modal-lg" id="laundry">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Kasir</h4>
    </div>
    <div class="modal-body">
          <tbody>
            <td>
              <div class="form-group">
                  <?php $totalan=0; foreach($menus->detail as $total):
                    $harga = $total->harga-$total->diskon;
                    $jumlah = $total->kuantitas*$harga;
                    $totalan += $jumlah;
                    endforeach; ?>
                  <div><input type="text" class="form-control" style="height:65px; font-size:25px; text-align:right;" rows="3" name="totalkasir" value="<?php echo @$totalan; ?>" onkeyup="totalankasir(this.id)"></input></div>
                  <div><input type="hidden" class="form-control" style="height:65px; font-size:25px; text-align:right;" rows="3" id="totals" value="<?php echo @$totalan;?>" onkeyup="totalankasir(this.id)"></input></div>
              </div>
            </td>
            <td>
              <table class="table" id="tabledetail">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Kode</th>
                          <th>Nama</th>
                          <th>Kuantitas</th>
                          <th>Harga</th>
                          <th>Diskon</th>
                          <th>Jumlah</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                      if(@$menus->detail != ''){
                      $i=0; $total1=0;
                      foreach(@$menus->detail as $no => $detail){
                        $harga = $detail->harga-$detail->diskon;
                        $jumlah = $detail->kuantitas*$harga?>
                      <tr>
                          <td><?php echo $no + 1;  ?></td>
                          <td>
                            <input type="hidden" class="form-control" value="" readonly>
                            <?php echo @$detail->tarif->kode?>
                          </td>
                          <td>
                            <input type="text" class="form-control" value="<?php echo @$detail->tarif->nama?>" readonly>
                          </td>
                          <td>
                            <input type="text" class="form-control" value="<?php echo @$detail->kuantitas?>" readonly>
                          </td>
                          <td>
                            <input type="text" class="form-control" value="<?php echo @$detail->harga?>" readonly>
                          </td>
                          <td>
                            <input type="text" class="form-control" value="<?php echo @$detail->diskon?>" readonly>
                          </td>
                          <td>
                            <input type="text" class="form-control" value="<?php echo @$jumlah?>" readonly>
                          </td>
                      </tr>
                      <?php $i++; } } ?>
                  </tbody>
              </table>
            </td>
            <td>
              <div class="form-group">
                <label class="col-md-2"><span class="help"> Tanggal</span></label>
                <div class="col-md-3"><input type="text" name="tanggalkasir" class="form-control mydatepicker" data-date-format="yyyy-mm-dd" value="<?php echo substr((@$menu->tanggal==''?date('Y-m-d'):@$menu->tanggal),0,10) ?>" onkeyup="cetakkasir();"></div>
                <label class="col-md-2"><span class="help">Diskon (%)</span></label>
                <div class="col-md-3"><input type="text" id="diskonpersen" name="diskonpersen" class="form-control" rows="3" value="<?php if(@$menus->kasir->diskon==''){ echo 0; }else{ echo $menus->kasir->diskon;} ?>" onkeyup="totalankasir(this.id); cetakkasir();"></input></div>
              </div>
            </td>
            <td>
              <div class="form-group">
                <label class="col-md-2"><span class="help">Kamar</span></label>
                <div class="col-md-3"><input type="text" class="form-control" rows="3" value="<?php echo @$menus->room->room->number; ?>" readonly></input></div>
                <label class="col-md-2"><span class="help">Service (%)</span></label>
                <div class="col-md-3"><input type="text" id="service" name="service" class="form-control" rows="3" value="<?php if(@$menus->kasir->service=='') echo 0; else echo $menus->kasir->service; ?>" onkeyup="totalankasir(this.id)"></input></div>
              </div>
            </td>
            <td>
              <div class="form-group">
                <label class="col-md-2"><span class="help">No Bukti</span></label>
                <div class="col-md-3"><input type="text" class="form-control" rows="3" value="<?php echo @$menus->nobukti?>" name="nobukti" readonly></input></div>
                <label class="col-md-2"><span class="help">Bayar</span></label>
                <div class="col-md-3"><input type="text" name="bayar" class="form-control" rows="3" value="<?php if(@$menus->kasir->bayar=='') echo 0; else echo $menus->kasir->bayar; ?>" onkeyup="bayar1(); cetakkasir();"></input></div>
              </div>
            </td>
            <td>
              <div class="form-group">
                <label class="col-md-2"><span class="help">Keterangan</span></label>
                <div class="col-md-3"><input type="text" name="keterangankasir" class="form-control" rows="3" value="<?php echo $menus->keterangan ?>" onkeyup="cetakkasir();"></input></div>
                <label class="col-md-2"><span class="help">Kembalian</span></label>
                <div class="col-md-3"><input type="text" name="kembalian" class="form-control" rows="3" value="<?php if(@$menus->kasir->kembalian=='') echo 0; else echo $menus->kasir->kembalian; ?>" readonly></input></div>
              </div>
            </td>
            <div class="col-md-3"><input type="hidden" name="id" class="form-control" rows="3" value="<?php echo $menus->id ?>"></input></div>
            <div class="col-md-3"><input type="hidden" name="checkinid" class="form-control" rows="3" value="<?php echo $menus->checkinid ?>"></input></div>
          </tbody>
    </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-success waves-effect waves-light">Simpan</button>
      <a href="<?php echo $this->pathFor('housekeeping-laundry'); ?>" class="btn btn-danger">Kembali</a>
    </div>
  </div>
  <!-- /.modal-content -->
</div>
</div>
</div>
</form>
