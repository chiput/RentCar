<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Penjualan Restoran",
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
            <th style="width: 10%;">Tanggal</th>
            <th style="width: 40%;">No. Faktur</th>
            <th style="width: 10%;">Pembayaran</th>
            <th style="width: 10%;">Total</th>
            <th style="width: 10%;">Service</th>
            <th style="width: 10%;">PPN</th>
            <th>Jumlah</th>
            
        </tr>
    </thead>
    <tbody>
        <?php $no=1; foreach ($menus as  $menu): ?>
        <tr id="trow-<?php echo $menu->id; ?>">
            <td><?php echo $no; ?>.</td>
            <td><?php echo convert_date(@$menu->tanggal); ?></td>
            <td><?php echo $menu->nobukti; ?></td>
            <td><?php echo ''; ?></td>
            <td><?php echo $menu->bayar; ?></td>
            <td><?php echo $menu->nservice; ?></td>
            <td><?php echo $menu->nppn; ?></td>
            <td><?php echo $menu->total; ?></td>
            
        </tr>
        <?php $no++; endforeach; ?>
    </tbody>
</table>
</div>
</div>
</div>
