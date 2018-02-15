<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Gudang Stok",
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
    <h3>LAPORAN STOK GUDANG <?php if(@$gud>0){ echo strtoupper($gudangnya[0]->nama);} ?></h3>
        <h4 style="margin-top: -8px;">
            <p>Tanggal <?php echo convert_date(@$d_start) ?> sampai <?php echo convert_date(@$d_end) ?></p>
        </h4>
            <p>Barang yang tidak memiliki stok awal atau stok masuk maka tidak tampil di laporan</p>
    <table class="table table-bordered report" width="780">
        <thead>
            <tr>
                <th>Nama Barang </th>
                <th>Stok Awal</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Stok Akhir</th>
            </tr>
        </thead>
        <tbody>

        <?php 
        
        foreach($goods as $good):
        $total = isset($totals[$good->id])?$totals[$good->id]["total"]:"0";
        $totalakhir = $total;
        $masuk = 0;
        $keluar = 0;
            if(isset($reports[$good->id]))
            {
                foreach ($reports[$good->id] as $detail){$totalakhir += @$detail->kuantitas;}     
            }
            if($totalakhir>0)
            {  
                if(isset($reports[@$good->id]))
                {
                    $totalakhir = $total;
                    $masuk = 0;
                    $keluar = 0;
                    foreach ($reports[$good->id] as $detail): 
                        $detail->kuantitas>=0?$masuk += $detail->kuantitas:0;
                        $detail->kuantitas<0?$keluar += $detail->kuantitas*-1:0;
                        $totalakhir += $detail->kuantitas;
                    endforeach;            
                } //end isset 
                ?>
                <tr>
                    <td><?=$good->kode?> / <?=$good->nama?></td>
                    <td><?= $total; ?></td>
                    <td><?= $masuk?></td>
                    <td><?= $keluar?> </td>
                    <td align="right"><?= $totalakhir; ?></td>
                </tr>
                    
        <?php }//end if total > 0 ?>
    <?php endforeach; ?>

        </tbody>
    </table>
    <br />
<style>
    .innerTable td{
        border: none!important;
    }
</style>