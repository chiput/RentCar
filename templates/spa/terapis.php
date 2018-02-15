<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Terapis',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Spa',
    'submain_location' => 'Terapis'
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
            <h3 class="box-title m-b-0">Terapis</h3>
            <p class="text-muted m-b-30">Data Terapis</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('terapis-new'); ?>" class="btn btn-primary">Tambah Terapis</a></p>
            
            <table class="table table-striped myDataTable" id='myTable'>
              <thead>
                    <tr>
                        <th style="width: 15%;"></th>
                        <th style="width: 15%;">Kode Terapis</th>
                        <th style="width: 15%;">Nama Terapis</th>
                        <th style="width: 15%;">Telepon</th>
                        <th style="width: 15%;">Alamat</th>
                        
                        
                    </tr>
                </thead>
                <tbody>
                        <?php 
                        $i=1;
                        foreach ($terapis as $terapi ) {
                           
                         ?>
                    <tr>
                        <td> 
                             <a href="<?php echo $this->pathFor('terapis-edit', ['id' => $terapi->id]); ?>" data-toggle="tooltip"   data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                            <a href="<?php echo $this->pathFor('terapis-delete', ['id' => $terapi->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                        </td>
                    <!--    <td><?php echo $i; ?></td> -->
                       <td><?php echo $terapi->kode; ?></td>
                       <td><?php echo $terapi->nama; ?></td>
                       <td><?php echo $terapi->telepon; ?></td>
                       <td><?php echo $terapi->alamat; ?></td>
                       
                      
                    </tr> 
                    

                    <?php $i++; } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>


