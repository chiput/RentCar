<?php 
    $this->layout('layouts/print', [
        // app profile
        'company' => $options,
        'title' => "Laporan Reservasi",
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
            <h3>LAPORAN RESERVATION</h3>
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
                        <th>Tanggal <br>Reservasi</th>
                        <th>No <br>Reservasi</th>
                        <th>Pelanggan</th>
                        <th>Sopir</th>
                        <!-- <th>No. Kontrak</th> -->
                        <th>Nama Mobil</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservationDetails as $no => $reservationDetail): ?>
                    <tr id="trow-<?php echo $room->id; ?>">
                        <td><?php echo $no + 1; ?>.</td>
                        <td><?php echo date('d-m-Y', strtotime($reservationDetail->reservation->tanggal)); ?></td>
                        <td><?php echo @$reservationDetail->reservation->nobukti; ?></td>
                        <td><?php echo @$reservationDetail->reservation->guest->name; ?></td>
                        <td><?php echo @$reservationDetail->reservation->agent->name; ?></td>
                        <!-- <td>&nbsp;</td> -->
                        <td><?php echo @$reservationDetail->room->number; ?></td>
                        <td><?php echo convert_date(substr(@$reservationDetail->reservation->checkin,0,10)); ?></td>
                        <td><?php echo convert_date(substr(@$reservationDetail->reservation->checkout,0,10)); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>