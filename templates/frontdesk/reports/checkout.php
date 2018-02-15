<?php 
    $this->layout('layouts/print', [
        // app profile
        'company' => $options,
        'title' => "Pengembalian",
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
            <h3>LAPORAN PENGEMBALIAN</h3>
                <h4 style="margin-top: -8px;">
                    <span>Tanggal:
                        <?php echo date('d-m-Y', strtotime($range['start'])); ?>
                        s/d
                        <?php echo date('d-m-Y', strtotime($range['end'])); ?>
                    </span>
                </h4>    
            <table class="table table-bordered report">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>No Bukti</th>
                        <th>Nama Mobil</th>
                        <th>Plat Nomor</th>
                        <th>No Pengambilan</th>
                        <th>Pelanggan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($checkouts as $no => $checkout): ?>
                    <tr id="trow-<?php echo $checkout->id; ?>">
                        <td><?php echo $no + 1; ?>.</td>
                        <td><?php echo date('d-m-Y H:m:i', strtotime($checkout->checkout_time)); ?></td>
                        <td><?php echo $checkout->checkout_code; ?></td>
                        <td><?php echo $checkout->room_number; ?></td>
                        <td><?php echo $checkout->plat_number; ?></td>
                        <td><?php echo $checkout->nobukti; ?></td>
                        <td><?php echo $checkout->guest_name; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>   