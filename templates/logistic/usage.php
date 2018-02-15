<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Pemakaian Barang',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
  ]);
?>
            <?php
                function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
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
            <h3 class="box-title m-b-0">Pemakaian Barang</h3>
            <p class="text-muted m-b-30">Data Pemakaian Barang</p>          
            <form class="form" method="POST">
                <div class="row">
                    <div class="col-md-2">
                        <a href="javascript:void(0)" href="javascript:void(0)" data-toggle="modal" data-target="#pilih-modal" class="btn btn-primary">Tambah Pemakaian</a>
                    </div>
                    <!-- <div class="col-md-2">
                        <a href="javascript:void(0)" href="javascript:void(0)" data-toggle="modal" data-target="#pilih-modal" class="btn btn-primary">Pilih Request</a>
                    </div> -->
                    <div class="col-md-4">
                        <div class="input-daterange input-group" id="date-range" data-date-format="dd-mm-yyyy">

                                <input  type="text" class="form-control" name="d_start" value="<?=$d_start?>" >
                            <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                                <input type="text" class="form-control" name="d_end"
                                value="<?=$d_end?>">
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
                        <th>Gudang</th>
                        <th>Keterangan</th>
                        <th>User</th>
                        <th>User Edit</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($usages as $usage){ ?>
                    <tr>
                        <td class="text-nowrap">
                            <a href="<?=$this->pathFor('logistic-usage-edit',["id"=>$usage->id])?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a> 
                            <a href="<?=$this->pathFor('logistic-usage-delete',["id"=>$usage->id])?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a> 
                            <a target="_blank" href="<?=$this->pathFor('logistic-usage-report',["id"=>$usage->id])?>" data-toggle="tooltip" data-original-title="Cetak"> <i class="fa fa-print text-inverse m-r-10"></i> </a> 
                        </td>
                        <td><?php echo convert_date(@$usage->tanggal)?></td>
                        <td><?=$usage->nobukti?></td>
                        <td><?=@$usage->warehouse->nama?></td>
                        <td><?=@$usage->keterangan?></td>
                        <td><?=@$usage->user->name?></td>
                        <td><?=@$usage->user_edit->name?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;" id="warehouse-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="">Pilih Gudang & Tanggal</h4>
            </div>
            <div class="modal-body">
                <form class="form" action="<?php echo $this->pathFor('logistic-usage-add') ?>">
                    <div class="row">
                        <div class="col-md-5">
                            <label>Gudang | Departemen</label>
                            <select class="form-control select2" name="gudang_id">
                                <?php foreach($warehouses as $warehouse){ ?>
                                <option value="<?=$warehouse->id?>"> <?=$warehouse->nama?> | <?=$warehouse->department->name?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label>Tanggal</label>
                            <input name="tanggal" class="form-control mydatepicker" data-date-format="dd-mm-yyyy" value="<?=date("d-m-Y")?>">
                        </div>
                        <div class="col-md-2">
                            <label>&nbsp;</label>
                            <button class="btn btn-primary">Lanjutkan</button>
                        </div>
                    </div>    
                </form>
                
                
                        
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Tutup</button>
            </div> -->
        </div>
    </div>
    <!-- /.modal-content -->
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;" id="pilih-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="">Daftar Request Barang</h4>
            </div>
            <div class="modal-body">
                <table class="table datatable myDataTable">
                    <thead>
                        <tr>
                            <th>Aksi</th>
                            <th>Tanggal Request</th>
                            <th>No Bukti</th>
                            <th>Departemen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($puReq as $purchase): 
                        ?>
                        <tr>
                            <td>
                                <form class="form" action="<?php echo $this->pathFor('logistic-usage-add') ?>">
                                    <input name="tanggal" class="form-control mydatepicker hidden" data-date-format="dd-mm-yyyy" value="<?=date("d-m-Y")?>">
                                    <input name="request_id" class="form-control hidden" value="<?=$purchase->id?>">
                                    <input name="gudang_id" class="form-control hidden" value="4">
                                    <button type="submit" class="btn btn-info waves-effect">Pilih</button>
                                </form>
                            </td>
                            <td style="padding: 25px 8px;"><?=convert_date(@$purchase->tanggal)?></td>
                            <td style="padding: 25px 8px;"><?=@$purchase->nobukti?></td>
                            <td style="padding: 25px 8px;"><?=@$purchase->department->name?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>       
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Tutup</button>
            </div> -->
        </div>
    </div>
    <!-- /.modal-content -->
</div>