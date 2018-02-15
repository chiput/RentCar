<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Penjualan Store",
  ]); 
?>
<div class="row">
    <div class="col-sm-12">
        <h3>Laporan Penjualan Store</h3>
        <p><strong>Tanggal <?php echo $tanggal; ?></strong></p>
        <div class="white-box">
<table class="table table-bordered report">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Harga Total</th>
            
        </tr>
    </thead>
    <tbody>
        <?php $i=1;$total=0;$diskon=0;
        foreach ($datas as $data):  ?>
        <?php $total += ($data->total*$data->store->harga);$diskon += $data->diskon;?>
        <tr>
            <td><?= $i ?></td>
            <td><?= $data->barang->nama?></td>
            <td><?= $data->total?></td>
            <td><?php echo 'Rp. '.$this->convert($data->store->harga)?></td>
            <td><?php echo 'Rp. '.$this->convert($data->total*$data->store->harga)?></td>
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
