<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Pemakaian Barang",
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
<h3>LAPORAN PEMAKAIAN BARANG</h3>
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
        foreach($usages as $usage):
            foreach ($usage->details as $no => $details):
                $ada = @$details->kuantitas;
            endforeach;
            if (isset($ada)){
        ?>
        <tr>
            <td colspan="5">
                <table class="innerTable">
                    <tbody>
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td><?php echo convert_date(@$usage->tanggal) ?></td>
                            <td>Gudang</td>
                            <td>:</td>
                            <td><?=$usage->warehouse->nama?></td>
                        </tr>
                        <tr>
                            <td>No. Bukti</td>
                            <td>:</td>
                            <td><?=$usage->nobukti?></td>
                            <td>Keterangan</td>
                            <td>:</td>
                            <td><?=$usage->keterangan?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>

        <?php foreach ($usage->details as $no => $details): ?>
        <tr id="trow-<?php echo $details->id; ?>">
            <td><?php echo $no + 1; ?>.</td>
            <td><?php echo @$details->good->kode; ?></td>
            <td><?php echo @$details->good->nama; ?></td>
            <td><?php echo @$details->unit->nama; ?></td>
            <td align="right"><?php echo $details->kuantitas; ?></td>
        </tr>
        <?php endforeach; ?>
        <?php } ?>
        <?php endforeach; ?>
    </tbody>
</table>
<br />

<style>
    .innerTable td{
        border: none!important;
    }
</style>