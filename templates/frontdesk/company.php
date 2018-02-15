<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Perusahaan',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Frontdesk',
    'submain_location' => 'Perusahaan'
  ]);

    $activeStatus = [
        'Tidak Aktif',
        'Aktif'
    ];

?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Perusahaan </h3>
            <p class="text-muted m-b-30">Data Perusahaan</p>
            <p>
                <a href="<?php echo $this->pathFor('frontdesk-company-new'); ?>" class="btn btn-primary">Tambah Perusahaan</a>
            </p>
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th width="100">

                        </th>
                        <th>Nama</th>
                        <th>User</th>
                        <!-- <th>Aktif</th> -->
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($companies as $company): ?>
                    <tr>
                        <td>
                            <a href="<?php echo $this->pathFor('frontdesk-company-update', ['id' => $company->id]); ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                            <a href="<?php echo $this->pathFor('frontdesk-company-delete', ['id' => $company->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>
                        </td>
                        <td><?php echo $company->name; ?></td>
                        <td><?php echo @$company->user->name; ?></td>
                        <!-- <td><?php echo $activeStatus[$company->is_active]; ?></td> -->
                    </tr>
                <?php endforeach; ?>
                <tbody>
            </table>
        </div>
    </div>
</div>
