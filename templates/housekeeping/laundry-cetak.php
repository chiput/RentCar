<?php
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Cetak Laundry",
  ]);
?>
<table class="report">
    <thead>
        <tr>
            <td>No</td>
            <th>Kode</th>
            <th>Nama</th>
            <th>Layanan</th>
            <th>Keterangan</th>
            <th>Kuantitas</th>
            <th>Harga</th>
            <th>Diskon</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if(@$menus->detail != ''){
        $i=1; $total=0; $totalk=0; $grandtotal=0;
        foreach(@$menus->detail as $detail){ $jumlah = ($detail->harga-$detail->diskon)*$detail->kuantitas; ?>
        <tr>
            <td><?php echo $i ?></td>
            <td><?php echo @$detail->tarif->kode?></td>
            <td><?php echo @$detail->tarif->nama?></td>
            <td><?php echo @$detail->tarif->layanan->nama?></td>
            <td><?php echo @$detail->keterangan?></td>
            <td><?php echo @$detail->kuantitas?></td>
            <td><?php echo @$detail->harga?></td>
            <td><?php echo @$detail->diskon?></td>
            <td><?php echo @$jumlah?></td>
        </tr>
        <?php $i++; $total+=$jumlah; $totalk+=$detail->kuantitas; } } ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="8">Diskon (%)</td>
        <td><?php echo @$menus->kasir->diskon; ?></td>
      </tr>
      <tr>
        <td colspan="8">Service (%)</td>
        <td><?php echo @$menus->kasir->service; ?></td>
      </tr>
      <tr>
        <td colspan="8">Total Kuantitas</td>
        <td><?php echo @$totalk; ?></td>
      </tr>
      <tr>
        <td colspan="8">Grand Total</td>
        <?php $jumlahdiskon = $total*(($menus->kasir->diskon-$menus->kasir->service)/100); ?>
        <td><?php $grandtotal = $total-$jumlahdiskon; echo @$grandtotal; ?></td>
      </tr>
      <tr>
        <td colspan="8">Bayar</td>
        <td><?php echo @$menus->kasir->bayar; ?></td>
      </tr>
      <tr>
        <td colspan="8">Kembalian</td>
        <td><?php echo @$menus->kasir->kembalian; ?></td>
      </tr>
    </tfoot>
</table>
