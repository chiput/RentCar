<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Account',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Akunting',
    'submain_location' => 'Daftar Account'
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
            <h3 class="box-title m-b-0">Account</h3>
            <p class="text-muted m-b-30">Data Account</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('accounting-accounts-add'); ?>" class="btn btn-primary">Tambah Account</a></p>
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>No. Account</th>
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>Header</th>
                        <th>Group</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($accounts as $account){ ?>
                    <tr>
                        <td class="text-nowrap">
                            <a href="<?=$this->pathFor('accounting-accounts-update',["id"=>$account->id])?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a> 
                            <a href="<?=$this->pathFor('accounting-accounts-delete',["id"=>$account->id])?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a> 
                        </td>
                        <td><?=$account->code?></td>
                        <td><?=$account->name?></td>
                        <td><?=$account->type?></td>
                        <td><?=$account->headerName?></td>
                        <td><?=$account->groupName?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



