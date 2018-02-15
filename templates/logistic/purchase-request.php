<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Permintaan Barang',
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
            <h3 class="box-title m-b-0">Permintaan Barang</h3>
            <p class="text-muted m-b-30">Data Permintaan Barang</p>
            <form class="form" method="POST">
                <div class="row">
                    <div class="col-md-2">
                        <p class="text-muted m-b-20"><a href="<?=$this->pathFor("logistic-purchase-request-add")?>" class="btn btn-primary">Tambah Permintaan</a></p><br/>
                    </div>
                    <div class="col-md-4">
                        <div class="input-daterange input-group" id="date-range" data-date-format="dd-mm-yyyy">

                                <input  type="text" class="form-control" name="d_start" value="<?=($d_start)?>" >
                            <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                                <input type="text" class="form-control" name="d_end"
                                value="<?=($d_end)?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="form-control btn btn-info">Filter</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="white-box">
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#request" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs">Data Request Barang</span></a></li>
              <li role="presentation" class=""><a href="#pembelian" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Data Pembelian Barang</span></a></li>
              <li role="presentation" class=""><a href="#pemakaian" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Data Pemakaian Barang</span></a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="request">
                    <table class="table table-striped myDataTable">
                        <thead>
                            <tr>
                                <th width="100"></th>
                                <th>Tanggal</th>
                                <th>No. Bukti</th>
                                <th>Departemen</th>
                                <th>Keterangan</th>
                                <th>User</th>
                                <th>User Update</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($purReqs as $purReq){ 
                            if($purReq->status == 0){
                            ?>
                            <tr>
                                <td class="text-nowrap">
                                    <a href="<?=$this->pathFor('logistic-purchase-request-edit',["id"=>$purReq->id])?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                                    <a href="<?=$this->pathFor('logistic-purchase-request-delete',["id"=>$purReq->id])?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                                    <a target="_blank" href="<?=$this->pathFor('logistic-purchase-request-report',["id"=>$purReq->id])?>" data-toggle="tooltip" data-original-title="Cetak"> <i class="fa fa-print text-inverse m-r-10"></i> </a>
                                </td>
                                <td><?php echo convert_date(@$purReq->tanggal)?></td>
                                <td><?=$purReq->nobukti?></td>
                                <td><?=@$purReq->department->name?></td>
                                <td><?=@$purReq->keterangan?><hr/>
                                    <form class="form">
                                        <input type="hidden" name="id" value="<?=$purReq->id?>">
                                        <div class="row">
                                            <div class="col-xs-8">
                                                <select class="form-control" name="posted">
                                                    <?php if($purReq->status=="0"){ ?>
                                                    <option value="0">-- Silahkan Pilih --</option>
                                                    <option value="1" <?php if($purReq->status ==1){ echo 'selected';}?>>Beli</option>
                                                    <option value="2" <?php if($purReq->status ==2){ echo 'selected';}?>>Pakai</option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="state"></div>
                                            </div>
                                        </div>                                
                                    </form>
                                </td>
                                <td><?=@$purReq->user->name?></td>
                                <td><?=@$purReq->user_edit->name?></td>
                            </tr>
                        <?php } }?>
                        </tbody>
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane" id="pembelian">
                    <table class="table table-striped myDataTable">
                        <thead>
                            <tr>
                                <th width="100"></th>
                                <th>Tanggal</th>
                                <th>No. Bukti</th>
                                <th>Departemen</th>
                                <th>Keterangan</th>
                                <th>User</th>
                                <th>User Update</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($purReqs as $purReq){ 
                            if($purReq->status == 1){?>
                            <tr>
                                <td class="text-nowrap">
                                    <a href="<?=$this->pathFor('logistic-purchase-request-edit',["id"=>$purReq->id])?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                                    <a href="<?=$this->pathFor('logistic-purchase-request-delete-status',["id"=>$purReq->id])?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                                    <a target="_blank" href="<?=$this->pathFor('logistic-purchase-request-report',["id"=>$purReq->id])?>" data-toggle="tooltip" data-original-title="Cetak"> <i class="fa fa-print text-inverse m-r-10"></i> </a>
                                </td>
                                <td><?php echo convert_date(@$purReq->tanggal)?></td>
                                <td><?=$purReq->nobukti?></td>
                                <td><?=@$purReq->department->name?></td>
                                <td><?=@$purReq->keterangan?></td>
                                <td><?=@$purReq->user->name?></td>
                                <td><?=@$purReq->user_edit->name?></td>
                            </tr>
                        <?php } }?>
                        </tbody>
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane" id="pemakaian">
                    <table class="table table-striped myDataTable">
                        <thead>
                            <tr>
                                <th width="100"></th>
                                <th>Tanggal</th>
                                <th>No. Bukti</th>
                                <th>Departemen</th>
                                <th>Keterangan</th>
                                <th>User</th>
                                <th>User Update</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($purReqs as $purReq){ 
                            if($purReq->status == 2){?>
                            <tr>
                                <td class="text-nowrap">
                                    <a href="<?=$this->pathFor('logistic-purchase-request-edit',["id"=>$purReq->id])?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                                    <a href="<?=$this->pathFor('logistic-purchase-request-delete-status',["id"=>$purReq->id])?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                                    <a target="_blank" href="<?=$this->pathFor('logistic-purchase-request-report',["id"=>$purReq->id])?>" data-toggle="tooltip" data-original-title="Cetak"> <i class="fa fa-print text-inverse m-r-10"></i> </a>
                                </td>
                                <td><?php echo convert_date(@$purReq->tanggal)?></td>
                                <td><?=$purReq->nobukti?></td>
                                <td><?=@$purReq->department->name?></td>
                                <td><?=@$purReq->keterangan?></td>
                                <td><?=@$purReq->user->name?></td>
                                <td><?=@$purReq->user_edit->name?></td>
                            </tr>
                        <?php } }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('[name="posted"]').change(function(event) {
        var form = $(this).parent().parent().parent();
        console.log($(form).find(".state"));
        $(form).find(".state").html('<i class="green fa fa-spin fa-circle-o-notch"></i>');
        $.ajax({
            url: 'posted',
            type: 'POST',
            data: $(form).serialize(),
        })
        .done(function() {
            $(form).find(".state").html('<i class="green fa fa-check dismiss-anim"></i>');
            $(form).find(".state i").fadeOut('800');
            console.log("success");
        })
        .fail(function() {
            $(form).find(".state").html('<i class="red fa fa-times dismiss-anim"></i>');
            $(form).find(".state i").fadeOut('800');
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });

    });
</script>
