<?php 
    $this->layout('layouts/print', [
        // app profile
        'company' => $options,
        'title' => "Laporan Aktiva",
    ]);
        $no = 1;
        $months = ['januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember'];
    function convert_date($date){
        $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                }
            return $date;
    } 
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3>LAPORAN AKTIVA</h3>
                <h4 style="text-transform: capitalize; margin-top: -10px;">Periode&nbsp<?=$months[$month-1]?> <?=$year?>        
                </h4>
                <table class="table table-bordered report">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Kelompok</th>
                            <th>Tanggal</th>
                            <th>Umur</th>
                            <th>Harga Perolehan</th>
                            <th>Residu</th>
                            <th>Beban</th>
                            <th>Nilai Buku</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $i=1;
                    foreach ($aktivas as $aktiva) { 

                        ?>
                        <tr>
                            <th><?=$i++?></th>
                            <th><?=$aktiva->nama?></th>
                            <th><?=$aktiva->group_name?></th>
                            <th><?=convert_date($aktiva->tanggal)?></th>
                            <th><?=$aktiva->umur?></th>
                            <th><?=$this->convert($aktiva->harga)?></th>
                            <th><?=$this->convert($aktiva->residu)?></th>
                            <th><?=($aktiva->harga-$aktiva->residu)/$aktiva->umur/12;?></th>
                            <th><?=$this->convert($aktiva->harga-$aktiva->total)?></th>
                            <th><?=$aktiva->kondisi?></th>
                            
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>