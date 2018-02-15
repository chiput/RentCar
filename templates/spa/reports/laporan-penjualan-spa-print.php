<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Penjualan Spa",
  ]); 
?>
<div class="row">
    <div class="col-sm-12">
        <h3>LAPORAN PENJUALAN SPA</h3>
        <p><strong>Tanggal <?php echo $tanggal; ?></strong></p>
        <div class="white-box">
<table class="table table-bordered report">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Layanan</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Harga Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1;$total=0;$diskon=0;
        foreach ($layanan as $layanan):  ?>
        <?php
         $total += ($layanan->total*$layanan->hargajual);$diskon += $layanan->diskon;
        ?>
        <tr>
            <td><?= $i ?></td>
            <td><?= $layanan->nama_layanan?></td>
            <td><?= $layanan->total?></td>
            <td><?= 'Rp. '.$this->convert($layanan->hargajual)?></td>
            <td><?php echo 'Rp. '.$this->convert($layanan->total*$layanan->hargajual)?> 
            </td>
        </tr>
        <?php $i++;endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" style="text-align: right;"><b>Total Diskon: </b></td>
            <td><?php echo 'Rp. '.$this->convert($diskon); ?></td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: right;"><b>Total Penjualan: </b></td>
            <td><?php echo 'Rp. '.$this->convert($total); ?></td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: right;"><b>Total: </b></td>
            <td><?php echo 'Rp. '.$this->convert($total - $diskon); ?></td>
        </tr>
    </tfoot>
</table>
</div>
</div>
</div>
