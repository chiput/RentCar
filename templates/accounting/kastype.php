<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Tipe Transaksi',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Akunting',
    'submain_location' => 'Tipe Transaksi'
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
            <h3 class="box-title m-b-0">Tipe Transaksi</h3>
            <p class="text-muted m-b-30">Data Tipe Transaksi</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('accounting-kastype-add'); ?>" class="btn btn-primary">Tambah Tipe Transaksi</a></p>
            <table class="table table-striped myDataTable table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nama</th>
                        <th>Debet</th>
                        <th>Kredit</th>
                        <th>Tipe</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($kastypes as $key => $kastype){ ?>
                    <tr>
                        <td class="text-nowrap">
                            <a href="<?=$this->pathFor('accounting-kastype-update',["id"=>$kastype->id])?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a> 
                            <a href="<?=$this->pathFor('accounting-kastype-delete',["id"=>$kastype->id])?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a> 
                        </td>
                        <td><?=$kastype->name?></td>
                        <td><?=$kastype->accdebet->code?> || <?=$kastype->accdebet->name?></td>
                        <td><?=$kastype->acckredit->code?> || <?=$kastype->acckredit->name?></td>
                        <td><?=$arrtype[$kastype->type]?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>