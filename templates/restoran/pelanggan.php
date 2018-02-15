<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Data Pelanggan',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Restoran',
    'submain_location' => 'Pelanggan'
  ]); 
?>

<?php if ($this->getSessionFlash('success')): ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('success'); ?>
</div>
<?php endif; ?>


<?php



 ?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Pelanggan</h3>
            <p class="text-muted m-b-30">Data Pelanggan</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('pelanggan-new'); ?>" class="btn btn-primary">Tambah Pelanggan</a></p>
            
            <table class="table table-striped myDataTable" id='myTable'>
              <thead>
                    <tr>
                        <th style="width: 10%;"></th>
                        <th>Kode Pelanggan</th>
                        <th>Nama Pelanggan</th>
                        <th style="width: 15%;">Telpon</th>
                    </tr>
                </thead>
                <tbody>
                        <?php 
                        $i=1;
                        foreach ($pelanggans as $pelanggan ) {
                         ?>
                    <tr>
                        <td> 
                             <a href="<?php echo $this->pathFor('pelanggan-edit', ['id' => $pelanggan->id]); ?>" data-toggle="tooltip"   data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                            <a href="<?php echo $this->pathFor('pelanggan-delete', ['id' => $pelanggan->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                        </td>
                       <td><?php echo $pelanggan->kode_pelanggan; ?></td>
                       <td><?php echo $pelanggan->nama; ?></td>
                       <td><?php echo $pelanggan->telepon; ?></td>
                    </tr> 
                    <?php $i++; } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


