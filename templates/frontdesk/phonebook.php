<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Phone Book',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'FrontDesk',
    'submain_location' => 'Phonebook'
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
            <h3 class="box-title m-b-0">Phone Book</h3>
            <p class="text-muted m-b-30">Data Phone Book</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('phonebook-new'); ?>" class="btn btn-primary">Tambah Phone Book</a></p>
            <table class="table table-striped myDataTable" id='myTable'>
              <thead>
                    <tr>
                        <th style="width: 15%;"></th>
                        <th style="width: 15%;">Nama</th>
                        <th style="width: 15%;">Telepon</th>
                        <th style="width: 15%;">Keterangan</th>    
                    </tr>
                </thead>
                <tbody>
                        <?php 
                        $i=1;
                        foreach ($phonebook as $phonebooks ) {     
                         ?>
                    <tr>
                        <td> 
                             <a href="<?php echo $this->pathFor('phonebook-edit', ['id' => $phonebooks->id]); ?>" data-toggle="tooltip"   data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                            <a href="<?php echo $this->pathFor('phonebook-delete', ['id' => $phonebooks->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                        </td>
                    <!--    <td><?php echo $i; ?></td> -->

                       <td><?php echo $phonebooks->nama; ?></td>
                       <td><?php echo $phonebooks->telepon; ?></td>
                       <td><?php echo $phonebooks->keterangan; ?></td>   
                    </tr> 
                    <?php $i++; } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


