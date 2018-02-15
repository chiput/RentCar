<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Data Barang Temuan',
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
<?php endif;
 function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
 ?>
<?php $isi = count(@$lama->id); ?>
<form class="form-horizontal" action="<?php echo $this->pathFor('housekeeping-barangtemuan-save'); ?>" method="post">
<div class="row" id="housekeepingtemuan">
        <div class="white-box">
            <h3 class="box-title m-b-0">Form Barang Temuan</h3>
            <p class="text-muted m-b-30"></p>
            <div class="row">
              <div class="col-md-6">
              <input type="hidden" class="form-control" value="<?php echo @$menus->id ?>" name="id"></input>

              <div class="form-group">
              <label class="col-md-12"> <span class="help"> Tanggal</span></label>
                <div class="col-md-12">
                  <input type="text" class="form-control mydatepicker" data-date-format="dd-mm-yyyy" value="<?php echo convert_date(substr((@$menus->tanggal==''?date('Y-m-d'):@$menus->tanggal),0,10)) ?>" name="tanggal">
                </div>
              </div>

              <div class="form-group">
              <label class="col-md-12"> <span class="help">No Bukti</span></label>
                  <div class="col-md-12"><input type="text" class="form-control" rows="3" name="nobukti" value="<?php echo ( (isset($newCode) ? $newCode : @$menus->nobukti ) ); ?>" readonly></input></div>
              </div>

              <div class="form-group">
                <label class="col-md-12" style="width: 100%;"> <span class="help">Kamar</span>
                <span><a href="javascript:void(0)" data-toggle="modal" data-target="#guestsModal" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Cari</a></span>
                </label>
                  <div class="col-md-12"><input type="text" class="form-control" rows="3" name="kamar" id="kamar" value="<?php if($isi==0){ echo @$menus->roomnya->number; }else{ echo $lama->kamar;} ?>" readonly></input></div>
                  <div class="col-md-12"><input type="hidden" class="form-control" rows="3" name="checkinid" id="checkinid" value="<?php if($isi==0){ echo @$menus->checkinid; }else{ echo $lama->checkinid;} ?>" readonly></input></div>
              </div>

              <div class="form-group">
                  <div class="col-md-12">
                    <div class="checkbox checkbox-success">
                    <?php if (!isset($menus)): ?>
                      <input id="aktif" name="aktif" type="checkbox" checked="checked" />
                      <label for="aktif"> Belum Diambil</label>
                    <?php else: ?>
                      <input id="aktif" name="aktif" type="checkbox" <?php echo(($menus->aktif == 1) ? 'checked="checked"' : ''); ?> />
                      <label for="aktif"> Belum Diambil</label>
                    <?php endif; ?>
                    </div>
                  </div>
              </div>
              <div><input type="hidden" class="form-control" rows="3" name="user" value="admin"></input></div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
              <label class="col-md-12"> <span class="help">Barang</span></label>
                  <div class="col-md-12"><input type="text" class="form-control" rows="3" name="barangid" value="<?php if($isi==0){ echo @$menus->barangid; }else{ echo $lama->barangid;} ?>"></input></div>
              </div>
            <div class="form-group">
            <label class="col-md-12"> <span class="help">Ditemukan Oleh</span></label>
                <div class="col-md-12"><input type="text" class="form-control" rows="3" name="karyawanid" value="<?php if($isi==0){ echo @$menus->karyawanid; }else{ echo $lama->karyawanid;} ?>"></input></div>
            </div>
              <div class="form-group">
                  <label class="col-md-12" style="margin-bottom: 18px;"> <span class="help">Keterangan</span></label>
                  <div class="col-md-12"><textarea class="form-control" rows="3" name="keterangan"><?php if($isi==0){ echo @$menus->keterangan; }else{ echo $lama->keterangan;} ?></textarea></div>
              </div>
            </div>
            <div class="col-md-12">
            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
              <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('housekeeping-barangtemuan')?>">Batal</a>
              </div>
        </div>
    </div>
  </div>

<div id="guestsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
                    <th>Aksi</th>
                    <th>Nomor</th>
                    <th>Gedung</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservationdetails as $namakamar): ?>
                <tr>
                    <td>
                        <a href="javascript:void(0)" data-guest-json='<?=$namakamar?>' onclick="getGuest(this); myFunction('<?=$namakamar->number?>');myFunctions('<?=@$namakamar->id?>')" data-toggle="tooltip" data-original-title="Pilih" data-dismiss="modal"><button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Pilih</button>
                        </a>
                    </td>
                    <td><?php echo @$namakamar->number?></td>
                    <td><?php echo @$namakamar->building->name?></td>
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

</form>


</form>
<script type="text/javascript">
  function myFunctions(id) {
     document.getElementById("checkinid").value = id;
     console.log(id);
  }
</script>
