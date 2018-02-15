<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Jenis Biaya',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Frontdesk',
    'submain_location' => 'Jenis Biaya'
  ]);

    $activeStatus = [
        'Tidak Aktif',
        'Aktif'
    ];

?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Jenis Biaya Tambahan</h3>
            <p class="text-muted m-b-30">Data Jenis Biaya Tambahan</p>
            <p>
                <a href="<?php echo $this->pathFor('frontdesk-addchargetype-new'); ?>" class="btn btn-primary">Tambah Jenis Biaya</a>
            </p>
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th>

                        </th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Acc. Pendapatan</th>
                        <!-- <th>Acc. Biaya</th> -->
                        <!-- <th>Status</th> -->
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($types as $type): ?>
                    <tr>
                        <td>
                            <a href="<?php echo $this->pathFor('frontdesk-addchargetype-update', ['id' => $type->id]); ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                            <a href="<?php echo $this->pathFor('frontdesk-addchargetype-delete', ['id' => $type->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>
                        </td>
                        <td><?php echo $type->code; ?></td>
                        <td><?php echo $type->name; ?></td>
                        <td><?php echo @$type->acc_income->code." | ".@$type->acc_income->name; ?></td>
                        <!-- <td><?php echo @$type->acc_cost->code." | ".@$type->acc_cost->name; ?></td> -->
                        <td>Rp. <?=$this->convert($type->sell)?></td>
                        <!-- <td><?php //echo $activeStatus[$type->is_active] ?></td> -->
                    </tr>
                <?php endforeach; ?>
                <tbody>
            </table>
        </div>
    </div>
</div>
