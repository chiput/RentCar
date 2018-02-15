<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Penjualan Restoran",
  ]); 
?>
<div class="row">
    <div class="col-sm-12">
        <h3>LAPORAN PENJUALAN RESTORAN</h3>
        <p><strong>Tanggal <?php echo $tanggal; ?></strong></p>
        <div class="white-box">
<table class="table table-bordered report">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Menu</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Harga Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1;$total=0;$diskon=0;
        foreach ($menus as $menu):  ?>
        <?php $total += ($menu->total*$menu->hargajual);$diskon += $menu->diskon;?>
        <tr>
            <td><?= $i ?></td>
            <td><?= $menu->nama?></td>
            <td><?= $menu->total?></td>
            <td><?= 'Rp. '.$this->convert($menu->hargajual)?></td>
            <td><?php echo 'Rp. '.$this->convert($menu->total*$menu->hargajual)?></td>
        </tr>
        <?php endforeach; ?>

        <!-- Perulangan menu tambahan-->
        <?php foreach ($services as $menu):  ?>
        <?php if(!is_numeric($menu->menuid)){
            $hargasatuan = $menu->harga/$menu->totalqty;
            $total += $menu->harga;
        ?>
        <tr>
            <td><?= $i ?></td>
            <td><?= $menu->menuid?></td>
            <td><?= $menu->totalqty?></td>
            <td><?= 'Rp. '.$this->convert($hargasatuan)?></td>
            <td><?php echo 'Rp. '.$this->convert($menu->harga)?></td>
        </tr>
        <?php } $i++;endforeach; ?>
        <!-- end perulangan menu tambahan -->
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
