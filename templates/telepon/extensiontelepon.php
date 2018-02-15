<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Extension Telepon',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Management',
    'submain_location' => 'Extension Telepon'
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
            <h3 class="box-title m-b-0">Extention Telepon</h3>
            <p class="text-muted m-b-30">Data Extention Telepon</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('telpextention-new'); ?>" class="btn btn-primary">Tambah Extension Telepon</a></p>
            
            <table class="table table-striped myDataTable" id='myTable'>
              <thead>
                    <tr>
                        <th style="width: 15%;"></th>
                        <th style="width: 15%;">Extension Nomer</th>
                        <th style="width: 15%;">Kamar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $i=1;foreach ($extions as $extion ) { ?>
                            <tr>
                                <td> 
                                    <a href="<?php echo $this->pathFor('telpextention-edit', ['id' => $extion->id]); ?>" data-toggle="tooltip"   data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                                    <a href="<?php echo $this->pathFor('telpextention-delete', ['id' => $extion->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                                </td>
                               <td><?php echo $extion->extno; ?></td>
                               <td><?php echo $extion->roomid; ?></td>
                            </tr> 
                    <?php $i++; } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>


