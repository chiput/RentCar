<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Waiter',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Restoran',
    'submain_location' => 'Waiter'
  ]); 
?>

<?php if ($this->getSessionFlash('success')): ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('success'); ?>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Waiter</h3>
            <p class="text-muted m-b-30">Data Waiter</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('waiter-new'); ?>" class="btn btn-primary">Tambah Waiter</a></p>
            
            <table class="table table-striped myDataTable" id='myTable'>
              <thead>
                    <tr>
                        <th style="width: 15%;"></th>
                        <th style="width: 15%;">Kode Waiter</th>
                        <th style="width: 15%;">Nama Waiter</th>
                        <th style="width: 15%;">Telepon</th>
                        <th style="width: 15%;">Alamat</th>
                        
                        
                    </tr>
                </thead>
                <tbody>
                        <?php 
                        $i=1;
                        foreach ($waiters as $waiter ) {
                           
                         ?>
                    <tr>
                        <td> 
                             <a href="<?php echo $this->pathFor('waiter-edit', ['id' => $waiter->id]); ?>" data-toggle="tooltip"   data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                            <a href="<?php echo $this->pathFor('waiter-delete', ['id' => $waiter->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                        </td>
                    <!--    <td><?php echo $i; ?></td> -->
                       <td><?php echo $waiter->kode; ?></td>
                       <td><?php echo $waiter->nama; ?></td>
                       <td><?php echo $waiter->telepon; ?></td>
                       <td><?php echo $waiter->alamat; ?></td>
                       
                      
                    </tr> 
                    

                    <?php $i++; } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>


