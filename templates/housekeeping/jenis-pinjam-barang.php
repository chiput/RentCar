<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Jenis Barang Pinjam',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    //'main_location' => 'Akunting',
    //'submain_location' => 'Tambah Data Header Account'
  ]);
?>

<?php if ($this->getSessionFlash('success')): ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('success'); ?>
</div>
<?php endif; ?>

<div class="white-box">
  <h3 class="box-title m-b-0">Housekeeping</h3>
  <p class="text-muted m-b-30">Data Jenis Barang Pinjam</p>
<p>
    <a href="<?php echo $this->pathFor('houskeeping-jenis-pinjambarang-form'); ?>" class="btn btn-primary">Tambah Jenis Barang Pinjam</a>
</p>
<table class="table table-striped myDataTable">
  <thead>
    <tr>
    <th></th>
    <th>Nama Barang</th>
    <th>Kuantitas</th>
    <th>Harga Sewa</th>
    <th>Status</th>
    </tr>
  </thead>
<tbody>
<?php foreach ($menus as $menu): ?>
  <tr>
    <td>
        <a href="<?php echo $this->pathFor('houskeeping-jenis-pinjambarang-edit', ['id' => $menu->id]); ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
        <a href="<?php echo $this->pathFor('houskeeping-jenis-pinjambarang-delete', ['id' => $menu->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>
    </td>
    <td><?php echo @$menu->barang->nama; ?></td>
    <td><?php echo @$menu->kuantitas; ?></td>
    <td><?php echo @$menu->sewa; ?></td>
    <td><?php if(($menu->aktif)==1){ echo 'Aktif'; }else{ echo 'Tidak Aktif';} ?></td>
  </tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
