<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Laba Penjualan Restoran",
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
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
<table class="table table-bordered report">
    <thead>
        <tr>
            <th style="width: 2%;">No.</th>
            <th style="width: 10%;">Tgl. Faktur</th>
            <th style="width: 10%;">No. Faktur</th>
            <th style="width: 40%;">Menu/Barang</th>
            <th style="width: 10%;">Kuant.</th>
            <th style="width: 10%;">Modal</th>
            <th style="width: 10%;">Harga Jual</th>
            <th>Laba</th>
            
        </tr>
    </thead>
    <tbody>
        <?php $no=1; foreach ($menus as  $menu): ?>
        <tr id="trow-<?php echo $menu->id; ?>">
            <td><?php echo $no; ?>.</td>
            <td><?php echo convert_date(@$menu->tanggal); ?></td>
            <td><?php echo $menu->nobukti; ?></td>
            <td><?php echo $menu->nama; ?></td>
            <td><?php echo $menu->kuantitas; ?></td>
            <td><?php echo $menu->modal; ?></td>
            <td><?php echo $menu->hargajual; ?></td>
            <td><?php echo ($menu->kuantitas*$menu->hargajual)-($menu->kuantitas*$menu->modal); ?></td>
            
        </tr>
        <?php $no++; endforeach; ?>
    </tbody>
</table>
</div>
</div>
</div>
