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
  <h3 class="box-title m-b-0">Barang Temuan</h3>
  <p class="text-muted m-b-30">Data Barang Temuan</p>
<p>
    <a href="<?php echo $this->pathFor('housekeeping-barangtemuan-add'); ?>" class="btn btn-primary">Tambah Barang Temuan</a>
</p>
<table class="table table-striped myDataTable">
  <thead>
    <tr>
    <th></th>
    <th>Tanggal</th>
    <th>No Bukti</th>
    <th>Nama Barang</th>
    <th>Ditemukan</th>
    <th>Kamar</th>
    <th>Keterangan</th>
    <th>Status</th>
    <th>User</th>
    <th>User Edit</th>
    </tr>
  </thead>
<tbody>
<?php foreach ($menus as $menu): ?>
  <tr>
    <td>
        <a href="<?php echo $this->pathFor('housekeeping-barangtemuan-edit', ['id' => $menu->id]); ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
        <a href="<?php echo $this->pathFor('housekeeping-barangtemuan-delete', ['id' => $menu->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>
    </td>
    <td><?php echo convert_date(@$menu->tanggal); ?></td>
    <td><?php echo @$menu->nobukti; ?></td>
    <td><?php echo @$menu->barangid; ?></td>
    <td><?php echo @$menu->karyawanid; ?></td>
    <td><?php echo @$menu->roomnya->number; ?></td>
    <td><?php echo @$menu->keterangan; ?></td>
    <td><?php if(($menu->aktif)==1){ echo 'Belum Diambil'; }else{ echo 'Sudah Diambil';} ?></td>
    <td><?=@$menu->user->name?></td>
    <td><?=@$menu->user_edit->name?></td>
  </tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
