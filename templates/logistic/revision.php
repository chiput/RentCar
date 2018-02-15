<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Revisi Stok Barang',
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
            <h3 class="box-title m-b-0">Revisi Stok</h3>
            <p class="text-muted m-b-30">Data Revisi Stok</p>          
            <form class="form" method="POST">
                <div class="row">
                    <div class="col-md-2">
                        <a href="javascript:void(0)" href="javascript:void(0)" data-toggle="modal" data-target="#warehouse-modal" class="btn btn-primary">Tambah Revisi Stok</a><br/>
                        <!-- <p class="text-muted m-b-20"><a href="<?=$this->pathFor("logistic-revision-add")?>" class="btn btn-primary">Tambah Revisi Stok</a></p><br/> -->
                    </div>
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
                <?php foreach($revisions as $revision){ ?>
                    <tr>
                        <td class="text-nowrap">
                            <a href="<?=$this->pathFor('logistic-revision-edit',["id"=>$revision->id])?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a> 
                            <a href="<?=$this->pathFor('logistic-revision-delete',["id"=>$revision->id])?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a> 
                            <a target="_blank" href="<?=$this->pathFor('logistic-revision-report',["id"=>$revision->id])?>" data-toggle="tooltip" data-original-title="Cetak"> <i class="fa fa-print text-inverse m-r-10"></i> </a> 
                        </td>
                        <td><?php echo convert_date(@$revision->tanggal)?></td>
                        <td><?=$revision->nobukti?></td>
                        <td><?=@$revision->warehouse->nama?></td>
                        <td><?=@$revision->keterangan?></td>
                        <td><?=@$revision->user->name?></td>
                        <td><?=@$revision->user_edit->name?></td>
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
                <form class="form" action="<?php echo $this->pathFor('logistic-revision-add') ?>">
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