<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Daftar Supplier",
  ]); 
?>
<h3>DAFTAR SUPPLIER</h3>
<table class="table table-bordered report">
    <thead>
        <tr>
            <th>No.</th>
            <th>Kode Supplier</th>
            <th>Nama Supplier</th>
            <th>Contact Person</th>
            <th>Alamat</th>
            <th>Telepon</th>
        </tr>
    </thead>
    <tbody>
     <?php 
     $i=1;
     foreach($suppliers as $supplier){ ?>
        <tr>
            <td><?=$i?></td>
            <td><?=$supplier->kode?></td>
            <td><?=$supplier->nama?></td>
            <td><?=$supplier->contact?></td>
            <td><?=$supplier->alamat?></td>
            <td><?=$supplier->telepon?></td>
        </tr>
    <?php 
    $i++;
    } ?>
        
    </tbody>
</table>
<br/>