<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Saldo Awal',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Akunting',
    'submain_location' => 'Data Saldo Awal'
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
            <h3 class="box-title m-b-0">Saldo Awal</h3>
            <p class="text-muted m-b-30">Data Saldo Awal</p>
            <p><a href="<?php echo $this->pathFor('accounting-neraca-saldo-awal-add'); ?>" class="btn btn-primary">Tambah Saldo Awal</a></p>
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>Bulan</th>
                        <th>Tahun</th>
                        <th>User</th>
                        <th>User Edit</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($neracas as $neraca){ ?>
                    <tr>
                        <td class="text-nowrap">
                            <a href="<?=$this->pathFor('accounting-neraca-saldo-awal-edit',["id"=>$neraca->id])?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a> 
                            <a href="<?=$this->pathFor('accounting-neraca-saldo-awal-delete',["id"=>$neraca->id])?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a> 
                        </td>
                        <td><?=date("F",strtotime($neraca->tanggal))?></td>
                        <td><?=date("Y",strtotime($neraca->tanggal))?></td>
                        <td><?=@$neraca->user->name?></td>
                        <td><?=@$neraca->user_edit->name?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



