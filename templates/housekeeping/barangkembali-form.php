<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Data Barang Kembali',
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
<form class="form-horizontal" action="<?php echo $this->pathFor('housekeeping-barangkembali-save'); ?>" method="post">
<div class="row" id="housekeepingkembali">
        <div class="white-box">
            <h3 class="box-title m-b-0">Form Pengembalian Barang</h3>
            <p class="text-muted m-b-30"></p>
            <div class="row">
              <div class="col-md-6">
              <input type="hidden" class="form-control" value="<?php echo @$menus->id?>" id="id" name="id"></input>
              <div class="form-group">
                   <label class="col-md-12"> <span class="help"> Tanggal</span></label>
                   <div class="col-md-12">
                       <input type="text" class="form-control mydatepicker" data-date-format="dd-mm-yyyy" value="<?php echo convert_date(substr((@$menus->tanggal==''?date('Y-m-d'):@$menus->tanggal),0,10)) ?>" name="tanggal">
                   </div>
               </div>

              <div class="form-group">
              <label class="col-md-12"> <span class="help">No Bukti</span></span></label>
                  <div class="col-md-12"><input type="text" class="form-control" rows="3" name="nobukti" value="<?php if($isi==0){ echo @$menus->nobukti; }else{ echo $lama->nobukti;} ?>" readonly></input></div>
              </div>

              <div class="form-group">
              <label class="col-md-12"> <span class="help">Barang</span></label>
                  <div class="col-md-12"><input type="text" class="form-control" rows="3" name="namabarang" id="namabarang" value="<?php if($isi==0){ echo @$menus->barangid; }else{ echo $lama->namabarang;} ?>" readonly></input></div>
              </div>

              <div class="form-group">
                <label class="col-md-12"> <span class="help">Kamar</span></label>
                  <div class="col-md-12"><input type="text" class="form-control" rows="3" name="kamar" id="kamar" value="<?php if($isi==0){ echo @$menus->room->room->number; }else{ echo $lama->kamar;} ?>" readonly></input></div>
              </div>

              <div><input type="hidden" class="form-control" rows="3" name="user" value="admin"></input></div>

              <div class="form-group">
                  <div class="col-md-12">
                    <div class="checkbox checkbox-success">
                    <?php if (!isset($menus)): ?>
                      <input id="aktif" name="aktif" type="checkbox" checked="checked" />
                      <label for="aktif"> Aktif</label>
                    <?php else: ?>
                      <input id="aktif" name="aktif" type="checkbox" <?php echo(($menus->aktif == 1) ? 'checked="checked"' : ''); ?> />
                      <label for="aktif"> Aktif</label>
                    <?php endif; ?>
                    </div>
                  </div>
              </div>

            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="col-md-12"> <span class="help">Pinjam</span></label>
                  <div class="col-md-12"><input type="text" class="form-control" rows="3" name="pinjam" id="pinjam" value="<?php if($isi==0){ echo @$menus->kuantitas; }else{ echo $lama->pinjam;} ?>" readonly></input></div>
              </div>

              <div class="form-group">
                <label class="col-md-12"> <span class="help">Kuantitas</span></label>
                  <div class="col-md-12"><input type="text" class="form-control" rows="3" name="kuantitas" value="<?php if($isi==0){ echo @$menus->kuantitaskembali; }else{ echo $lama->kuantitas;} ?>"></input></div>
              </div>

              <div class="form-group">
                  <label class="col-md-12"> <span class="help">Keterangan</span></label>
                  <div class="col-md-12"><textarea class="form-control" rows="3" name="keterangan"><?php if($isi==0){ echo @$menus->keterangan; }else{ echo $lama->keterangan;} ?></textarea></div>
              </div>
            </div>
      </div>
      <div class="row">
          <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
              <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('housekeeping-barangkembali')?>">Batal</a>
      </div>
</div>

<div id="guestsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myModalLabel">Modal Heading</h4>
      </div>
      <div class="modal-body">
        <table class="table datatable myDataTable">
            <thead>
                <tr>
                    <th></th>
                    <th>Tanggal Pinjam</th>
                    <th>No. Pinjam</th>
                    <th>Barang</th>
                    <th>Kuantitas</th>
                    <th>No Kamar</th>
                    <th>Pelanggan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hotpinjam as $namakamar):
                if(($namakamar->tanggalkembali)!=null && ($namakamar->tanggalkembali)!='00-00-0000'){ ?>
                <?php }else{?>
                <tr>
                    <td>
                        <a href="javascript:void(0)" data-guest-json='<?=$namakamar?>' onclick="getGuest(this); myFunction('<?php echo @$namakamar->barang->nama?>'); myFunction1('<?php echo @$namakamar->barang->hargajual?>'); myFunction2('<?php echo @$namakamar->sewa->sewa?>'); myFunction3('<?php echo @$namakamar->room->room->number?>'); myFunction4('<?php echo @$namakamar->id?>');" data-toggle="tooltip" data-original-title="Pilih" data-dismiss="modal"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                    </td>
                    <td><?=convert_date($namakamar->tanggal)?></td>
                    <td><?=$namakamar->nobukti?></td>
                    <td><?php echo @$namakamar->barang->nama?></td>
                    <td><?=$namakamar->kuantitas?></td>
                    <td><?php echo @$namakamar->room->room->number?></td>
                    <td><?php echo @$namakamar->Reservationdetail->reservation->guest->name?></td>
                </tr>
                <?php } endforeach; ?>
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
</form>