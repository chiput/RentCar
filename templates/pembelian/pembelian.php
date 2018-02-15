<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Pembelian',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Pembelian',
    'submain_location' => 'Pembelian'
  ]); 
?>


<?php if ($this->getSessionFlash('success')): ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('success'); ?>
</div>
<?php endif; ?>
     <?php
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
            <h3 class="box-title m-b-0">Pembelian</h3>
            <p class="text-muted m-b-30">Data Pembelian</p>
            <form class="form" method="POST">
                <div class="row">
                    <div class="col-md-2">
                        <a href="<?php echo $this->pathFor('daftar-pembelian-add'); ?>" class="btn btn-primary">Tambah Pembelian</a>
                    </div>
                    <div class="col-md-4">
                        <div class="input-daterange input-group" id="date-range" data-date-format="dd-mm-yyyy">

                                <input  type="text" class="form-control" name="start" value="<?php echo $d_start?>" >
                            <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                                <input type="text" class="form-control" name="end"
                                value="<?php echo $d_end?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="form-control btn btn-info">Filter</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="white-box">
            <table class="table table-striped myDataTable table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>Tanggal</th>
                        <th>No. Bukti</th>
                        <th>No. Permintaan</th>
                        <th>Department</th>
                        <th>Supplier</th>
                        <th>Keterangan</th>
                        <th>User</th>
                        <th>User Edit</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($purchOrders as $purchOrder){ ?>
                    <tr>
                        <td class="text-nowrap">
                            <a href="<?=$this->pathFor('daftar-pembelian-update',["id"=>$purchOrder->id])?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a> 
                            <a href="<?=$this->pathFor('daftar-pembelian-delete',["id"=>$purchOrder->id])?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a> 
                            <a target="_blank" href="<?=$this->pathFor('pembelian-report-purchase',["id"=>$purchOrder->id])?>" data-toggle="tooltip" data-original-title="Cetak"> <i class="fa fa-print text-inverse m-r-10"></i> </a> 
                        </td>
                        <td><?=convert_date(@$purchOrder->tanggal)?></td>
                        <td><?=$purchOrder->nobukti?></td>
                        <td><?=@$purchOrder->purchase->nobukti?></td>
                        <td><?=@$purchOrder->department->name?></td>
                        <td><?=@$purchOrder->supplier->nama?></td>
                        <td><?=@$purchOrder->keterangan?></td>
                        <td><?=@$purchOrder->user->name?></td>
                        <td><?=@$purchOrder->user_edit->name?></td>
                    </tr>
                <?php } ?>
                </tbody>                           
            </table>
        </div>
    </div>
</div>
