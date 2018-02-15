<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Supplier',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Supplier',
    'submain_location' => 'Supplier'
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
            <h3 class="box-title m-b-0">Supplier</h3>
            <p class="text-muted m-b-30">Data Supplier</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('pembelian-supplier-add'); ?>" class="btn btn-primary">Tambah Supplier</a></p>
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>Kode</th>
                        <th>Nama Supplier</th>
                        <th>Contact Person</th>
                        <th>Telepon</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($suppliers as $supplier): ?>
                    <tr>
                        <td class="text-nowrap">
                            <a href="<?php echo $this->pathFor('pembelian-supplier-update', ['id' => $supplier->id]) ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                            <a href="<?php echo $this->pathFor('pembelian-supplier-delete', ['id' => $supplier->id]) ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                        </td>
                        <td><?php echo $supplier->kode; ?></td>
                        <td><?php echo $supplier->nama; ?></td>
                        <td><?php echo $supplier->contact; ?></td>
                        <td><?php echo $supplier->telepon; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
