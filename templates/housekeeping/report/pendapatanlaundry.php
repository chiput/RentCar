<?php
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Pendapatan Laundry",
  ]);
?>
<h4>Laporan Pendapatan Laundry</h4>
<table class="report">
    <thead>
        <tr>
            <th>No.</th>
            <th>Tanggal</th>
            <th>No Bukti</th>
            <th>Pembayaran</th>
            <th>Total</th>
            <th>No. Kamar</th>
            <th>Service</th>
            <th>Diskon</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($menu as $no => $menus): $total=0;?>
        <tr>
            <td><?php echo $no + 1; ?>.</td>
            <td><?php echo date('d-m-Y', strtotime($menus->tanggal)); ?></td>
            <td><?php echo @$menus->nobukti; ?></td>
            <td>Tunai</td>
            <td><?php foreach($menus->detail as $detail):
                $harga = $detail->kuantitas*($detail->harga-$detail->diskon); $total+=$harga; endforeach; ?>
                <?php echo @$total;?>
            </td>
            <td><?php echo @$menus->room->room->number?></td>
            <td><?php echo @$jumlahservice = $total*$menus->service/100; ?></td>
            <td><?php echo @$jumlahdiskon = $total*$menus->diskon/100; ?></td>
            <td><?php $total = $menus->bayar-$menus->kembalian; echo @$total;?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
