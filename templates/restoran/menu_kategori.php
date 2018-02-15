<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Menu Kategori',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Restoran',
    'submain_location' => 'Menu Kategori'
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
            <h3 class="box-title m-b-0">Menu Kategori</h3>
            <p class="text-muted m-b-30">Data Menu Kategori</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('menukategori-add'); ?>" class="btn btn-primary">Tambah Kategori</a></p>
<?php //echo var_dump($menu_kategoris)?>  
            <table class="table table-striped myDataTable">
              <thead>
                    <tr>
                       
                        <th style="width: 10%;"></th>
                        <!-- <th style="width: 6%;">No</th> -->
                        <th style="width: 15%;">Kode</th>
                        <th>Nama</th>
                        <th style="width: 15%;">Status</th>
                        
                        
                    </tr>
                </thead>
                <tbody>
                        <?php 
                        $i=1;
                        foreach ($menu_kategoris as $menu_kategori ) {
                           
                         ?>
                    <tr>
                        <td> 
                             <a href="<?php echo $this->pathFor('menukategori-edit', ['id' => $menu_kategori->id]); ?>" data-toggle="tooltip"   data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                            <a href="<?php echo $this->pathFor('menukategori-delete', ['id' => $menu_kategori->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                        </td>
                       <!-- <td><?php echo $i; ?></td> -->
                       <td><?php echo $menu_kategori->kode; ?></td>
                       <td><?php echo $menu_kategori->nama; ?></td>
                       <td><?php if($menu_kategori->is_active=='1'){echo "Aktif";}else{echo "Tidak Aktif";} ?></td>
                      
                    </tr> 
                    

                    <?php $i++; } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>



