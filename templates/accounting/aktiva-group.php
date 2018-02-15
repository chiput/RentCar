<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Kelompok Aktiva',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Akunting',
    'submain_location' => 'Daftar Kelompok Aktiva'
  ]); 
?>

<?php if ($this->getSessionFlash('success')): ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('success'); ?>
</div>
<?php endif; ?>
<?php if ($this->getSessionFlash('error')): ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $this->getSessionFlash('error'); ?>
        </div>
<?php endif; ?>


<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Kelompok Aktiva</h3>
            <p class="text-muted m-b-30">Data Kelompok Aktiva</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('accounting-aktiva-group-add'); ?>" class="btn btn-primary">Tambah Kelompok Aktiva</a></p>
            <table class="table table-striped myDataTable toggle-circle table-hover">
                <thead>
                    <tr>
                        <th data-toggle="true"></th>
                        <th>Nama</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($groups as $group){ ?>
                    <tr>
                        <td class="text-nowrap">
                            <a href="<?=$this->pathFor('accounting-aktiva-group-update',["id"=>$group->id])?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a> 
                            <a href="<?=$this->pathFor('accounting-aktiva-group-delete',["id"=>$group->id])?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a> 
                        </td>
                        <td><?=$group->nama?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



