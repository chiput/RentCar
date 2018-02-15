<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Peminjaman',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Frontdesk',
    'submain_location' => 'Peminjaman'
  ]);

    $activeStatus = [
        'Tidak Aktif',
        'Aktif'
    ];
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
            <h3 class="box-title m-b-0">Peminjaman</h3>
            <p class="text-muted m-b-30">Data Peminjaman</p>
            <p>
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal-reservation">Tambah Peminjaman</a>
            </p>
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#nocheckout" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Belum Kembali</span></a></li>
              <li role="presentation" class=""><a href="#checkedout" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Sudah Kembali</span></a></li>
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="nocheckout">
                <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th>No. Peminjaman</th>
                        <th>Peminjaman</th>
                        <th>No. Reservasi</th>
                        <th>Nama</th>
                        <th>Telp</th>
                        <th>Sopir</th>
                        <th>User</th>
                        <th>User Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($checkins as $checkin): ?>
                        <tr>
                            <td>
                                <a href="<?php echo $this->pathFor('frondesk-checkingroup-edit', [
                                    'reservation_detail_id' => $checkin->id,
                                    'reservation_id' => $checkin->reservations_id]); ?>">
                                    <?php echo $checkin->checkin_code ?>
                                </a>
                                <a href="<?php echo $this->pathFor('frontdesk-checkingroup-delete', ['id' => $checkin->id]); ?>" data-toggle="tooltip" data-original-title="Hapus" class="delBtn"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                            </td>
                             <td><?php echo convert_date(substr(@$checkin->checkin_at,0,10))." ".substr(@$checkin->checkin_at,10,18) ?></td>
                            <td><?php echo @$checkin->reservation->nobukti ?>
                            <?php 
                                if(@$checkin->change_code == 1){
                                    echo '<br/><span class="label label-warning">Pindah</span>';
                                }
                            ?>
                            </td>
                            <td><?php echo @$checkin->reservation->guest->name ?></td>
                            <td><?php echo @$checkin->reservation->guest->phone ?></td>
                            <td><?php echo @$checkin->reservation->agent->name ?></td>
                            <td><?=@$checkin->user->name?></td>
                            <td><?=@$checkin->user_edit->name?></td>
                        </tr>
                    <?php endforeach; ?>
                <tbody>
            </table>
              </div>
              <div role="tabpanel" class="tab-pane" id="checkedout">
                <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th>No. Peminjaman</th>
                        <th>Peminjaman</th>
                        <th>Pengembalian</th>
                        <th>No. Reservasi</th>
                        <th>Nama</th>
                        <th>Telp</th>
                        <th>Sopir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($checkins_checkedout as $checkin): ?>
                        <tr>
                            <td><?php echo $checkin->checkin_code ?>
                            <?php 
                                if(@$checkin->change_code == 1){
                                    echo '<br/><span class="label label-warning">Pindah</span>';
                                }
                            ?>
                            </td>
                            <td><?php echo convert_date(substr($checkin->checkin_at,0,10))." ".substr($checkin->checkin_at,10,18) ?></td>
                            <td><?php echo convert_date(substr($checkin->checkout_at,0,10))." ".substr($checkin->checkout_at,10,18) ?></td>
                            <td><?php echo $checkin->reservation->nobukti ?></td>
                            <td><?php echo $checkin->reservation->guest->name ?></td>
                            <td><?php echo $checkin->reservation->guest->phone?></td>
                            <td><?php echo @$checkin->reservation->agent->name?></td>
                        </tr>
                    <?php endforeach; ?>
                <tbody>
            </table>
              </div>
            </div>
            
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modal-reservation">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pilih Reservasi</h4>
            </div>
        <div class="modal-body">
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th>Tanggal Resv</th>
                        <th>No. Resv</th>
                        <th>Deposit</th>
                        <th>Peminjaman</th>
                        <th>Pengembalian</th>
                        <th>Nama</th>
                        <th>Sopir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($modal_reservations as $modal_reservation) :
                        $link = $this->pathFor('frondesk-checkingroup-add', ['reservation_id' => $modal_reservation->id]);
                    ?>
                    <tr>
                        <td><?php echo convert_date(substr($modal_reservation->created_at,0,10))." ".substr($modal_reservation->created_at,10,18)  ?></td>
                        <td>
                            <a href="<?php echo $link; ?>"><?php echo $modal_reservation->nobukti ?></a>
                        </td>
                        <td>
                        <?php
                        @$nominal=0;
                        foreach ($modal_reservation->deposits as $deposit) {
                            $nominal+=$deposit->nominal;
                        } 
                        echo '<a href="'.$this->pathFor('frontdesk-deposit', ['reservations_id' => $modal_reservation->id]).'" target="_blank">'.number_format($nominal,0).'</a>';
                        ?>
                            
                        </td>
                         <td><?php echo convert_date(substr($modal_reservation->checkin,0,10))." ".substr($modal_reservation->checkin,10,18) ?></td>
                        <td><?php echo convert_date(substr($modal_reservation->checkout,0,10))." ".substr($modal_reservation->checkout,10,18) ?></td>
                        <td><?php echo @$modal_reservation->guest->name ?></td>
                        <td><?php echo @$modal_reservation->agent->name ?></td>
                    </tr>
                    <?php endforeach; ?>
                <tbody>
            </table>
        </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
