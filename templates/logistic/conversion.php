<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Konversi Satuan',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
  ]);
?>

<?php if ($this->getSessionFlash('success')): ?>
<div class="row">
    <div class="alert alert-success alert-dismissable col-sm-6">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $this->getSessionFlash('success'); ?>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Konversi Satuan</h3>
            <p class="text-muted m-b-30">Data Konversi Satuan</p>
            <p class="text-muted m-b-20"><a href="<?=$this->pathFor("logistic-conversion-add")?>" class="btn btn-primary">Tambah Konversi</a></p>
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th width="100"></th>
                        <th>Konversi</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($conversions as $conv){ ?>
                    <tr>
                        <td class="text-nowrap">
                            <a href="<?=$this->pathFor('logistic-conversion-edit',["id"=>$conv->id])?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a> 
                            <a href="<?=$this->pathFor('logistic-conversion-delete',["id"=>$conv->id])?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a> 
                        </td>
                        <td>1 <?=$conv->satuan_1->nama?> = <?=$conv->nilai?> <?=$conv->satuan_2->nama?> </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



