 <?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Menu',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Restoran',
    'submain_location' => 'Menu'
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
            <h3 class="box-title m-b-0">Menu </h3>
            <p class="text-muted m-b-30">Data Menu </p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('restoran-menu-new'); ?>" class="btn btn-primary">Tambah Menu</a></p>

            <table class="table table-striped myDataTable">
              <thead>
                    <tr>
                        <th></th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga Jual</th>
                        <th>Aktif</th>
                    </tr>
                </thead>
                <tbody>
                        <?php
                        $i=1;
                         foreach ($Menus as $menu ) {
                         ?>
                    <tr>
                            <td> <a href="<?php echo $this->pathFor('restoran-menu-edit', ['id' => $menu->id]); ?>" data-toggle="tooltip"   data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                                <a href="<?php echo $this->pathFor('restoran-menu-delete', ['id' => $menu->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                            </td>
                           
                       <!-- <td><?=$i; ?></td> -->
                       <td><?=$menu->kode; ?></td>
                       <td><?=$menu->nama; ?></td>
                       <td><?php echo $menu->namakategori; ?></td>
                       <td><?php echo $this->convert($menu->hargajual); ?></td>
                       <td><?php if($menu->aktif=='1'){echo "Aktif";}else{echo "Tidak Aktif";} ?></td>
                    </tr> 
                    <?php $i++; } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



