<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Jenis Tempat Tidur',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Setup',
    'submain_location' => 'Jenis Tempat Tidur'
  ]); 

    $activeStatus = [
        'Tidak Aktif',
        'Aktif'
    ];

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
            <h3 class="box-title m-b-0">Jenis Tempat Tidur </h3>
            <p class="text-muted m-b-30">Data Jenis Tempat Tidur</p>
            <p class="text-muted m-b-20">
                <a href="<?php echo $this->pathFor('setup-bed-type-new'); ?>" class="btn btn-primary">Tambah Jenis Tempat Tidur</a>
            </p>
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th>

                        </th>
                        <th>Nama</th>
                        <!-- <th>Aktif</th> -->
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($bed_types as $bed_type): ?>
                    <tr>
                        <td>
                            <a href="<?php echo $this->pathFor('setup-bed-type-update', ['id' => $bed_type->id]); ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                            <a href="<?php echo $this->pathFor('setup-bed-type-delete', ['id' => $bed_type->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>
                        </td>
                        <td><?php echo $bed_type->name; ?></td>
                        <!-- <td><?php //echo $activeStatus[$bed_type->is_active] ?></td> -->
                    </tr>
                <?php endforeach; ?>
                <tbody>
            </table>
        </div>
    </div>
</div>
