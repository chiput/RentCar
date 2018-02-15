<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Jenis Mobil',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Setup',
    'submain_location' => 'Daftar Jenis Mobil'
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
            <h3 class="box-title m-b-0">Jenis Mobil </h3>
            <p class="text-muted m-b-30">Data Jenis Mobil</p>
            <p class="text-muted m-b-20">
                <a href="<?php echo $this->pathFor('setup-room-type-new'); ?>" class="btn btn-primary">Tambah Jenis Mobil</a>
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
                <?php foreach ($room_types as $room_type): ?>
                    <tr>
                        <td>
                            <a href="<?php echo $this->pathFor('setup-room-type-update', ['id' => $room_type->id]); ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                            <a href="<?php echo $this->pathFor('setup-room-type-delete', ['id' => $room_type->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>
                        </td>
                        <td><?php echo $room_type->name; ?></td>
                        <!-- <td><?php //echo $activeStatus[$room_type->is_active] ?></td> -->
                    </tr>
                <?php endforeach; ?>
                <tbody>
            </table>
        </div>
    </div>
</div>
