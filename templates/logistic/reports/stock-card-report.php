<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Kartu Stok",
  ]); 
  $no = 1;
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
<pre>
<?php //print_r($goods); ?>
</pre>
    <h3>LAPORAN KARTU STOK</h3>
        <h4 style="margin-top: -8px;">
            <p>Tanggal <?php echo convert_date(@$d_start) ?> sampai <?php echo convert_date(@$d_end) ?></p>
                        <?=@$warehouse->nama!=''?'Gudang : ':''?><?=@$warehouse->nama?>
        </h4>
<table class="table table-bordered report" width="780">
    <thead>
        <tr>
            <th>No.</th>
            <th>Tanggal</th>
            <th>No. Bukti</th>
            <th>Keterangan</th>
            <th>Satuan</th>
            <th>Masuk</th>
            <th>Keluar</th>
            <th>Stok</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        foreach($goods as $good):
        $total = isset($totals[$good->id])?$totals[$good->id]["total"]:"0";
        $totalakhir = $total;
            if(isset($reports[$good->id]))
            {
                foreach ($reports[$good->id] as $detail){$totalakhir += @$detail->kuantitas;}     
            }
        if($totalakhir>0)
        {
        ?>
            <tr>
                <td colspan="8">
                    <table class="innerTable">
                        <tbody>
                            <tr>
                                <td>Barang</td>
                                <td>:</td>
                                <td><?=$good->kode?> / <?=$good->nama?></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="7" align="right">Stok Awal</td>
                <td align="right"><?php echo $total; ?></td>
            </tr>
            <?php    
            if(isset($reports[@$good->id]))
            {
                foreach ($reports[$good->id] as $detail): 
                $total += $detail->kuantitas;
                ?>
                <tr>
                    <td><?php echo $no++; ?>.</td>
                    <td><?php echo convert_date($detail->tanggal); ?></td>
                    <td><?php echo $detail->nobukti; ?></td>
                    <td><?php echo $detail->keterangan; ?></td>
                    <td><?php echo $detail->satuan; ?></td>
                    <td><?php echo ($detail->kuantitas>=0?$detail->kuantitas:0) ?></td>
                    <td><?php echo ($detail->kuantitas<0?$detail->kuantitas*-1:0) ?></td>
                    <td align="right"><?php echo $total; ?></td>
                </tr>
                <?php endforeach; 
            }
        }

        ?>
    <?php endforeach; ?>
    </tbody>
</table>
<br />

<style>
    .innerTable td{
        border: none!important;
    }
</style>