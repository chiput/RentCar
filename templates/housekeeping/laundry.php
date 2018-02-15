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

<?php if ($this->getSessionFlash('success')): ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('success'); ?>
</div>
<?php endif; ?>

<div class="white-box">
  <h3 class="box-title m-b-0">Housekeeping </h3>
  <p class="text-muted m-b-30">Data Laundry</p>
<p>
    <a href="<?php echo $this->pathFor('housekeeping-laundry-add'); ?>" class="btn btn-primary">Tambah Laundry</a>
</p>
<table class="table table-striped myDataTable">
  <thead>
    <tr>
    <th></th>
    <th>Tanggal</th>
    <th>No Bukti</th>
    <th>Nama Pelanggan</th>
    <th>No. Kamar</th>
    <th>Supplier</th>
    <th>Keterangan</th>
    </tr>
  </thead>
<tbody>
<?php foreach ($menus as $menu): ?>
  <tr>
    <td>
        <a href="<?php echo $this->pathFor('housekeeping-laundry-edit', ['id' => $menu->id]); ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
        <a href="<?php echo $this->pathFor('housekeeping-laundry-delete', ['id' => $menu->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
        <a href="<?php echo $this->pathFor('housekeeping-laundry-kasir', ['id' => $menu->id]); ?>" data-toggle="tooltip" data-original-title="Kasir"> <i class="fa fa-money m-r-10"></i> </a>
        <?php if(@$menu->kasir->bayar != ""){ ?>
          <a href="<?php echo $this->pathFor('housekeeping-laundry-cetak', ['id' => $menu->id]); ?>" data-toggle="tooltip" data-original-title="Cetak"> <i class="glyphicon glyphicon-print text-inverse"></i> </a>
        <?php } ?>
    </td>
    <td><?php echo @$menu->tanggal; ?></td>
    <td><?php echo @$menu->nobukti; ?></td>
    <td><?php echo @$menu->room->reservation->guest->name; ?></td>
    <td><?php echo @$menu->room->room->number; ?></td>
    <td><?php echo @$menu->supplier->nama; ?></td>
    <td><?php echo @$menu->keterangan; ?></td>
  </tr>
<?php endforeach; ?>
</tbody>
<tfoot>
  <tr>
    <td colspan="6">Note : Tombol Cetak akan tampil setelah dilakukan pembayaran pada menu Kasir<td>
  </tr>
</tfoot>
</table>
</div>
