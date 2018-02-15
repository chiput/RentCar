<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Meja",
  ]); 
?>
<div class="row">
    <div class="col-sm-12">
        <h3>LAPORAN MEJA</h3>
        <div class="white-box">
            <table class="table table-bordered report">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. Meja</th>
                        <th>Kuantitas</th>
                        <th>Pax</th>
                        <th>Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no=1; foreach ($kinerja as  $waiter): ?>
                    <tr id="trow-<?php echo $waiter->id; ?>">
                        <td><?php echo $no; ?>.</td>
                        <td><?php echo $waiter->meja; ?></td>
                        <td><?php echo $waiter->kuantitas; ?></td>
                        <td><?php echo $waiter->pax; ?></td>
                        <td><?php echo "Rp. ".$this->convert($waiter->total); ?></td>
                    </tr>
                <?php $no++; endforeach; ?>
                </tbody>                           
            </table>
        </div>
    </div>
</div>