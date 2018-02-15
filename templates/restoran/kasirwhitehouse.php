 <?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Kasir',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Restoran',
    'submain_location' => 'Kasir'
  ]); 
?>

<?php if ($this->getSessionFlash('success')): ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('success'); ?>
</div>
<?php endif; ?>
 <?php
                function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
            ?>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Kasir</h3>
            <p class="text-muted m-b-30">Data Pembayaran Kasir</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('kasirwh-add'); ?>" class="btn btn-primary">Tambah Pembayaran</a></p>
            <table class="table table-striped myDataTable">
              <thead>
                    <tr>
                        <th></th>
                       <!--  <th>No</th> -->
                        <th>Tanggal</th>
                        <th>No Bukti</th>
                        <th>Meja</th>
                        <th>Pax</th>
                        <th>Total</th>  
                    </tr>
                </thead>
                <tbody>
                        <?php
                        $i=1;
                         foreach ($Menus as $menu ) {
                           
                         ?>
                    <tr>
                            <td> <a href="<?php echo $this->pathFor('kasirwh-edit', ['id' => $menu->id]); ?>" data-toggle="tooltip"   data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                                <a href="<?php echo $this->pathFor('kasirwh-delete', ['id' => $menu->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                            </td>
                           
                       <!-- <td><?=$i; ?></td> -->
                       <td><?=convert_date($menu->tanggal); ?></td>
                       <td><?=$menu->nobukti; ?></td>
                       <td><?php echo $menu->meja; ?></td>
                       <td><?php echo $menu->pax; ?></td>
                       <td><?php echo $this->convert($menu->total); ?></td>

                    </tr> 
                    

                    <?php $i++; } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>



