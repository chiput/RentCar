<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Aktiva',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Akunting',
    'submain_location' => 'Daftar Aktiva'
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
<?php endif; 
function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
?>


<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Aktiva</h3>
            <p class="text-muted m-b-30">Data Aktiva</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('accounting-aktiva-add'); ?>" class="btn btn-primary">Tambah Aktiva</a></p>
            <table class="table table-striped myDataTable toggle-circle table-hover">
                <thead>
                    <tr>
                        <th data-toggle="true"></th>
                        <th>Nama</th>
                        <th>Kelompok</th>
                        <th>Harga Beli</th>
                        <th>Umur Aktiva<br/>(Dalam tahun)</th>
                        <th data-hide="all">Akum. Beban</th>
                        <th data-hide="all">Beban/Bulan</th>
                        <th data-hide="all">Account Aktiva</th>
                        <th data-hide="all">Account Kas</th>
                        <th data-hide="all">Account Akumulasi</th>
                        <th data-hide="all">Account Penyusutan</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($aktivas as $aktiva){ ?>
                    <tr>
                        <td class="text-nowrap">
                            <a href="<?=$this->pathFor('accounting-aktiva-update',["id"=>$aktiva->id])?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a> 
                            <a href="<?=$this->pathFor('accounting-aktiva-delete',["id"=>$aktiva->id])?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a> 
                        </td>
                        <td><?=$aktiva->nama?></td>
                        <td><?=convert_date($aktiva->tanggal)?></td>
                        <td><?=$this->convert($aktiva->harga)?></td>
                        <td><?=$aktiva->umur?></td>
                        <td></td>
                        <td><?=$this->convert(($aktiva->harga-$aktiva->residu)/$aktiva->umur/12)?></td>
                        <td><?=$aktiva->aktiva->code?></td>
                        <td><?=$aktiva->kas->code?></td>
                        <td><?=$aktiva->akumulasi->code?></td>
                        <td><?=$aktiva->penyusutan->code?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



