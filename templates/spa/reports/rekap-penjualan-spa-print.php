<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Rekap Penjualan Spa",
  ]); 
?>
<h3>LAPORAN REKAP PENJUALAN SPA</h3>
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
        <?php $i=1;$totalpenjualan=0;$cash=0;$sign=0;$credit=0;
        foreach ($layanan as $layanan):  ?>
        <?php $totalpenjualan += ($layanan->tunai + $layanan->totalkamar + $layanan->kartubayar); ?>
        <tr>
            <td><?= $i ?></td>
            <td><?= $layanan->nobukti?></td>
            <td><?php if($layanan->checkinid != ''){ echo $layanan->reservationdetail->room->number;} else { echo ''; }?></td>
            <td><?php if($layanan->tunai > 0){ echo 'Rp. '.$this->convert($layanan->tunai); $cash += $layanan->tunai;} else { echo ''; }?></td>
            <td><?php if($layanan->totalkamar > 0){ echo 'Rp. '.$this->convert($layanan->totalkamar); $sign += $layanan->totalkamar;} else { echo ''; }?></td>
            <td><?php if($layanan->kartubayar > 0){ echo 'Rp. '.$this->convert($layanan->kartubayar); $cerdit += $layanan->kartubayar;} else { echo '';}?></td>
            <td></td>
        </tr>
        <?php $i++;endforeach; ?>
    <tbody>
    <tfoot>
        <tr>
            <td colspan="3" style="text-align: center;"><b>Total</b></td>
            <td><?php if($cash > 0){ echo 'Rp. '.$this->convert($cash);} else { echo '';} ?></td>
            <td><?php if($sign > 0){ echo 'Rp. '.$this->convert($sign);} else { echo '';} ?></td>
            <td><?php if($credit > 0){ echo 'Rp. '.$this->convert($credit);} else { echo '';} ?></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center;"><b>Total Penjualan: </b></td>
            <td colspan="3"><?php echo 'Rp. '.$this->convert($totalpenjualan); ?></td>
            <td></td>
        </tr>
    </tfoot>
</table>