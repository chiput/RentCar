<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Sopir',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Frontdesk',
    'submain_location' => 'Sopir'
  ]);

    $activeStatus = [
        'Tidak Aktif',
        'Aktif'
    ];

?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Sopir </h3>
            <p class="text-muted m-b-30">Data Sopir</p>
            <p>
                <a href="<?php echo $this->pathFor('frontdesk-agent-new'); ?>" class="btn btn-primary">Tambah Sopir</a>
            </p>
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th>

                        </th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Aktif</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($agents as $agent): ?>
                    <tr>
                        <td>
                            <a href="<?php echo $this->pathFor('frontdesk-agent-update', ['id' => $agent->id]); ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                            <a href="<?php echo $this->pathFor('frontdesk-agent-delete', ['id' => $agent->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                        </td>
                        <td><?php echo $agent->code; ?></td>
                        <td><?php echo $agent->name; ?></td>
                        <td><?php echo $activeStatus[$agent->is_active]; ?></td>
                    </tr>
                <?php endforeach; ?>
                <tbody>
            </table>
        </div>
    </div>
</div>
