 <?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Kasir Spa',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Spa',
    'submain_location' => 'Kasir'
  ]); 
   function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
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
            <h3 class="box-title m-b-0">Kasir </h3>
            <p class="text-muted m-b-30">Data Pembayaran Kasir</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('kasirspa-add'); ?>" class="btn btn-primary">Tambah Pembayaran</a></p>

            <table class="table table-striped myDataTable">
              <thead>
                    <tr>
                        <th></th>
                        <th>Tanggal</th>
                        <th>No Bukti</th>
                        <th>Pelanggan</th>
                        <th>Pax</th>
                        <th>Total</th>
                        <th>User</th>
                        <th>User Edit</th>   
                    </tr>
                </thead>
                <tbody>
                  <?php
                      $i=1;
                         foreach ($Kasir as $kasir ) {?>
                    <tr>
                      <td> <a href="<?php echo $this->pathFor('kasirspa-edit', ['id' => $kasir->id]); ?>" data-toggle="tooltip"   data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                          <a href="<?php echo $this->pathFor('kasirspa-delete', ['id' => $kasir->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                      </td>
                       <td><?=convert_date($kasir->tanggal); ?></td>
                       <td><?=$kasir->nobukti; ?></td>
                       <td><?php echo $kasir->namapelanggan; ?></td>
                       <td><?php echo $kasir->pax; ?></td>
                       <td><?php echo $this->convert($kasir->total); ?></td>
                       <td><?=@$kasir->user->name?></td>
                       <td><?=@$kasir->user_edit->name?></td>
                    </tr> 
                    <?php $i++; } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>