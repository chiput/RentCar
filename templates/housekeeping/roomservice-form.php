<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Room Service',
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
<form class="form-horizontal" action="<?php echo $this->pathFor('houskeeping-roomservice-save'); ?>" method="post">
<div class="row" id="roomservice">
        <div class="white-box">
            <h3 class="box-title m-b-0">Form Room Service</h3>
            <p class="text-muted m-b-30"></p>
            <div class="row">
              <div class="col-md-5 m-r-30">
                <div><input type="hidden" class="form-control" value="<?php echo @$menus->id ?>" name="id"></input></div>
                <div><input type="hidden" class="form-control" value="admin" name="user"></input></div>

                <div class="form-group">
                <label> <span class="help"> Tanggal</span></label>
                  <div>
                    <input type="text" class="form-control mydatepicker" data-date-format="dd-mm-yyyy" value="<?php echo @$menus->tanggal==''?date('d-m-Y'): convert_date(@$menus->tanggal)?>" name="tanggal">
                  </div>
                </div>

              <div class="form-group">
              <label> <span class="help">No Bukti</span></label>
                  <div><input type="text" class="form-control" rows="3" name="nobukti" value="<?php echo ( (isset($newCode) ? $newCode : @$menus->nobukti ) ); ?>" readonly></input></div>
              </div>

              <div class="form-group">
              <label> <span class="help">Nama Karyawan</span></label>
                  <div><input type="text" class="form-control" rows="3" name="karyawanid" value="<?php echo @$menus->karyawanid?>"></input></div>
              </div>

              <div class="form-group">
                  <label> <span class="help">Keterangan</span></label>
                  <div><textarea class="form-control" rows="3" name="keterangan"><?php echo @$menus->keterangan?></textarea></div>
              </div>
             </div>

          <div id="barangModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
                              <th>Nama Gedung</th>
                              <th>Nama Kamar</th>
                              <th>Tipe Kamar</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php foreach ($gedung as $menu): ?>
                            <?php foreach ($menu->rooms as $kamar): ?>
                            <tr id="<?=$kamar->id?>">
                                <td>
                                    <a href="javascript:void(0)" data-id="<?=$kamar->id?>" data-kamar="<?=$kamar->number?>" data-tipe="<?=$kamar->roomType->name?>" data-name="<?=$menu->name?>" onclick="getBuilding('<?=$menu->id?>'); Kamar('<?=$kamar->id?>')" data-toggle="tooltip" data-original-title="Pilih" data-dismiss="modal"> <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Pilih</button></a>
                                </td>
                                <td><?php echo @$menu->name; ?></td>
                                <td><?php echo @$kamar->number; ?></td>
                                <td><?php echo @$kamar->roomType->name; ?></td>
                            </tr>
                            <?php endforeach; ?>
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

          <div class="col-md-6">
            <div class="form-group">
            <label class="col-md-12"> <span class="help">Kamar</span></label>
            <table class="table" id="tabledetail1">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nama Gedung</th>
                        <th>Nama Kamar</th>
                        <th>Tipe Kamar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(@$menus->service != ''){
                    foreach ($menus->service as $detail): ?>
                    <tr>
                        <td>
                            <a href="#" data-gedung="<?=$detail->room->id?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>
                        </td>
                        <td>
                          <input type="hidden" class="form-control">
                          <?php echo @$detail->room->building->name?>
                        </td>
                        <td>
                          <input type="hidden" name="kamar_id[]" class="form-control" value="<?php echo @$detail->room->id?>">
                          <?php echo @$detail->room->number?>
                        </td>
                        <td>
                          <input type="hidden" class="form-control" style="width:100px;">
                          <?php echo @$detail->room->roomType->name?>
                        </td>
                    </tr>
                    <?php echo '<script>$("#'.@$detail->room->id.'").addClass("hidden");</script>' ?>
                  <?php endforeach; } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#barangModal" data-original-title="Tambah"> <i class="fa fa-plus-circle"></i> </a>
                        </td>
                    </tr>
                </tfoot>
            </table>
          </div>
          </div>
                          <div class="col-md-12">
                 <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
              <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('houskeeping-roomservice')?>">Batal</a>
              </div>
</div>
</div>

<div id="kamarModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
                    <th>Menu</th>
                    <th>Kode Gedung</th>
                    <th>Nama Gedung</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($gedung as $menu): ?>
                <tr>
                    <td>
                        <a href="javascript:void(0)" data-id="<?=$menu->id?>" data-name="<?=$menu->name?>" onclick="getKamar('<?=$menu->id?>')" data-toggle="tooltip" data-original-title="Pilih" data-dismiss="modal"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                    </td>
                    <td><?php echo @$menu->id; ?></td>
                    <td><?php echo @$menu->name; ?></td>
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
<input type="hidden" id="listUnits" value='<?=$rooms?>'/>
<input type="hidden" id="building" value=""/>
<input type="hidden" id="kamar" value=""/>
</div>
</form>
