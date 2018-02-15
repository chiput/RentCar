<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Fasilitas Kamar',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Setup',
    'submain_location' => 'Daftar Fasilitas Kamar'
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
            <h3 class="box-title m-b-0">Fasilitas Kamar </h3>
            <p class="text-muted m-b-30">Data Fasilitas Kamar</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('setup-room-facility-new'); ?>" class="btn btn-primary">Tambah Fasilitas Kamar</a></p>
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
                <?php foreach ($room_facilities as $room_facility): ?>
                    <tr>
                        <td>
                            <a href="<?php echo $this->pathFor('setup-room-facility-update', ['id' => $room_facility->id]); ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                            <a href="<?php echo $this->pathFor('setup-room-facility-delete', ['id' => $room_facility->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>
                        </td>
                        <td><?php echo $room_facility->name; ?></td>
                        <!-- <td><?php //echo $activeStatus[$room_facility->is_active] ?></td> -->
                    </tr>
                <?php endforeach; ?>
                <tbody>
            </table>
        </div>
    </div>
</div>
