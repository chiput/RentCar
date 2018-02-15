<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Order Pembelian",
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
<h2>Order Pembelian</h2>
<table>
    <tbody>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td width="450"><?php echo convert_date(@$purReq->tanggal)?></td>
            <td>Supplier</td>
            <td>:</td>
            <td><?=$purReq->supplier->nama?></td>
        </tr>
        <tr>
            <td>No. Bukti</td>
            <td>:</td>
            <td><?=$purReq->nobukti?></td>
            <td></td>
            <td></td>
            <td><?=$purReq->supplier->alamat?></td>
        </tr>
        <tr>
            <td>Departemen</td>
            <td>:</td>
            <td><?=$purReq->department->name?></td>
            <td rowspan="3"></td>
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
            <th>Harga</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($purReq->details as $no => $details): ?>
        <tr id="trow-<?php echo $details->id; ?>">
            <td><?php echo $no + 1; ?>.</td>
            <td><?php echo $details->good->kode; ?></td>
            <td><?php echo $details->good->nama; ?></td>
            <td><?php echo $details->unit->nama; ?></td>
            <td><?php echo $details->kuantitas; ?></td>
            <td><?php echo $this->convert($details->harga); ?></td>
            <td><?php echo $this->convert($details->kuantitas*$details->harga); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<br />

<br/>