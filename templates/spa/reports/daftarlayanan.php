<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Daftar Layanan Terapi",
  ]); 
?>
<div class="row">
    <div class="col-sm-12">
        <h3>LAPORAN DAFTAR LAYANAN</h3>
        <div class="white-box">
<table class="table table-bordered report">
    <thead>
        <tr>
            <th style="width: 2%;">No.</th>
            <th style="width: 70%;">Nama Layanan</th>
            <th>Katagori</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; foreach ($layanan as  $layanan): ?>
        <tr id="trow-<?php echo $layanan->id; ?>">
            <td><?php echo $no; ?>.</td>
            <td><?php echo $layanan->nama_layanan; ?></td>
            <td><?php echo $layanan->katnama; ?></td>
            <td style="text-align: right;"><?php echo $this->convert($layanan->hargajual); ?></td>
        </tr>
        <?php $no++; endforeach; ?>
    </tbody>
</table>
</div>
</div>
</div>
