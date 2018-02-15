<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Daftar Menu",
  ]); 
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
        <h3>LAPORAN DAFTAR MENU</h3>
<table class="table table-bordered report">
    <thead>
        <tr>
            <th style="width: 2%;">No.</th>
            <th style="width: 70%;">Nama Menu</th>
            <th>Katagori</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; foreach ($menus as  $menu): ?>
        <tr id="trow-<?php echo $menu->id; ?>">
            <td><?php echo $no; ?>.</td>
            <td><?php echo $menu->nama; ?></td>
            <td><?php echo $menu->katnama; ?></td>
            <td style="text-align: right;"><?php echo  $this->convert($menu->hargajual); ?></td>
        </tr>
        <?php $no++; endforeach; ?>
    </tbody>
</table>
</div>
</div>
</div>
