 <?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Pembelian Store',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Store',
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
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('store-kasir-add'); ?>" class="btn btn-primary">Tambah Pembayaran</a></p>

            <table class="table table-striped myDataTable">
              <thead>
                    <tr>                       
                        <th></th>
                        <th>Tanggal</th>
                        <th>No Bukti</th>
                        <th>Total</th>
                        <th>User</th>
                        <th>User Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datas as $data ) { ?>
                    <tr>
                        <td> <a href="<?php echo $this->pathFor('store-kasir-edit', ['id' => $data->id]); ?>" data-toggle="tooltip"   data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                            <a href="<?php echo $this->pathFor('store-kasir-delete', ['id' => $data->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                        </td>
                        <td><?=convert_date($data->tanggal); ?></td>
                        <td><?=$data->nobukti; ?></td>
                        <td><?php echo $this->convert($data->total); ?></td>
                        <td><?= @$data->user->name?></td>
                        <td><?= @$data->user_edit->name?></td>
                    </tr> 
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



