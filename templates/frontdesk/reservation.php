<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Reservasi',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Frontdesk',
    'submain_location' => 'Reservasi'
  ]);

    $status = [
        'Reservasi',
        'Waiting List',
        'Batal',
    ];

?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Reservasi</h3>
            <p class="text-muted m-b-30">Data Reservasi</p>
            <p>
                <a href="<?php echo $this->pathFor('frontdesk-reservation-add'); ?>" class="btn btn-primary">Reservasi Baru</a>
            </p>
            <?php
                function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
            ?>
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#nocheckin" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Belum Checkin</span></a></li>
              <li role="presentation" class=""><a href="#checkin" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Sudah Checkin</span></a></li>
            </ul>

            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="nocheckin">
                <table class="table table-striped myDataTable">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Tanggal</th>
                            <th>No. Bukti</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Pelanggan</th>
                            <!-- <th>No Telp</th> -->
                            <th>Sopir</th>
                            <th>Status</th>
                            <th>User</th>
                            <th>User Edit</th>
                            <!--th>Dewasa</th>
                            <th>Anak-anak</th-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($reservations as $reservation){ ?>
                        <tr>
                            <td width="80">
                                <a href="<?php echo $this->pathFor('frontdesk-reservation-edit', ['id' => $reservation->id]); ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                                <a href="<?php echo $this->pathFor('frontdesk-reservation-delete', ['id' => $reservation->id]); ?>" data-toggle="tooltip" data-original-title="Hapus" class="delBtn"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                                <a href="<?php echo $this->pathFor('frontdesk-deposit', ['reservations_id' => $reservation->id]); ?>" data-toggle="tooltip" data-original-title="Deposit"> <i class="fa fa-credit-card-alt text-inverse m-r-10"></i></a>
                            </td>
                            <td><?=convert_date(substr($reservation->tanggal,0,10))?></td>
                            <td><?=$reservation->nobukti?></td>
                            <td><?=convert_date(substr($reservation->checkin,0,10))?></td>
                            <td><?=convert_date(substr($reservation->checkout,0,10))?></td>
                            <!-- <td></td> -->
                            <td><?=@$reservation->guest->name?></td>
                            <td><?=@$reservation->agent->name?></td>
                            <td><?=$status[@$reservation->status]?> <?=(@$reservation->status==2?convert_date($reservation->canceldate):'')?></td>
                            <td><?=@$reservation->user->name?></td>
                            <td><?=@$reservation->user_edit->name?></td>
                        </tr>
                        <?php } ?>
                    <tbody>
                </table>
                <div class="clearfix"></div>
              </div>
              <div role="tabpanel" class="tab-pane" id="checkin">
                <table class="table table-striped myDataTable">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Tanggal</th>
                            <th>No. Bukti</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Pelanggan</th>
                            <!-- <th>No Telp</th> -->
                            <th>Sopir</th>
                            <th>User</th>
                            <!-- <th>Log</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($reservations_checkin as $reservation){ ?>
                        <tr>
                            <td width="80">
                                <a href="<?php echo $this->pathFor('frontdesk-deposit', ['reservations_id' => $reservation->id]); ?>" data-toggle="tooltip" data-original-title="Deposit"> <i class="fa fa-credit-card-alt text-inverse m-r-10"></i></a>

                            </td>
                            <td><?=convert_date(substr($reservation->tanggal,0,10))?></td>
                            <td><?=$reservation->nobukti?></td>
                            <td><?=convert_date(substr($reservation->checkin,0,10))?></td>
                            <td><?=convert_date(substr($reservation->checkout,0,10))?></td>
                            <!-- <td></td> -->
                            <td><?=@$reservation->guest->name?></td>
                            <td><?=@$reservation->agent->name?></td>
                            <td><?=@$reservation->user->name?></td>
                        </tr>
                        <?php } ?>
                    <tbody>
                </table>
                <div class="clearfix"></div>
              </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    window.onload = function(){
        Array.prototype.map.call(document.querySelectorAll('.delBtn'),function(ele){
            ele.addEventListener('click',function(e){
                if(!confirm('Klik ok untuk menghapus')){
                    e.preventDefault();
                }
            });
        });
    };

</script>
