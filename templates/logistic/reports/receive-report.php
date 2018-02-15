<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Penerimaan Barang",
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
<h3>Penerimaan Barang</h3>
<table>
    <tbody>
        <tr>
            <td>Tanggal </td><td>:</td>
            <td><?php echo convert_date(@$receive->tanggal)?></td>
            <td>No. Bukti </td><td>:</td>
            <td><?=$receive->nobukti?></td>
        </tr>
        <tr>
            <td>Gudang </td><td>:</td>
            <td><?=$receive->warehouse->nama?></td>
            <td>No. Pembelian </td><td>:</td>
            <td><?=$receive->purchase->nobukti?></td>
            
        </tr>
        <tr>
            <td>Departemen </td><td>:</td>
            <td><?=$receive->warehouse->department->name?></td>
            <td>Keterangan </td><td>:</td>
            <td><?=$receive->keterangan?></td>
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
            <th>Tanggal Expired </th>
            <th>Kuantitas </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($receive->details as $no => $details): ?>
        <tr id="trow-<?php echo $details->id; ?>">
            <td><?php echo $no + 1; ?>.</td>
            <td><?php echo $details->good->kode; ?></td>
            <td><?php echo $details->good->nama; ?></td>
            <td><?php echo $details->unit->nama; ?></td>
            <td><?php echo convert_date(@$details->tglexpired=="0000-00-00"?"":@$details->tglexpired); ?></td>
            <td><?php echo $details->kuantitas; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<br />
<table class="report" width="500">
    <thead>
    <tr>
        <th width="50%">Bag. Gudang</th>
        <th>Pengirim</th>
    </tr>
    </thead>
    <tbody>
        <tr height="80">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </tbody>
</table>
<br/>