<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Jurnal Umum',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Akunting',
    'submain_location' => 'Jurnal'
  ]); 
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
            <h3 class="box-title m-b-0">JURNAL UMUM</h3>
            <p class="text-muted m-b-30">Data Jurnal Umum</p>
            <?php
                function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
            ?>
            <form class="form" method="POST">
                <div class="row">
                    <div class="col-md-2">
                        <a href="<?php echo $this->pathFor('accounting-jurnal-add'); ?>" class="btn btn-primary">Tambah Jurnal</a>
                    </div>
                    <div class="col-md-4">
                        <div class="input-daterange input-group" id="date-range" data-date-format="dd-mm-yyyy">

                                <input  type="text" class="form-control" name="start" value="<?=($d_start)?>" >
                            <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                                <input type="text" class="form-control" name="end"
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
            <table class="table table-striped myDataTable table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>No. Bukti</th>
                        <th>Tanggal</th>
                        <th>No. Jurnal</th>
                        <th>Keterangan</th>
                        <th>Detail</th>

                    </tr>
                </thead>
                <tbody>
                <?php foreach($jurnals as $key => $jurnal){ ?>
                    <tr>
                        <td class="text-nowrap">
                            <a href="<?=$this->pathFor('accounting-jurnal-update',["id"=>$jurnal->id])?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a> 
                            <a href="<?=$this->pathFor('accounting-jurnal-delete',["id"=>$jurnal->id])?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a> 
                        </td>
                        <td><?=$jurnal->nobukti?></td>
                        <td><?=convert_date($jurnal->tanggal)?></td>
                        <td><?=$jurnal->code?></td>
                        <td><?=$jurnal->keterangan?> <hr/>
                            <form class="form">
                                <input type="hidden" name="id" value="<?=$jurnal->id?>">
                                <div class="row">
                                    <div class="col-xs-8">
                                        <select class="form-control" name="posted" >
                                            <?php if($jurnal->posted!="CLOSED"){ ?>
                                            <option value="UNPOSTED">UNPOSTED</option>
                                            <option <?=($jurnal->posted=="POSTED"?'selected="selected"':'')?> value="POSTED">POSTED</option>
                                            <?php }else{ ?>
                                            <option value="CLOSED">CLOSED</option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="state"></div>
                                    </div>
                                </div>                                
                            </form>
                            
                        </td>
                        <td>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Account</th>
                                        <th>Debet</th>
                                        <th>Kredit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach ($jurnal->detail as $detail) {
                                        ?>
                                        <tr>
                                            <td><?=$detail->account->code?></td>
                                            <td><?=$detail->account->name?></td>
                                            <td><?=$this->convert($detail->debet);?></td>
                                            <td><?=$this->convert($detail->kredit);?></td>
                                        </tr>
                                        <?php 
                                        //echo $detail->account->code;
                                    }
                                    ?>
                                    
                                
                                </tbody>
                            </table>
                        </td>
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