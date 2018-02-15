<?php
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Jadwal Room Service",
  ]);
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
<h3>JADWAL ROOM SERVICE</h3>
<table class="report">
    <thead>
        <tr>
            <th>No.</th>
            <th>Tanggal</th>
            <th>Karyawan</th>
            <th>Kamar</th>
        </tr>
    </thead>
    <tbody>
          <tr>
              <td><?php echo @$menu->id; ?>.</td>
              <td><?php echo convert_date(@$menu->tanggal); ?></td>
              <td><?php echo @$menu->karyawanid; ?></td>
              <td><?php foreach ($menu->service as $detail): echo @$detail->room->number.', ' ; endforeach; ?></td>
          </tr>
    </tbody>
</table>
