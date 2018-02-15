<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Barang Store',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Store',
    'submain_location' => 'Barang'
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
            <h3 class="box-title m-b-0">Barang</h3>
            <p class="text-muted m-b-30">Data Barang Store</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('store-barang-add'); ?>" class="btn btn-primary">Tambah Barang</a></p><?php //echo var_dump($menu_kategoris)?>  
            <table class="table table-striped myDataTable">
              <thead>
                    <tr>
                       
                        <th style="width: 10%;"></th>
                        <!-- <th style="width: 6%;">No</th> -->
                        <th>Nama</th>
                        <th>Harga</th>
                        
                        
                    </tr>
                </thead>
                <tbody>
                        <?php 
                        $i=1;
                        foreach ($barang as $barang ) {
                           
                         ?>
                    <tr>
                        <td> 
                             <a href="<?php echo $this->pathFor('store-barang-edit', ['id' => $barang->id]); ?>" data-toggle="tooltip"   data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                            <a href="<?php echo $this->pathFor('store-barang-delete', ['id' => $barang->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                        </td>
                       <!-- <td><?php echo $i; ?></td> -->
                       <td><?php echo $barang->detail->nama; ?></td>
                       <td><?=$this->convert($barang->harga); ?></td>                      
                    </tr> 
                    

                    <?php $i++; } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>



