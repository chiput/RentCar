<?php 
    $this->layout('layouts/print', [
        // app profile
        'company' => $options,
        'title' => "Laporan Peminjaman",
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
            <h3>LAPORAN PEMINJAMAN</h3>
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
                        <th>Pelanggan</th>
                        <th>Alamat</th>
                        <th>Perusahaan</th>
                        <th>Kota/Negara</th>
                        <th>Nama Mobil</th>
                        <th>No Peminjaman</th>
                        <th>Pengembalian</th>
                        <th>Lama Hari</th>
                        <th>Sopir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($checkins as $no => $checkin): ?>
                    <tr id="trow-<?php echo $checkin->id; ?>">
                        <td><?php echo $no + 1; ?>.</td>
                        <td><?php echo convert_date(substr($checkin->checkin_at,0,10))." ".substr($checkin->checkin_at,11,18); ?></td>
                        <td><?php echo $checkin->checkin_code; ?></td>
                        <td><?php echo $checkin->reservation->guest->name; ?></td>
                        <td><?php echo $checkin->reservation->guest->address; ?></td>
                        <td><?php echo @$checkin->reservation->guest->company->name; ?></td>
                        <td><?php echo $checkin->reservation->guest->city; ?>/<?php echo $checkin->reservation->guest->country->nama; ?></td>
                        <td><?php echo $checkin->room->number;?> [<?php echo $checkin->room->level;?>]</td>
                        <td><?php echo $checkin->reservation->nobukti; ?></td>
                        <td><?php echo convert_date(substr($checkin->checkout_at,0,10))." ".substr($checkin->checkout_at,11,18); ?></td>
                        <td><?php

                            $dateDiff = function () use ($checkin){
                                $datetime1 = new \DateTime(@$checkin->checkin_at);
                                $datetime2 = new \DateTime(@$checkin->checkout_at);
                                $interval = $datetime1->diff($datetime2);
                                return $interval->format('%a');
                            };

                            echo @$checkin->checkout_at==""?0:@$dateDiff();


                        ?></td>
                        <td><?php echo @$checkin->reservation->agent->name?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>   