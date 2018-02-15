<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Bank',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Akunting',
    'submain_location' => 'Daftar Bank'
  ]); 

  $arrtype=["","Kas","Bank"];
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
            <h3 class="box-title m-b-0">BANK</h3>
            <p class="text-muted m-b-20">Data Bank</p>
            <p><a href="<?php echo $this->pathFor('accounting-bank-add'); ?>" class="btn btn-primary">Tambah Bank</a></p>
            <table class="table table-striped myDataTable table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nama</th>
                        <th>No. Rek</th>
                        <th>Atas Nama</th>
                        <th>Account</th>
                        <th>Account Biaya Admin</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($banks as $key => $bank){ ?>
                    <tr>
                        <td class="text-nowrap">
                            <a href="<?=$this->pathFor('accounting-bank-update',["id"=>$bank->id])?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a> 
                            <a href="<?=$this->pathFor('accounting-bank-delete',["id"=>$bank->id])?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a> 
                        </td>
                        <td><?=$bank->name?></td>
                        <td><?=$bank->accno?></td>
                        <td><?=$bank->accname?></td>
                        <td><?=@$bank->account->code?> || <?=@$bank->account->name?></td>
                        <td><?=@$bank->admin->code?> || <?=@$bank->admin->name?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>