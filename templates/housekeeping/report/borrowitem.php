<?php
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Peminjaman Barang",
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
            <h3>LAPORAN PEMINJAMAN BARANG</h3>
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
                        <th>Pinjam</th>
                        <th>Kembali</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $jumpinjam=0; $jumlahkembali=0; foreach ($menu as $no => $menus): ?>
                    <tr>
                        <td><?php echo $no + 1; ?>.</td>
                        <td><?php echo date('d-m-Y', strtotime($menus->tanggal)); ?></td>
                        <td><?php echo @$menus->nobukti; ?></td>
                        <td><?php echo @$menus->barangid; ?></td>
                        <td><?php echo @$menus->room->room->number; ?></td>
                        <td><?php echo @$menus->keterangan; ?></td>
                        <td><?php echo @$menus->kuantitas; ?></td>
                        <td><?php if(@$menus->kuantitaskembali==''){ echo 0;}else{ echo @$menus->kuantitaskembali; } ?></td>
                    </tr>
                    <?php $jumpinjam+=$menus->kuantitas; $jumlahkembali+=$menus->kuantitaskembali; endforeach; ?>
                    <tr>
                      <td colspan="6">Total</td>
                      <td><?php echo @$jumpinjam; ?></td>
                      <td><?php echo @$jumlahkembali; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>