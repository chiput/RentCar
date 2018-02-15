<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Transaksi Kas',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Akunting',
    'submain_location' => 'Tipe Transaksi'
  ]); 

  $arrtype=["","kas","bank"];
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
            <h3 class="box-title m-b-0">Transaksi <?=$arrtype[$type]?></h3>
            <p class="text-muted m-b-20">Data Transaksi</p>
            <?php
                function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
            ?>
            <P> <a href="<?php echo $this->pathFor('accounting-kas-add',["type"=>$arrtype[$type]]); ?>" class="btn btn-primary">Tambah Transaksi <?=$arrtype[$type]?></a></p>
            <table class="table table-striped myDataTable table-hover toggle-circle">
                <thead>
                    <tr>
                        <th></th>
                        <th>Tanggal</th>
                        <th>No. Bukti</th>
                        <th>Keterangan</th>
                        <th data-hide="all"></th>
                        <th>User</th>
                        <th>User Edit</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($trans as $key => $tran){ ?>
                    <tr>
                        <td class="text-nowrap">
                            <a href="<?=$this->pathFor('accounting-kas-update',["id"=>$tran->id])?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a> 
                            <a href="<?=$this->pathFor('accounting-kas-delete',["id"=>$tran->id])?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a> 
                        </td>
                        <td><?=convert_date($tran->tanggal)?></td>
                        <td><?=$tran->nobukti?></td>
                        <td><?=$tran->remark?></td>
                        <td>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Debet</th>
                                        <th>Kredit</th>
                                        <th>Nominal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach ($tran->details as $detail) {
                                        ?>
                                        <tr>
                                            <td><?=$detail->acckastype->name?></td>
                                            <td><?php //echo $detail->acckastype->accdebet; ?>
                                            <?php echo $detail->acckastype->accdebet->code?> || <?php echo $detail->acckastype->accdebet->name?></td>
                                            <td><?php echo $detail->acckastype->acckredit->code?> || <?php echo $detail->acckastype->acckredit->name?></td>
                                            <td><?php echo $this->convert($detail->nominal)?></td>
                                        </tr>
                                        <?php 
                                        //echo $detail->account->code;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </td>
                        <td><?=@$tran->user->name?></td>
                        <td><?=@$tran->user_edit->name?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<style type="text/css">
    .footable-row-detail-inner{
        width: 100%;
    }
    .footable-row-detail-name{
        display: none;
    }
    .state i{
            padding: 12px 2px;
    }
    .green {
        color: #13A860;
    }
    .red {
        color: #FF4535;
    }
</style>