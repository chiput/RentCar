 <?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Layanan',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Spa',
    'submain_location' => 'Layanan'
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
            <h3 class="box-title m-b-0">Layanan SPA</h3>
            <p class="text-muted m-b-30">Data Layanan Spa</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('spa-layanan-new'); ?>" class="btn btn-primary">Tambah Layanan</a></p>

            <table class="table table-striped myDataTable">
              <thead>
                    <tr>
                        <th></th>
                       <!--  <th>No</th> -->
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <!-- <th>Biaya Lain</th> -->
                        <th>Harga Jual</th>
                        <th>Diskon</th>
                        <th>Aktif</th>  
                    </tr>
                </thead>
                <tbody>
                        <?php
                        $i=1;
                         foreach ($Layanan as $layanan ) {
                           
                         ?>
                    <tr>
                            <td> <a href="<?php echo $this->pathFor('spa-layanan-edit', ['id' => $layanan->id]); ?>" data-toggle="tooltip"   data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                                <a href="<?php echo $this->pathFor('spa-layanan-delete', ['id' => $layanan->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                            </td>
                           
                       <!-- <td><?=$i; ?></td> -->
                       <td><?=$layanan->kode; ?></td>
                       <td><?=$layanan->nama_layanan; ?></td>
                       <td><?=$layanan->namakategori; ?></td>
                       <!-- <td><?php //echo $this->convert($layanan->biayalain); ?></td> -->
                       <td><?php echo $this->convert($layanan->hargajual); ?></td>
                       <td><?=$layanan->diskon?> %</td>
                       <td><?php if($layanan->aktif=='1'){echo "Aktif";}else{echo "Tidak Aktif";} ?></td>

                    </tr> 
                    

                    <?php $i++; } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>



