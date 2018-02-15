<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Daftar Terapis",
  ]); 
?>
<div class="row">
    <div class="col-sm-12">
        <?php if(isset($start)){ ?>
            <h3>LAPORAN KINERJA TERAPIS</h3>
        <?php } else { ?>
            <h3>LAPORAN DAFTAR TERAPIS</h3>
        <?php } ?>
        <div class="white-box">
        <?php 
        // jika ada args start maka tampilan terapis kinerja jika tidak maka tampil daftar terapis
        if(isset($start)){ ?>
                <table class="table table-bordered report">
                        <thead>
                            <tr>
                                <th style="width: 2%;">No.</th>
                                <th style="width: 30%;">Nama Terapis</th>
                                <th>Kuantitas</th>
                                <th style="width: 30%;">Penjualan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach ($kinerjaterapis as  $kinerja): ?>
                                <tr id="trow-<?php echo $kinerja->id; ?>">
                                    <td><?php echo $no; ?>.</td>
                                    <td><?php echo $kinerja->terapis->nama; ?></td>
                                    <td><?php echo $kinerja->kuantitas; ?></td>
                                    <td><?php echo $this->convert($kinerja->harga); ?></td>
                                </tr>
                            <?php $no++; endforeach; ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                <table class="table table-bordered report">
                    <thead>
                        <tr>
                            <th style="width: 2%;">No.</th>
                            <th style="width: 30%;">Nama Terapis</th>
                            <th>Alamat</th>
                            <th style="width: 30%;">No. Telepon</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach ($terapis as  $terapis): ?>
                        <tr id="trow-<?php echo $terapis->id; ?>">
                            <td><?php echo $no; ?>.</td>
                            <td><?php echo $terapis->nama; ?></td>
                            <td><?php echo $terapis->alamat; ?></td>
                            <td><?php echo $terapis->telepon; ?></td>
                        </tr>
                        <?php $no++; endforeach; ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </div>
</div>
