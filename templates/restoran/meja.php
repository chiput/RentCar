    <?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Data Meja',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Restoran',
    'submain_location' => 'Meja'
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
            <h3 class="box-title m-b-0">Meja</h3>
            <p class="text-muted m-b-30">Data Meja</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('meja-new'); ?>" class="btn btn-primary">Tambah Meja</a></p>
  
            <table class="table table-striped myDataTable">
              <thead>
                    <tr>                       
                        <th style="width: 10%;"></th>
                        <th>Kode Meja</th>
                        <th>Kapasitas Tamu</th>
                        <th>Tipe Meja</th>
                    </tr>
                </thead>
                <tbody>
                        <?php 
                        $i=1;
                        foreach ($mejas as $meja ) {
                           
                         ?>
                    <tr>
                        <td> 
                             <a href="<?php echo $this->pathFor('meja-edit', ['id' => $meja->id]); ?>" data-toggle="tooltip"   data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                            <a href="<?php echo $this->pathFor('meja-delete', ['id' => $meja->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                        </td>
                       <td><?php echo $meja->kode_meja; ?></td>
                       <td><?php echo $meja->max_tamu; ?></td>
                       <td><?php echo $meja->tipe_meja; ?></td>  
                    </tr> 
                    <?php $i++; } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



