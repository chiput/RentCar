<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Daftar Mobil",
  ]); 
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3>LAPORAN DAFTAR MOBIL</h3>
                <table class="table table-bordered report">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Plat Nomor</th>
                                <th>Atas Nama</th>
                                <th>Nama Mobil</th>
                                <th>Jenis Mobil</th>
                                <!-- <th>Dewasa</th>
                                <th>Anak anak</th>
                                <th>Fasilitas</th>
                                <th>Deskripsi</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rooms as $no => $room): ?>
                            <tr id="trow-<?php echo $room->id; ?>">
                                <td><?php echo $no + 1; ?>.</td>
                                <td><?php echo $room->level; ?></td>
                                <td><?php echo $room->note; ?></td>
                                <td><?php echo $room->number; ?></td>
                                <td><?php echo $room->roomType->name; ?></td>
                                <!-- <td><?php echo $room->adults; ?></td>
                                <td><?php echo $room->children; ?></td>
                                <td><?php 
                                    ob_start();
                                    foreach ($room->relfacilities as $key):
                                        echo $key->name.', ';
                                    endforeach; 
                                    $output = ob_get_clean();
                                    echo rtrim($output, ', ');
                                    ?>
                                </td>
                                <td><?php 
                                    ob_start();
                                    foreach ($room->descriptions as $room_description): 
                                        echo $room_description->name.', ';
                                    endforeach;
                                    $output = ob_get_clean();
                                    echo rtrim($output, ', ');
                                    ?>
                                </td> -->
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
       </div>
    </div>
</div>