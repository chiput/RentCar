<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Retur Pembelian",
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
<h2>Retur Pembelian</h2>
<table>
    <tbody>
        <tr>
            <td>Tanggal </td><td>:</td>
            <td><?php echo convert_date(@$retur->tanggal)?></td>
        </tr>
        <tr>
            <td>No. Bukti </td><td>:</td>
            <td><?=$retur->nobukti?></td>
        </tr>
        <tr>
            <td>No. Pembelian</td><td>:</td>
            <td><?=$retur->purchase->nobukti?></td>
        </tr>
    </tbody>
</table>
<table class="report" width="780">
    <thead>
        <tr>
            <th>No.</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Satuan </th>
            <th>Kuantitas </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($retur->details as $no => $details): ?>
        <tr id="trow-<?php echo $details->id; ?>">
            <td><?php echo $no + 1; ?>.</td>
            <td><?php echo $details->good->kode; ?></td>
            <td><?php echo $details->good->nama; ?></td>
            <td><?php echo $details->unit->nama; ?></td>
            <td><?php echo $details->kuantitas; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<br/>