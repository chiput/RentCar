<?php 
    $this->layout('layouts/print', [
        // app profile
        'company' => $options,
        'title' => "Laba Rugi - Pendapatan",
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
            <h3>LAPORAN LABA & RUGI || PENDAPATAN || CHECKOUT</h3>
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
            </table>
        </div>
    </div>
</div>