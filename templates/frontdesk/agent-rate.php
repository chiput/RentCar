<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Harga Agen',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Frontdesk',
    'submain_location' => 'Harga Agen'
  ]);

    $activeStatus = [
        'Tidak Aktif',
        'Aktif'
    ];

?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Agen </h3>
            <p class="text-muted m-b-30">Daftar Harga : <?=$agent->name?></p>
            <p>
                <a href="<?php echo $this->pathFor('frontdesk-agentrate-new',['agent_id'=>$agent->id]); ?>" class="btn btn-primary">Tambah Harga</a>
            </p>
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th>

                        </th>
                        <th>Tipe Kamar</th>
                        <th>Tipe T. Tidur</th>
                        <th>Harga Kamar</th>
                        <th>Harga Kamar Saja</th>
                        <th>Harga Breakfast</th>
                        <th>User</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($rates as $rate): ?>
                    <tr>
                        <td>
                            <a href="<?php echo $this->pathFor('frontdesk-agentrate-update', ['id' => $rate->id]); ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                            <a href="<?php echo $this->pathFor('frontdesk-agentrate-delete', ['id' => $rate->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>
                        </td>
                        <td><?php echo (@$rate->room_type->name==""?"Semua":@$rate->room_type->name); ?></td>
                        <td><?php echo (@$rate->bed_type->name==""?"Semua":@$rate->bed_type->name); ?></td>
                        <td><?=$this->convert($rate->room_price); ?></td>
                        <td><?=$this->convert($rate->room_only_price); ?></td>
                        <td><?=$this->convert($rate->breakfast_price); ?></td>
                        <td><?php echo $rate->user->name; ?></td>
                    </tr>
                <?php endforeach; ?>
                <tbody>
            </table>
        </div>
    </div>
</div>
