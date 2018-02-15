<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Stok Opname",
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
<h2>Stok Opname</h2>
<table>
    <tbody>
        <tr>
            <td>Tanggal :</td>
            <td><?php echo convert_date(@$stock->tanggal)?></td>
        </tr>
        <tr>
            <td>No. Bukti :</td>
            <td><?=$stock->nobukti?></td>
        </tr>
        <tr>
            <td>Gudang :</td>
            <td><?=$stock->warehouse->nama?></td>
        </tr>
        <tr>
            <td>Keterangan :</td>
            <td><?=$stock->keterangan?></td>
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
        <?php foreach ($stock->details as $no => $details): ?>
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
<br />
<table class="report" width="500">
    <thead>
    <tr>
        <th>Diminta Oleh</th>
        <th>Disetujui Oleh</th>
        <th>Mengetahui</th>
    </tr>
    </thead>
    <tbody>
        <tr height="80">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </tbody>
</table>
<br/>