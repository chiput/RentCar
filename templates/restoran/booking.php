    <?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Data Reservasi',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Restoran',
    'submain_location' => 'Reservasi'
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
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('success'); ?>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0 m-b-20">Data Transaksi</h3>
            
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#reservasi" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Reservasi</span></a></li>
              <li role="presentation" class=""><a href="#checkin" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Checkin</span></a></li>
              <li role="presentation" class=""><a href="#batal" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Batal</span></a></li>
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="reservasi">
                <div class="row" style="margin-top: 3px; margin-top: 3px; margin-left: 3px; float: right;">
                    <div class="col-md-1">
                        <div class="form-group">
                            <a href=" <?php echo $this->pathFor('booking-new'); ?>" class="btn btn-primary btn-rounded waves-effect waves-light"><span class="btn-label"><i class="fa fa-list-alt"></i></span>Tambah Reservasi</a>
                        </div>
                  </div>
                </div>
                <table class="table table-striped myDataTable">
                  <thead>
                        <tr>                       
                            <th style="width: 10%;"></th>
                            <th>Tanggal</th>
                            <th>No. Bukti</th>
                            <th>CheckIn</th>
                            <th>Jam</th>
                            <th>Meja</th>
                            <th>Pelanggan</th>
                            <th>Status</th>
                            <th>User</th>
                            <th>User Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($reservasi as $resbooking) {
                         ?>
                        <tr>
                            <td> 
                                <a href="<?php echo $this->pathFor('booking-edit', ['id' => $resbooking->id]); ?>" data-toggle="tooltip"   data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                                <a href="<?php echo $this->pathFor('booking-delete', ['id' => $resbooking->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                                <a href="<?php echo $this->pathFor('booking-bukti', ['id' => $resbooking->id]); ?>" data-toggle="tooltip" data-original-title="Cetak"> <i class="glyphicon glyphicon-print text-inverse"></i></i> </a>
                            </td>
                           <td><?php echo convert_date(@$resbooking->tanggal)?></td>
                           <td><?=$resbooking->nobukti?></td>
                           <td><?php echo convert_date(@$resbooking->checkin)?></td> 
                           <td><?php echo @$resbooking->jam ?></td>  
                           <td><?=@$resbooking->meja->kode_meja?></td> 
                           <td><?php if ($resbooking->pelanggan_id != 0) {
                             echo $resbooking->pelanggan->nama;
                           } else {
                            echo $resbooking->reservationdetail->reservation->guest->name;
                            } ?></td> 
                           <td>
                              <form class="form">
                                  <input type="hidden" name="id" value="<?=$resbooking->id?>">
                                  <div class="row">
                                      <div class="col-xs-8">
                                          <select class="form-control" name="posted">
                                              <option value="0">-- Silahkan Pilih --</option>
                                              <option value="1" <?php if($resbooking->status ==1){ echo 'selected';}?>>Reservasi</option>
                                              <option value="2" <?php if($resbooking->status ==2){ echo 'selected';}?>>Checkin</option>
                                              <option value="3" <?php if($resbooking->status ==3){ echo 'selected';}?>>Batal</option>
                                          </select>
                                      </div>
                                      <div class="col-xs-4">
                                          <div class="state"></div>
                                      </div>
                                  </div>                                
                              </form>
                           </td>
                          <td><?=@$resbooking->user->name?></td>
                          <td><?=@$resbooking->user_edit->name?></td> 
                        </tr> 
                        <?php } ?>
                    </tbody>
                </table>
              </div>
              <div role="tabpanel" class="tab-pane" id="checkin">
                <table class="table table-striped myDataTable">
                  <thead>
                        <tr>                       
                            <th></th>
                            <th>No. Bukti</th>
                            <th>CheckIn</th>
                            <th>Jam</th>
                            <th>Meja</th>
                            <th>Pelanggan</th>
                            <th>Status</th>
                            <th>User</th>
                            <th>User Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($checkin as $resbooking) {
                         ?>
                        <tr>
                            <td> 
                                <a href="<?php echo $this->pathFor('booking-edit', ['id' => $resbooking->id]); ?>" data-toggle="tooltip"   data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                                <a href="<?php echo $this->pathFor('booking-delete', ['id' => $resbooking->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i></a>
                                <a href="" data-toggle="tooltip" data-original-title="Order"> <i class="fa fa-cutlery text-inverse m-r-10"></i> </a>
                            </td>
                           <td><?=$resbooking->nobukti?></td>
                           <td><?php echo convert_date(@$resbooking->checkin)?></td> 
                           <td><?php echo @$resbooking->jam ?></td>  
                           <td><?=@$resbooking->meja->kode_meja?></td> 
                           <td><?php if ($resbooking->pelanggan_id != 0) {
                             echo $resbooking->pelanggan->nama;
                           } else {
                            echo $resbooking->reservationdetail->reservation->guest->name;
                            } ?></td> 
                           <td>
                            <?php 
                                if($resbooking->status == 2){ 
                                  echo "Check In";
                                }
                            ?>
                          </td>
                          <td><?=@$resbooking->user->name?></td>
                          <td><?=@$resbooking->user_edit->name?></td> 
                        </tr> 
                        <?php } ?>
                    </tbody>
                </table>
              </div>
              <div role="tabpanel" class="tab-pane" id="batal">
                <table class="table table-striped myDataTable">
                  <thead>
                        <tr>                       
                            <th>No. Bukti</th>
                            <th>CheckIn</th>
                            <th>Jam</th>
                            <th>Meja</th>
                            <th>Pelanggan</th>
                            <th>Status</th>
                            <th>User</th>
                            <th>User Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($batal as $resbooking) {
                         ?>
                        <tr>
                           <td><?=$resbooking->nobukti?></td>
                           <td><?php echo convert_date(@$resbooking->checkin)?></td> 
                           <td><?php echo @$resbooking->jam ?></td>  
                           <td><?=@$resbooking->meja->kode_meja?></td> 
                           <td><?php if ($resbooking->pelanggan_id != 0) {
                             echo $resbooking->pelanggan->nama;
                           } else {
                            echo $resbooking->reservationdetail->reservation->guest->name;
                            } ?></td> 
                           <td>
                             <?php 
                                if($resbooking->status == 3){ 
                                  echo "Batal";
                                }
                            ?>
                           </td>
                          <td><?=@$resbooking->user->name?></td>
                          <td><?=@$resbooking->user_edit->name?></td> 
                        </tr> 
                        <?php } ?>
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




