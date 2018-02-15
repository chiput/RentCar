<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Data Gudang Restoran',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Restoran',
    'submain_location' => 'Gudang Restoran'
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
            <h3 class="box-title m-b-0">Gudang Restoran</h3>
            <p class="text-muted m-b-5">Data Gudang Restoran</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('gudang-new'); ?>" class="btn btn-primary">Tambah Gudang</a></p><br/>
  
            <table class="table table-striped myDataTable">
              <thead>
                    <tr>
                       
                        <th style="width: 10%;"></th>
                      <!--   <th style="width: 6%;">No</th> -->
                        <th style="width: 15%;">Gudang</th>
                        <th style="width: 15%;">Dapertemen</th>
                        
                        
                    </tr>
                </thead>
                <tbody>
                        <?php 
                        $i=1;
                        foreach ($gudangs as $gudang ) {
                           
                         ?>
                    <tr>
                        <td> 
                             <a href="<?php echo $this->pathFor('gudang-edit', ['id' => $gudang->id]); ?>" data-toggle="tooltip"   data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                            <a href="<?php echo $this->pathFor('gudang-delete', ['id' => $gudang->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                        </td>
                      <!--  <td><?php echo $i; ?></td> -->
                       <td><?php echo $gudang->nama; ?></td>
                       <td><?php echo $gudang->name; ?></td>
                      
                      
                    </tr> 
                    

                    <?php $i++; } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>



