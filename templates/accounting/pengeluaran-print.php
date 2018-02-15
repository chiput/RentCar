<?php 
    $this->layout('layouts/print', [
        // app profile
        'company' => $options,
        'title' => "Laba Rugi - Pengeluaran",
    ]); 
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
            <h3>LAPORAN LABA & RUGI PENGELUARAN</h3>
                <h4 style="margin-top: -8px;">
                    <span>Tanggal:
                        <?php echo date('d-m-Y', strtotime($range['start'])); ?>
                        s/d
                        <?php echo date('d-m-Y', strtotime($range['end'])); ?>
                    </span>
                </h4>
                <table class="table table-bordered report" width="100%">
                    <thead>
                        <tr>
                            <th>No. Account</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach ($data as $data) { 
                            if($data->nominal != 0){?>
                            <tr>
                                <td><?= $data->jurname?></td>
                                <td><?php echo 'Rp. '. $this->convert($data->nominal)?></td>
                            </tr>
                        <?php } 
                        $total += $data->nominal;
                        } ?>
                        <tr>
                            <td><strong>Total Pengeluaran</strong></td>
                            <td>Rp. <?= $this->convert($total)?></td>
                        </tr>
                    </tbody>
            </table>
        </div>
    </div>
</div>