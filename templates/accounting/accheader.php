<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Header Account',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Akunting',
    'submain_location' => 'Data Header Account'
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
            <h3 class="box-title m-b-0">Header</h3>
            <p class="text-muted m-b-30">Data Headers</p>
            <p>
                <a href="<?php echo $this->pathFor('accounting-headers-add'); ?>" class="btn btn-primary">Tambah Header</a>
            </p>
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>No. Header</th>
                        <th>Nama</th>
                        <th>Grup</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($headers as $header){ ?>
                    <tr>
                        <td class="text-nowrap">
                            <a href="<?=$this->pathFor('accounting-headers-update',["id"=>$header->id])?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a> 
                            <a href="<?=$this->pathFor('accounting-headers-delete',["id"=>$header->id])?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a> 
                        </td>
                        <td><?=$header->code?></td>
                        <td><?=$header->name?></td>
                        <td><?=$header->groupName?></td>
                        <td><?=$header->remark?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



