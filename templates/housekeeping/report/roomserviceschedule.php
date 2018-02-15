<?php
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Jadwal Room Service",
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
            <h3>LAPORAN JADWAL ROOM SERVICE</h3>
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
                        <th>Karyawan</th>
                        <th>Kamar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=0; foreach ($menu as $menus): ?>
                      <tr>
                          <td><?php echo $no + 1; ?>.</td>
                          <td><?php echo date('d-m-Y', strtotime($menus->tanggal)) ; ?></td>
                          <td><?php echo @$menus->karyawanid ; ?></td>
                          <td><?php foreach ($menus->service as $detail): echo @$detail->room->number.', ' ; endforeach; ?></td>
                      </tr>
                  <?php $no++; endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
