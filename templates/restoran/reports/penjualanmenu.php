<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Penjualan Menu",
  ]); 
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
<table class="table table-bordered report">
    <thead>
        <tr>
            <th style="width: 2%;">No.</th>
            <th style="width: 10%;">Kode</th>
            <th style="width: 70%;">Nama Menu</th>
            <th>Jumlah</th>
            
        </tr>
    </thead>
    <tbody>
        <?php $no=1; foreach ($menus as  $menu): ?>
        <tr id="trow-<?php echo $menu->id; ?>">
            <td><?php echo $no; ?>.</td>
            <td><?php echo $menu->kode; ?></td>
            <td><?php echo $menu->nama; ?></td>
            <td><?php echo $menu->jumlahmenu; ?></td>
            
        </tr>
        <?php $no++; endforeach; ?>
    </tbody>
</table>
</div>
</div>
</div>
