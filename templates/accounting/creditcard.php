<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Kartu Kredit',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Akunting',
    'submain_location' => 'Daftar Kartu Kredit'
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
            <h3 class="box-title m-b-0">Kartu Kredit</h3>
            <p class="text-muted m-b-20">Data Kartu Kredit</p>
            <p><a href="<?php echo $this->pathFor('accounting-creditcard-add'); ?>" class="btn btn-primary">Tambah Kartu Kredit</a></p>
            <table class="table table-striped myDataTable table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nama</th>
                        <!--<th >Biaya</th>-->
                    </tr>
                </thead>
                <tbody>
                <?php foreach($creditcards as $key => $creditcard){ ?>
                    <tr>
                        <td class="text-nowrap">
                            <a href="<?=$this->pathFor('accounting-creditcard-update',["id"=>$creditcard->id])?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a> 
                            <a href="<?=$this->pathFor('accounting-creditcard-delete',["id"=>$creditcard->id])?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a> 
                        </td>
                        <td><?=$creditcard->name?></td>
                        <!--<td><?=$creditcard->biaya?></td>-->
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>