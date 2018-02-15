<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Daftar Tamu",
  ]); 
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3>LAPORAN DAFTAR PELANGGAN</h3>
                <table class="table table-bordered report">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Kota</th>
                            <th>Perusahaan</th>
                            <th>Telepon</th>
                            <th>Fax</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($guests as $no => $guest): ?>
                        <tr id="trow-<?php echo $guest->id; ?>">
                            <td><?php echo $no + 1; ?>.</td>
                            <td><?php echo $guest->name; ?></td>
                            <td><?php echo $guest->address; ?></td>
                            <td><?php echo $guest->city; ?></td>
                            <td><?php echo @$guest->company->name; ?></td>
                            <td><?php echo $guest->phone; ?></td>
                            <td><?php echo $guest->fax; ?></td>
                            <td><?php echo $guest->email; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
       </div>
    </div>
</div>