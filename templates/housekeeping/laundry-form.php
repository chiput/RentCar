<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Data Laundry',
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

<form class="form-horizontal" action="<?php echo $this->pathFor('housekeeping-laundry-save'); ?>" method="post">
<div class="row" id="laundry">
        <div class="white-box">
            <h3 class="box-title m-b-0">Tambah Data Laundry</h3>
            <p class="text-muted m-b-30">Form Laundry</p>
            <div class="row">
              <div class="col-md-3">
              <input type="hidden" class="form-control" value="<?php echo @$menus->id ?>" name="id"></input>

              <div class="form-group">
                  <label><span class="help"> Tanggal</span></label>
                  <div style="margin-top:14px;">
                      <input type="text" class="form-control mydatepicker" data-date-format="yyyy-mm-dd" value="<?php echo substr((@$menu->tanggal==''?date('Y-m-d'):@$menu->tanggal),0,10) ?>" name="tanggal">
                  </div>
              </div>

              <div class="form-group">
              <label> <span class="help">No Bukti</span></label>
                  <div style="margin-top:14px;"><input type="text" class="form-control" rows="3" name="nobukti" value="<?php echo ( (isset($newCode) ? $newCode : @$menus->nobukti ) ); ?>" readonly></input></div>
              </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="col-md-10"> <span class="help">Kamar</span><span><a href="javascript:void(0)" data-toggle="modal" data-target="#kamarModal" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Cari</a></span></label>
                <div class="col-md-10"><input type="text" class="form-control" rows="3" name="kamar" id="kamar" value="<?php echo @$menus->room->room->number?>" readonly></input></div>
                <div class="col-md-10"><input type="hidden" class="form-control" rows="3" name="checkinid" id="checkinid" value="<?php echo @$menus->checkinid?>" readonly></input></div>
            </div>

            <div class="form-group">
            <label class="col-md-10"> <span class="help">Supplier</span><span><a href="javascript:void(0)" data-toggle="modal" data-target="#supplierModal" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Cari</a></span></label>
                <div class="col-md-10"><input type="text" class="form-control" rows="3" name="supplier" value="<?php echo @$menus->supplier->nama?>" readonly></input></div>
                <div class="col-md-10"><input type="hidden" class="form-control" rows="3" name="supplierid" id="supplierid" value="<?php echo @$menus->supplierid?>" readonly></input></div>
            </div>
          </div>
          <div class="col-md-4" style="margin-left:-70px;">
            <div class="form-group">
                <label class="col-md-10"> <span class="help">Keterangan</span></label>
                <div style="margin-top:14px;" class="col-md-10"><input type="text" class="form-control" rows="3" name="keterangan" value="<?php echo @$menus->keterangan ?>"></input></div>
            </div>

            <div class="form-group">
                <label class="col-md-10"> <span class="help">Status Laundry</span></label>
                <div style="margin-top:15px;" class="col-md-10">
                  <select class="form-control select2" name="proses">
                      <option value="0" <?php echo @$menus->proses?'selected="selected"':''?>>On Proses</option>
                      <option value="1" <?php echo @$menus->proses?'selected="selected"':''?>>Selesai</option>
                  </select>
                </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <table class="table" id="tabledetail">
                  <thead>
                      <tr>
                          <th></th>
                          <th>Kode</th>
                          <th>Nama</th>
                          <th>Layanan</th>
                          <th>Keterangan</th>
                          <th>Kuantitas</th>
                          <th>Harga</th>
                          <th>Diskon</th>
                          <th>Jumlah</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                      if(@$menus->detail != ''){
                      $i=0; $total=0; $totalk=0;
                      foreach(@$menus->detail as $detail){
                        $harga = $detail->harga-$detail->diskon;
                        $jumlah = $detail->kuantitas*$harga; ?>
                      <tr>
                          <td>
                              <a href="#" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>
                          </td>
                          <td>
                            <input type="hidden" name="kode[]" class="form-control" value="" readonly>
                            <?php echo @$detail->tarif->kode?>
                          </td>
                          <td>
                            <input type="text" name="nama[]" class="form-control" value="<?php echo @$detail->tarif->nama?>" readonly>
                          </td>
                          <td>
                            <input type="text" name="layanan[]" class="form-control" value="<?php echo @$detail->tarif->layanan->nama?>" readonly>
                            <input type="hidden" name="tarifid[]" class="form-control" value="<?php echo @$detail->tarifid?>">
                          </td>
                          <td>
                            <input type="text" name="keterangandetail[]" class="form-control" value="<?php echo @$detail->keterangan?>" onkeyup="kasir();">
                          </td>
                          <td>
                            <input type="text" name="kuantitas[]" class="form-control" id='kuantitas_<?=$i;?>' value="<?php echo @$detail->kuantitas?>" onkeyup="totalk(this); kali(this.value,this.id); totaling(this); kasir()">
                          </td>
                          <td>
                            <input type="text" name="harga[]" class="form-control" id='harga_<?=$i;?>' value="<?php echo @$detail->harga?>" onkeyup="kali(this.value,this.id); totaling(this); kasir()">
                          </td>
                          <td>
                            <input type="text" name="diskon[]" class="form-control" id='diskon_<?=$i;?>' value="<?php echo @$detail->diskon?>" onkeyup="kali(this.value,this.id); totaling(this); kasir()">
                          </td>
                          <td>
                            <input type="text" name="jumlah[]" class="form-control" id='jumlah_<?=$i;?>' value="<?php echo @$jumlah?>" onkeyup="totaling()" readonly>
                          </td>
                      </tr>
                      <?php $i++; $total+=$jumlah; $totalk+=$detail->kuantitas; } } ?>
                  </tbody>
                  <tfoot>
                      <tr>
                          <td colspan="4">
                              <a href="javascript:void(0)" data-toggle="modal" data-target="#tarifModal" data-original-title="Tambah"> <i class="fa fa-plus-circle"></i> </a>
                          </td>
                      </tr>
                  </tfoot>
              </table>
          <div class="col-md-5">
            <div class="form-group">
              <table class="table">
                <tr>
                  <td><div class="form-control">Total Kuantitas</div></td>
                  <td><input type="text" name="totalkuantitas" class="form-control" value="<?php echo @$totalk;?>" readonly></td>
                </tr>
                <tr>
                  <td><div class="form-control">Total</div></td>
                  <td><input type="text" name="total" class="form-control" id="totals" value="<?php echo @$total;?>" readonly></td>
                </tr>
                <tr>
                  <td><button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
                  <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('housekeeping-laundry')?>">Batal</a>
                </tr>
              </table>
            </div>
          </div>
          </div>
          </div>
      </div>
    </div>
</div>

<div id="kamarModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myModalLabel">Daftar Kamar</h4>
      </div>
      <div class="modal-body">
        <table class="table datatable myDataTable">
            <thead>
                <tr>
                    <th></th>
                    <th>Nomor</th>
                    <th>No. Check In</th>
                    <th>No. Reservasi</th>
                    <th>Pelanggan</th>
                    <th>Perusahaan</th>
                    <th>Tgl. Check In</th>
                    <th>Tgl. Check Out</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kamar as $namakamar): ?>
                  <?php if((($namakamar->checkout_at)=='')&&(($namakamar->checkin_code)!='')){ ?>
                <tr>
                    <td>
                        <a href="javascript:void(0)" data-guest-json='<?php echo @$namakamar?>' onclick="getGuest(this); myFunction('<?php echo @$namakamar->room->number?>')" data-toggle="tooltip" data-original-title="Pilih" data-dismiss="modal"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                    </td>
                    <td><?php echo @$namakamar->room->number?></td>
                    <td><?php echo @$namakamar->checkin_code?></td>
                    <td><?php echo @$namakamar->reservation->nobukti?></td>
                    <td><?php echo @$namakamar->reservation->guest->name?></td>
                    <td><?php echo @$namakamar->reservation->guest->company->name?></td>
                    <td><?php echo @$namakamar->reservation->checkin?></td>
                    <td><?php echo @$namakamar->reservation->checkout?></td>
                </tr>
                <?php } endforeach; ?>
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div id="tarifModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myModalLabel">Daftar Tarif & Layanan Laundry</h4>
      </div>
      <div class="modal-body">
        <table class="table datatable myDataTable">
            <thead>
                <tr>
                    <th></th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Nominal</th>
                    <th>Layanan</th>
                    <th>Aktif</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tarif as $launtarif): ?>
                <tr>
                    <td>
                        <a href="javascript:void(0)" data-harga="<?php echo @$launtarif->nominal?>" data-keterangan="<?php echo @$launtarif->keterangan?>" data-layanan="<?php echo @$launtarif->layanan->nama?>" data-nama="<?php echo @$launtarif->nama?>" data-kode="<?php echo @$launtarif->kode?>"
                          data-id="<?php echo @$launtarif->id?>" data-toggle="tooltip" data-original-title="Pilih" data-dismiss="modal"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                    </td>
                    <td><?php echo @$launtarif->kode?></td>
                    <td><?php echo @$launtarif->nama?></td>
                    <td><?php echo @$launtarif->nominal?></td>
                    <td><?php echo @$launtarif->layanan->nama?></td>
                    <td><?php echo @$launtarif->aktif?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div id="supplierModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
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
                    <th>Kode</th>
                    <th>Supplier</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($supplier as $supp): ?>
                <tr>
                    <td>
                        <a href="javascript:void(0)" data-supplier-json='<?php echo @$supp?>' onclick="getSupplier(this);" data-toggle="tooltip" data-original-title="Pilih" data-dismiss="modal"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                    </td>
                    <td><?php echo @$supp->kode?></td>
                    <td><?php echo @$supp->nama?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

</form>
