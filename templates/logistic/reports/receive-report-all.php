<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Penerimaan Barang",
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
<h3>LAPORAN PENERIMAAN BARANG</h3>
    <h4 style="margin-top: -8px;">
        Tanggal <?php echo (@$d_start) ?> sampai <?php echo (@$d_end) ?>
    </h4>
<table class="table table-bordered report" width="780">
    <thead>
        <tr>
            <th>No.</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Satuan </th>
            <th>Tgl. Expired </th>
            <th>Kuantitas </th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach($receives as $receive):
        ?>
        <tr>
            <td colspan="6">
                <table class="innerTable">
                    <tbody>
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td><?php echo convert_date(@$receive->tanggal) ?></td>
                            <td>Gudang</td>
                            <td>:</td>
                            <td><?=$receive->warehouse->nama?></td>
                        </tr>
                        <tr valign="top">
                            <td>No. Pembelian</td>
                            <td>:</td>
                            <td><?=$receive->purchase->nobukti?></td>
                            <td rowspan="2">Keterangan</td>
                            <td rowspan="2">:</td>
                            <td rowspan="2"><?=$receive->keterangan?></td>
                        </tr>
                        <tr>
                            <td>No. Bukti</td>
                            <td>:</td>
                            <td><?=$receive->nobukti?></td>
                            
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>

        <?php foreach ($receive->details as $no => $details): ?>
        <tr id="trow-<?php echo $details->id; ?>">
            <td><?php echo $no + 1; ?>.</td>
            <td><?php echo $details->good->kode; ?></td>
            <td><?php echo $details->good->nama; ?></td>
            <td><?php echo $details->unit->nama; ?></td>
            <td><?php echo ($details->tglexpired=="0000-00-00"?"":$details->tglexpired); ?></td>
            <td align="right"><?php echo $details->kuantitas; ?></td>
        </tr>
        <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>
<br />

<style>
    .innerTable td{
        border: none!important;
    }
</style>