<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Barang',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
  ]);
?>

<?php if ($this->getSessionFlash('success')): ?>
<div class="row">
    <div class="alert alert-success alert-dismissable col-sm-12">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $this->getSessionFlash('success'); ?>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Barang</h3>
            <p class="text-muted m-b-30">Data Barang</p>
            <p class="text-muted m-b-20"><a href="<?=$this->pathFor("logistic-good-add")?>" class="btn btn-primary">Tambah Barang</a></p>
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th width="100"></th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Satuan</th>
                        <th>Kategori</th>
                        <th>Harga Awal</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($goods as $good){ ?>
                    <tr>
                        <td class="text-nowrap">
                            <a href="<?=$this->pathFor('logistic-good-edit',["id"=>$good->id])?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a> 
                            <a href="<?=$this->pathFor('logistic-good-delete',["id"=>$good->id])?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a> 
                        </td>
                        <td><?=$good->kode?></td>
                        <td><?=$good->nama?></td>
                        <td><?=@$good->unit->nama?></td>
                        <td><?=@$good->category->nama?></td>
                        <td><?=$this->convert($good->hargastok)?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



