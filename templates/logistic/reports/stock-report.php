<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Stok",
  ]); 
  $no = 1;
$months = ['januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember'];?>
<pre>
<?php 
// foreach($categories as $cat):
//     foreach($cat->goods as $good){
//         var_dump($good); 
//     }
// endforeach;
//                     ?>
</pre>
    <h3>LAPORAN STOK</h3>
        <h4 style="margin-top: -8px;">
            Periode&nbsp<?=$months[$month-1]?> <?=$year?></p>
            <?=@$warehouse->nama!=''?'Gudang : ':''?><?=@$warehouse->nama?>
        </h4>
    <table class="table table-bordered report" width="780">
        <thead>
            <tr>
                <th>No.</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Satuan</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach($categories as $cat):
                foreach($cat->goods as $good){
                    if($barang_id==0 ||($barang_id!=0 && $good->id==$barang_id)){
                        if(isset($totals[$good->id]["total"])){
                            $ada[$cat->id] = $totals[$good->id]["total"];
                        }
                    }//end kondisi
                }
                if(isset($ada[$cat->id])){
            ?>
                    <tr>
                        <td colspan="5">
                            <table class="innerTable">
                                <tbody>
                                    <tr>
                                        <td>Kategori</td>
                                        <td>:</td>
                                        <td><?=$cat->nama?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <?php 
                    $n=1;
                    foreach($cat->goods as $good):
                        if($barang_id==0 ||($barang_id!=0 && $good->id==$barang_id)){
                            if(isset($totals[$good->id]["total"])){
                        ?>
                        <tr>
                            <td><?=$n++?></td>
                            <td><?=$good->kode?></td>
                            <td><?=$good->nama?></td>
                            <td><?=$good->unit->nama?></td>
                            <td><?=$totals[$good->id]["total"]?></td>
                        </tr>
                        <?php 
                            }
                        }
                    endforeach; 
                }//end validasi if ada data total ?>
        <?php endforeach; ?>
        </tbody>
    </table>
<br />
<style>
    .innerTable td{
        border: none!important;
    }
</style>