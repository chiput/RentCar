<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Retur Pembelian',
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
            <h3 class="box-title m-b-0">Retur Pembelian</h3>
            <p class="text-muted m-b-30">Data Retur Pembelian</p>
            <form class="form" method="POST">
                <div class="row">
                    <div class="col-md-3">
                        <p class="text-muted m-b-20">
                        <a href="javascript:void(0)" href="javascript:void(0)" data-toggle="modal" data-target="#purchase-modal" class="btn btn-primary">Tambah Retur Pembelian</a>
                        </p><br/>
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
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th width="100"></th>
                        <th>Tanggal</th>
                        <th>No. Bukti</th>
                        <th>No. Pembelian</th>
                        <th>Supplier</th>
                        <th>Keterangan</th>
                        <th>User</th>
                        <th>User Edit</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($returs as $retur){ ?>
                    <tr>
                        <td class="text-nowrap">
                            <a href="<?=$this->pathFor('retur-pembelian-update',["id"=>$retur->id])?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a> 
                            <a href="<?=$this->pathFor('retur-pembelian-delete',["id"=>$retur->id])?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a> 
                            <a target="_blank" href="<?=$this->pathFor('retur-pembelian-print',["id"=>$retur->id])?>" data-toggle="tooltip" data-original-title="Cetak"> <i class="fa fa-print text-inverse m-r-10"></i> </a> 
                        </td>
                        <td><?php echo convert_date(@$retur->tanggal)?></td>
                        <td><?=$retur->nobukti?></td>
                        <td><?=@$retur->purchase->nobukti?></td>
                        <td><?=@$retur->purchase->supplier->nama?></td>
                        <td><?=@$retur->keterangan?></td>
                        <td><?=@$retur->user->name?></td>
                        <td><?=@$retur->user_edit->name?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;" id="purchase-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="">Pilih Pembelian</h4>
            </div>
            <div class="modal-body">
                <table class="table myDataTable">
                    <thead>
                        <tr>
                            <th></th>
                            <th>No Bukti</th>
                            <th>Tanggal</th>
                            <th>Departemen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($purchases as $purchase){ ?>
                        <tr>
                            <td>
                            <a href="<?=$this->pathFor('retur-pembelian-add',["pembelian_id"=>$purchase->order->id])?>" data-toggle="tooltip" data-original-title="Pilih" type="button" class="btn btn-info waves-effect text-left">Pilih
                            </a> 
                            </td>
                            <td>
                            <?=$purchase->order->nobukti?>
                            </td>
                            <td><?=convert_date($purchase->tanggal)?></td>
                            <td><?=$purchase->order->department->name?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>-->
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>