<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Departemen',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Setup',
    'submain_location' => 'Daftar Departemen'
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
            <h3 class="box-title m-b-0">Departement </h3>
            <p class="text-muted m-b-30">Data Departement</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('setup-department-new'); ?>" class="btn btn-primary">Tambah Departement</a></p>
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($departments as $dep): ?>
                <tr>
                    <td class="text-nowrap">
                        <a href="<?=$this->pathFor('setup-department-update',["id"=>$dep->id])?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a> 
                        <a href="<?=$this->pathFor('setup-department-delete',["id"=>$dep->id])?>" data-toggle="tooltip" data-original-title="Delete"> <i class="fa fa-close text-danger"></i> </a> 
                    </td>
                    <td><?php echo $dep->code; ?></td>
                    <td><?php echo $dep->name; ?></td>
                    <td><?=$dep->ket;?></td>
                    <td><?php echo $activeStatus[$dep->is_active] ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
