<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Barang Hilang / Rusak",
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
<h3>LAPORAN BARANG HILANG / RUSAK</h3>
    <h4 style="margin-top: -8px;">
        <p>Tanggal <?php echo (@$d_start) ?> sampai <?php echo (@$d_end) ?></p>
    </h4>
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
        <?php 
        foreach($items as $item):
        ?>
        <tr>
            <td colspan="5">
                <table class="innerTable">
                    <tbody>
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td><?php echo convert_date(@$item->tanggal) ?></td>
                            <td>Gudang</td>
                            <td>:</td>
                            <td><?=$item->warehouse->nama?></td>
                        </tr>
                        <tr>
                            <td>No. Bukti</td>
                            <td>:</td>
                            <td><?=$item->nobukti?></td>
                            <td>Keterangan</td>
                            <td>:</td>
                            <td><?=$item->keterangan?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>

        <?php foreach ($item->details as $no => $details): ?>
        <tr id="trow-<?php echo $details->id; ?>">
            <td><?php echo $no + 1; ?>.</td>
            <td><?php echo $details->good->kode; ?></td>
            <td><?php echo $details->good->nama; ?></td>
            <td><?php echo $details->unit->nama; ?></td>
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