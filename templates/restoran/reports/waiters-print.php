<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Daftar Waiter",
  ]); 
?>
<div class="row">
    <div class="col-sm-12">
        <?php if(isset($start)){ ?>
            <h3>LAPORAN KINERJA WAITER</h3>
        <?php } else { ?>
            <h3>LAPORAN DAFTAR WAITER</h3>
        <?php } ?>
        <div class="white-box">
            <?php 
            // jika ada args start maka tampilan waiter kinerja jika tidak maka tampil daftar waiter
            if(isset($start)){ ?>
                <table class="table table-bordered report">
                    <thead>
                        <tr>
                            <th style="width: 2%;">No.</th>
                            <th style="width: 30%;">Nama Waiter</th>
                            <th>Kuantitas</th>
                            <th style="width: 30%;">Penjualan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach ($kinerja as  $waiter): ?>
                            <tr id="trow-<?php echo $waiter->id; ?>">
                                <td><?php echo $no; ?>.</td>
                                <td><?php echo $waiter->waiter->nama; ?></td>
                                <td><?php echo $waiter->kuantitas; ?></td>
                                <td><?php echo "Rp. ".$this->convert($waiter->total); ?></td>
                            </tr>
                        <?php $no++; endforeach; ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <table class="table table-bordered report">
                    <thead>
                        <tr>
                            <th style="width: 2%;">No.</th>
                            <th style="width: 30%;">Nama Waiter</th>
                            <th>Alamat</th>
                            <th style="width: 30%;">No. Telepon</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach ($waiters as  $waiter): ?>
                            <tr id="trow-<?php echo $waiter->id; ?>">
                                <td><?php echo $no; ?>.</td>
                                <td><?php echo $waiter->nama; ?></td>
                                <td><?php echo $waiter->alamat; ?></td>
                                <td><?php echo $waiter->telepon; ?></td>
                            </tr>
                        <?php $no++; endforeach; ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </div>
</div>