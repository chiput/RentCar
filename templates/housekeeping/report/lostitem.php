<?php
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Barang Hilang",
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
            <h3>LAPORAN BARANG HILANG</h3>
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
                        <th>Barang</th>
                        <th>No. Kamar</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($menu as $no => $menus): ?>
                    <tr>
                        <td><?php echo $no + 1; ?>.</td>
                        <td><?php echo date('d-m-Y', strtotime($menus->tanggal)); ?></td>
                        <td><?php echo @$menus->nobukti; ?></td>
                        <td><?php echo @$menus->barangid; ?></td>
                        <td><?php echo @$menus->roomnya->number; ?></td>
                        <td><?php echo @$menus->keterangan; ?></td>
                        <td><?php if(($menus->aktif)==1){ echo 'Belum Ditemukan'; }else{ echo 'Sudah Ditemukan';} ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
