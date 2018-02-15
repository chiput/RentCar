<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Gedung',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Setup',
    'submain_location' => 'Daftar Gedung'
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
            <h3 class="box-title m-b-0">Gedung </h3>
            <p class="text-muted m-b-30">Data Gedung</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('setup-building-new'); ?>" class="btn btn-primary">Tambah Gedung</a></p>
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nama</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($buildings as $bul): ?>
                <tr>
                    <td class="text-nowrap">
                        <a href="<?=$this->pathFor('setup-building-update',["id"=>$bul->id])?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a> 
                        <a href="<?=$this->pathFor('setup-building-delete',["id"=>$bul->id])?>" data-toggle="tooltip" data-original-title="Delete"> <i class="fa fa-close text-danger"></i> </a> 
                    </td>
                    <td><?php echo $bul->name; ?></td>
                    <td><?php echo $bul->desc; ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
