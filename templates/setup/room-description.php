<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Deskripsi Kamar',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Setup',
    'submain_location' => 'Daftar Deskripsi Kamar'
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
            <h3 class="box-title m-b-0">Deskripsi Kamar </h3>
            <p class="text-muted m-b-30">Data Deskripsi Kamar</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('setup-room-description-new'); ?>" class="btn btn-primary">Tambah Deskripsi Kamar</a></p>
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
                <?php foreach ($room_descriptions as $room_description): ?>
                    <tr>
                        <td>
                            <a href="<?php echo $this->pathFor('setup-room-description-update', ['id' => $room_description->id]); ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                            <a href="<?php echo $this->pathFor('setup-room-description-delete', ['id' => $room_description->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>
                        </td>
                        <td><?php echo $room_description->name; ?></td>
                        <!-- <td><?php //echo $room_description[$room_description->is_active] ?></td> -->
                    </tr>
                <?php endforeach; ?>
                <tbody>
            </table>
        </div>
    </div>
</div>
