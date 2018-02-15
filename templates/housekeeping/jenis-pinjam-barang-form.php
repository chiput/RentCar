<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Data Barang',
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
<?php $isi = count(@$lama->id); ?>
<form class="form-horizontal" action="<?php echo $this->pathFor('houskeeping-jenis-pinjambarang-save'); ?>" method="post">
<div class="row" id="housekeepingjenis">
        <div class="white-box">
            <h3 class="box-title m-b-0">Jenis Barang Pinjam</h3>
            <p class="text-muted m-b-30">Form Tambah Jenis Barang Pinjam</p>
            <div class="row">
              <div class="col-md-6">
                <div><input type="hidden" class="form-control" value="<?php echo @$menus->id ?>" name="id"></input></div>
                <div><input type="hidden" class="form-control" value="admin" name="user"></input></div>

              <div class="form-group">
              <label class="col-md-12"> <span class="help">Barang</span><span><a href="javascript:void(0)" data-toggle="modal" data-target="#guestsModal" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Cari</a></span></label>
                  <div class="col-md-12"><input type="text" class="form-control" rows="3" name="namabarang" value="<?php if($isi==0){ echo @$menus->barang->nama; }else{ echo $lama->namabarang;} ?>" readonly></input></div>
                  <div><input type="hidden" class="form-control" rows="3" name="namabarangid" value="<?php if($isi==0){ echo @$menus->barangid; }else{ echo $lama->namabarangid;} ?>"></input></div>
              </div>

              <div class="form-group">
                <label class="col-md-12"> <span class="help">Harga</span></label>
                  <div class="col-md-12"><input type="text" class="form-control" rows="3" name="harga" id="harga" value="<?php if($isi==0){ echo @$menus->barang->hargajual; }else{ echo $lama->harga;} ?>" readonly></input></div>
              </div>

              <div class="form-group">
                  <div class="col-md-12">
                    <div class="checkbox checkbox-success">
                    <?php if (!isset($menus)): ?>
                      <input id="status" name="status" type="checkbox" checked="checked" />
                      <label for="status"> Aktif</label>
                    <?php else: ?>
                      <input id="status" name="status" type="checkbox" <?php echo(($menus->aktif == 1) ? 'checked="checked"' : ''); ?> />
                      <label for="status"> Aktif</label>
                    <?php endif; ?>
                    </div>
                  </div>
              </div>

              <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
              <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('houskeeping-jenis-pinjambarang')?>">Batal</a>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  <label class="col-md-12" style="margin-bottom: 18px;"> <span class="help">Kuantitas</span></label>
                  <div class="col-md-12"><input type="text" class="form-control" rows="3" name="kuantitas" id="kuantitas" value="<?php if($isi==0){ echo @$menus->kuantitas; }else{ echo $lama->kuantitas;} ?>"></input></div>
              </div>
              <div class="form-group">
                  <label class="col-md-12"> <span class="help">Harga Sewa</span></label>
                  <div class="col-md-12"><input type="text" class="form-control" rows="3" name="sewa" id="sewa" value="<?php if($isi==0){ echo @$menus->sewa; }else{ echo $lama->sewa;} ?>"></input></div>
              </div>
            </div>
    </div>
  </div>
</div>

<div id="guestsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myModalLabel">Daftar Jenis Barang Pinjam</h4>
      </div>
      <div class="modal-body">
        <table class="table datatable myDataTable">
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Akun</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($barang as $menu): ?>
                <tr>
                    <td>
                        <a href="javascript:void(0)" data-guest-json='<?=$menu?>' onclick="getGuest(this)" data-toggle="tooltip" data-original-title="Pilih" data-dismiss="modal"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                    </td>
                    <td><?php echo @$menu->kode?></td>
                    <td><?php echo @$menu->nama?></td>
                    <td><?php echo @$menu->account->name; ?></td>
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
