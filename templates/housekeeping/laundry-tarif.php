<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Data Barang Hilang',
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
  <p class="text-muted m-b-30">Daftar Tarif Laundry</p>
<p>
    <a href="<?php echo $this->pathFor('housekeeping-laundry-tarif-add'); ?>" class="btn btn-primary">Tambah Tarif Laundry</a>
</p>
<table class="table table-striped myDataTable">
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
<?php foreach ($menus as $menu): ?>
  <tr>
    <td>
        <a href="<?php echo $this->pathFor('housekeeping-laundry-tarif-edit', ['id' => $menu->id]); ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
        <a href="<?php echo $this->pathFor('housekeeping-laundry-tarif-delete', ['id' => $menu->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>
    </td>
    <td><?php echo @$menu->kode; ?></td>
    <td><?php echo @$menu->nama; ?></td>
    <td><?php echo @$menu->nominal; ?></td>
    <td><?php echo @$menu->layanan->nama; ?></td>
    <td><?php if($menu->aktif==1) echo "Aktif"; else echo "Tidak Aktif"; ?></td>
  </tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
