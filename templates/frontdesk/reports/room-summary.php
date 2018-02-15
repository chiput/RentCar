<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Rekapitulasi Kamar",
  ]); 
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3>LAPORAN REKAPITULASI KAMAR</h3>
                <table class="table table-bordered report">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Jenis Kamar</th>
                            <th>Jumlah</th>
                            <th>Terisi</th>
                            <th>Reservasi</th>
                            <th>Kosong</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($room_types as $no => $room_type): ?>
                        <tr id="trow-<?php echo $room->id; ?>">
                            <td><?php echo $no + 1; ?>.</td>
                            <td><?php echo $room_type->name; ?></td>
                            <td><?php echo $room_type->rooms->count(); ?></td>
                            <td><?php
                                $rooms = $room_type->rooms;
                                $occupied = 0;
                                foreach ($rooms as $room) {
                                    $cc = $room->reservationDetails()->where('checkin_at', '!=', null)
                                            ->where('checkout_at', null)
                                            ->get();
                                    $occupied += $cc->count();
                                }
                                echo $occupied;
                            ?></td>
                            <td><?php
                                $rooms = $room_type->rooms;
                                $reserved = 0;
                                foreach ($rooms as $room) {
                                    $cc = $room->reservationDetails()->where('checkin_at', null)
                                            ->where('checkout_at', null)
                                            ->get();
                                    $reserved += $cc->count();
                                }
                                echo $reserved;
                            ?></td>
                            <td>
                                <?php echo $room_type->rooms->count() - $occupied; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</center>