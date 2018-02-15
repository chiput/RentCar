<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Pembatalan Reservasi",
  ]);

  
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3>LAPORAN PEMBATALAN RESERVASI</h3>
                <h4 style="margin-top: -8px;">
                    <span>Tanggal:
                        <?php echo date('d-m-Y', strtotime($range['start'])); ?>
                        s/d
                        <?php echo date('d-m-Y', strtotime($range['end'])); ?>
                    </span>
                </h4>
            <table class="report">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tgl. Batal</th>
                        <th>Tgl. Reservasi</th>
                        <th>No. Reservasi</th>
                        <th>Tamu</th>
                        <th>Agent</th>
                        <th>No. Kamar</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Deposit</th>
                        <th>User</th>
                        <th>Jam</th>
                    </tr>
                </thead>

            <?php
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
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo convert_date(substr($reservation->tanggal,0,10)); ?></td>
                    <td><?php echo convert_date(substr($reservation->tanggal,0,10)); ?></td>
                    <td><?php echo $reservation->nobukti; ?></td>
                    <td><?php echo @$reservation->guest->name; ?></td>
                    <td><?php echo @$reservation->agent->name; ?></td>
                    <td>
                        <?php
                            foreach ($reservation->details as $detail) {
                                echo @$detail->room->number." ";
                            }
                         ?>
                    </td>
                    <td><?php echo convert_date(substr($reservation->checkin,0,10)); ?></td>
                    <td><?php echo convert_date(substr($reservation->checkout,0,10)); ?></td>
                    <td><?php 
                        $tot=0;
                        foreach ($reservation->deposits as $deposit) {
                            $tot+=$deposit->nominal;
                        }
                        echo $this->convert($tot);
                    ?></td>
                    <td><?php echo $reservation->user->name; ?></td>
                    <td><?php echo convert_date(substr($reservation->updated_at,0,10))." ".substr($reservation->updated_at,10,18); ?></td>
                </tr>
                <?php $no++; ?>
                <?php endforeach; ?>
            </tbody>
            <?php
            ?>
            </table>
        </div>
    </div>
</div>