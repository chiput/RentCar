<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Rekap Penjualan",
  ]); 
?>
<h3>LAPORAN REKAP PENJUALAN</h3>
<p><strong>Tanggal <?php echo $tanggal; ?></strong></p>
<table class="report">
    <thead>
        <tr>
            <th>No</th>
            <th>No. Bukti</th>
            <th>No. Kamar</th>
            <th>Cash</th>
            <th>Sign</th>
            <th>Credit Card</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1;
        $totalpenjualan=0;
        $cash = 0;
        $sign = 0;
        $credit = 0;
        foreach ($menus as $menu):  ?>
        <?php $totalpenjualan += ($menu->tunai + $menu->totalkamar + $menu->kartubayar); ?>
        <tr>
            <td><?= $i ?></td>
            <td><?= $menu->nobukti?></td>
            <td><?php if($menu->checkinid != ''){ echo $menu->reservationdetail->room->number;} else { echo '-'; }?></td>
            <td><?php if($menu->tunai > 0){ echo 'Rp. '.$this->convert($menu->tunai); $cash += $menu->tunai; } else { echo '-'; }?></td>
            <td><?php if($menu->totalkamar > 0){ echo 'Rp. '.$this->convert($menu->totalkamar); $sign += $menu->totalkamar;} else { echo '-'; }?></td>
            <td><?php if($menu->kartubayar > 0){ echo 'Rp. '.$this->convert($menu->kartubayar); $credit += $menu->kartubayar;} else { echo '-';}?></td>
            <td><?= $menu->keterangan?></td>
        </tr>
        <?php $i++;endforeach; ?>
        <tr>
            <td colspan="3" style="text-align: center;"><b>Total</b></td>
            <td><?php if($cash > 0){ echo 'Rp. '.$this->convert($cash);} else { echo '-';} ?></td>
            <td><?php if($sign > 0){ echo 'Rp. '.$this->convert($sign);} else { echo '-';} ?></td>
            <td><?php if($credit > 0){ echo 'Rp. '.$this->convert($credit);} else { echo '-';} ?></td>
            <td> - </td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center;"><b>Total Penjualan: </b></td>
            <td colspan="3"><?php echo 'Rp. '.$this->convert($totalpenjualan); ?></td>
            <td>-</td>
        </tr>
    <tbody>
</table>