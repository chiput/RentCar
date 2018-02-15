<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Penjualan Restoran",
  ]); 
?>
<div class="row">
    <div class="col-sm-12">
        <h3>LAPORAN PENJUALAN MENU</h3>
        <p>Tanggal <strong><?php echo (@$start) ?></strong> sampai <strong><?php echo (@$end) ?></strong></p>
        <div class="white-box">
            <table class="table table-bordered report">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Menu</th>
                        <th>Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no=1; foreach ($menus as  $menu): ?>
                    <tr>
                        <td><?php echo $no; ?>.</td>
                        <td><?php echo $menu->nama; ?></td>
                        <td><?php echo "Rp. ".$this->convert($menu->total); ?></td>
                    </tr>
                <?php $no++; endforeach; ?>
                </tbody>              
            </table>
        </div>
    </div>
</div>
