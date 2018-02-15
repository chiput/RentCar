<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Tipe Status Mobil',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Tipe Status Mobil',
    'submain_location' => 'Tipe Status Mobil'
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
            <h3 class="box-title m-b-0">Status Mobil</h3>
            <p class="text-muted m-b-30">Data Status Mobil</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('room-status-type-add'); ?>" class="btn btn-primary">Tambah Status Mobil</a></p>
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>Kode</th>
                        <th>Keterangan</th>
                        <!-- <th>Ikon</th> -->
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($roomstatus as $roomstatus): ?>
                    <tr>
                        <td class="text-nowrap">
                            <a href="<?php echo $this->pathFor('room-status-type-update', ['id' => $roomstatus->id]) ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                            <!-- <a href="<?php echo $this->pathFor('room-status-type-delete', ['id' => $roomstatus->id]) ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a> -->
                        </td>
                        <td><?php echo $roomstatus->code; ?></td>
                        <td><?php echo $roomstatus->desc; ?></td>
                        <!-- <td>
                        <?php if (@$roomstatus->icon != ''): ?>
                            <img src="data:image/png;base64,<?=$roomstatus->icon?>" alt="<?=$roomstatus->code?>" title="<?=$roomstatus->code?>" />
                        <?php endif; ?>
                        </td> -->
                        <td>
                            <?php
                                $status = array( 0 => "Tidak Aktif", 1 => "Aktif");
                                foreach($status as $key => $value) {
                                    if ($roomstatus->status == $key) {
                                        $message = $value;
                                    }
                                }
                                echo $message;
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
