<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Stok Opname Barang',
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
            <h3 class="box-title m-b-0">Logistik</h3>
            <p class="text-muted m-b-5">Daftar Stok Opname Barang</p>          
            <form class="form" method="POST">
                <div class="row">
                    <div class="col-md-2">
                        <p class="text-muted m-b-20"><a href="<?=$this->pathFor("logistic-stocktaking-add")?>" class="btn btn-primary">Tambah Stok Opname</a></p><br/>
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
                        <th>User Update</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($stocks as $stock){ ?>
                    <tr>
                        <td class="text-nowrap">
                            <a href="<?=$this->pathFor('logistic-stocktaking-edit',["id"=>$stock->id])?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a> 
                            <a href="<?=$this->pathFor('logistic-stocktaking-delete',["id"=>$stock->id])?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a> 
                            <a target="_blank" href="<?=$this->pathFor('logistic-stocktaking-report',["id"=>$stock->id])?>" data-toggle="tooltip" data-original-title="Cetak"> <i class="fa fa-print text-inverse m-r-10"></i> </a> 
                        </td>
                        <td><?php echo convert_date(@$stock->tanggal)?></td>
                        <td><?=$stock->nobukti?></td>
                        <td><?=@$stock->warehouse->nama?></td>
                        <td><?=@$stock->keterangan?></td>
                        <td><?=@$stock->user->name?></td>
                        <td><?=@$stock->user_edit->name?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>