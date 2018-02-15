<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Data Pengembalian Barang',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    //'main_location' => 'Akunting',
    //'submain_location' => 'Tambah Data Header Account'
  ]);
?>
            <?php
                function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
            ?>
<?php if ($this->getSessionFlash('success')): ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('success'); ?>
</div>
<?php endif; ?>

<div class="white-box">
  <h3 class="box-title m-b-0">Pengembalian Barang</h3>
  <p class="text-muted m-b-30">Data Pengembalian Barang</p>
<p>
    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal-kembali">Tambah Pengembalian Barang</a>
</p>
<table class="table table-striped myDataTable">
  <thead>
    <tr>
    <th></th>
    <th>Tanggal</th>
    <th>Tanggal Kembali</th>
    <th>No Bukti</th>
    <th>Nama Barang</th>
    <th>Kamar</th>
    <th>Keterangan</th>
    <th>Status</th>
    <th>User</th>
    <th>User Edit</th>
    </tr>
  </thead>
<tbody>
<?php foreach ($menus as $menu):
  if(($menu->tanggalkembali)!=null && ($menu->tanggalkembali)!='dd-mm-yyyy'){ ?>
    <tr>
      <td>
          <a href="<?php echo $this->pathFor('housekeeping-barangkembali-edit', ['id' => $menu->id]); ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
          <a href="<?php echo $this->pathFor('housekeeping-barangkembali-delete', ['id' => $menu->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>
      </td>
      <td><?php echo convert_date(@$menu->tanggal); ?></td>
      <td><?php echo convert_date(@$menu->tanggalkembali);?></td>
      <td><?php echo @$menu->nobukti; ?></td>
      <td><?php echo @$menu->barangid; ?></td>
      <td><?php echo @$menu->room->room->number; ?></td>
      <td><?php echo @$menu->keterangan; ?></td>
      <td><?php if(($menu->aktif)==1){ echo 'Aktif'; }else{ echo 'Tidak Aktif';} ?></td>
      <td><?=@$menu->user->name?></td>
      <td><?=@$menu->user_edit->name?></td>
    </tr>
<?php } endforeach; ?>
</tbody>
</table>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-kembali">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Daftar Barang</h4>
            </div>
        <div class="modal-body">
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>No. Bukti</th>
                        <th>Nama Barang</th>
                        <th>Kuantitas</th>
                        <th>Kamar</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($menus as $menu) :
                      if(($menu->tanggalkembali) == null || ($menu->tanggalkembali) == 'dd-mm-yyyy'){
                        $link = $this->pathFor('housekeeping-barangkembali-edit', ['id' => $menu->id]);
                    ?>
                    <tr>
                        <td><?php echo convert_date($menu->tanggal) ?></td>
                        <td>
                            <a href="<?php echo $link; ?>"><?php echo $menu->nobukti ?></a>
                        </td>
                        <td><?php echo @$menu->barangid ?></td>
                        <td><?php echo @$menu->kuantitas ?></td>
                        <td><?php echo @$menu->room->room->number ?></td>
                        <td><?php echo @$menu->keterangan ?></td>
                    </tr>
                    <?php } endforeach; ?>
                <tbody>
            </table>
        </div>
        <div class="modal-footer">
            <!-- <a  class="btn btn-primary" href="<?php echo $this->pathFor('frontdesk-reservation-add'); ?>" target="_blank" >Tambah</a> -->
            <!--<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>-->
        </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
