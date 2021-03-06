<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Tamu',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Frontdesk',
    'submain_location' => 'Costumer List Building'
  ]);

    $activeStatus = [
        'Tidak Aktif',
        'Aktif'
    ];

?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Tamu </h3>
            <p class="text-muted m-b-30">Daftar Tamu</p>
            <p>
                <a href="<?php echo $this->pathFor('frontdesk-guest-new'); ?>" class="btn btn-primary">Tambah</a>
            </p>
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th>

                        </th>
                        <th>Nama</th>
                        <th>Negara</th>
                        <th>Email</th>
                        <th>Aktif</th>
                        <th>Black List</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($guests as $guest): ?>
                    <tr>
                        <td>
                            <a href="javascript:void(0)" data-id="<?php echo $guest->id; ?>" data-toggle="tooltip" class="btnDetail" data-original-title="Detail"><i class="fa fa-users"></i> </a>
                        </td>
                        <td><?php echo $guest->name; ?></td>
                        <td><?php echo $guest->country->nama; ?></td>
                        <td><?php echo $guest->email; ?></td>
                        <td><?php echo $activeStatus[$guest->is_active] ?></td>
                        <td><?php echo ($guest->is_blacklist==1?"Black List":"") ?></td>
                    </tr>
                <?php endforeach; ?>
                <tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="costListBuild" aria-labelledby="costListBuild" aria-hidden="true" style="display: none;">
    <input type="hidden" id="urlajax" value="<?=$this->pathFor('frontdesk-guest-costlistbuilding-ajax_detail')?>">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myLargeModalLabel">Detail Tamu {{tes}}</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="progress progress-sm">
              <div class="progress-bar progress-bar-info active progress-bar-striped" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 100%" role="progressbar"> <span class="sr-only">100% Complete (success)</span> </div>
            </div>
            <div class="col-md-6">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td><label> <span class="help">Nama Tamu</span></label></td>
                            <td width="50%">: {{guest.name}}</td>
                        </tr>
                        <tr>
                            <td><label> <span class="help"> Alamat</span></label></td>
                            <td>: {{guest.address}}</td>
                        </tr>
                        <tr>
                            <td><label> <span class="help"> Negara</span></label>
                            <td>: {{guest.country}}</td>
                        </tr>
                        <tr>
                            <td><label> <span class="help"> Provinsi</span></label></td>
                            <td>: {{guest.state}}</td>
                        </tr>
                        <tr>
                            <td><label> <span class="help"> Kota</span></label></td>
                            <td>: {{guest.city}}</td>
                        </tr>
                        <tr>
                            <td><label> <span class="help"> Kode Pos</span></label></td>
                            <td>: {{guest.zipcode}}</td>
                        </tr>
                    </tbody>
                </table>

            </div>

            <div class="col-md-6">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td><label><span class="help"> Telepon</span></label></td>
                            <td width="50%">: {{guest.phone}}</td>
                        </tr>
                        <tr>
                            <td><label> <span class="help"> Fax</span></label></td>
                            <td>: {{guest.fax}}</td>
                        </tr>
                        <tr>
                            <td><label> <span class="help"> Email</span></label></td>
                            <td>: {{guest.email}}</td>
                        </tr>
                        <tr>
                            <td><label> <span class="help"> Jenis Kelamin</span></label></td>
                            <td>: {{guest.sex}}</td>
                        </tr>
                        <tr>
                            <td><label> <span class="help"> Tanggal Lahir</span></label></td>
                            <td>: {{guest.date_of_birth}}</td>
                        </tr>
                        <tr>
                            <td><label> <span class="help"> Jenis Identitas</span></label></td>
                            <td>: {{guest.idtype}}</td>
                        </tr>
                        <tr>
                            <td><label> <span class="help"> Tanggal Berlaku</span></label></td>
                            <td>: {{guest.date_of_validation}}</td>
                        </tr>
                        <tr>
                            <td><label> <span class="help"> Nomor Identitas</span></label></td>
                            <td>: {{guest.idcode}}</td>
                        </tr>
                    </tbody>
                </table>


            </div>
            <hr/>
            <div class="col-md-6">
                <h4>History Transaksi</h4>
                <hr/>
                <div class="progress progress-sm">
                  <div class="progress-bar progress-bar-info active progress-bar-striped" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 100%" role="progressbar"> <span class="sr-only">100% Complete (success)</span> </div>
                </div>
                <table style="width: 100%" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="addcharge in addcharges">
                            <td>{{addcharge.tanggal}}</td>
                            <td style="text-align: right;">{{addcharge.ntotal}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-6">
                <h4>Checkin</h4>
                <hr/>
                <div class="progress progress-sm">
                  <div class="progress-bar progress-bar-info active progress-bar-striped" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 100%" role="progressbar"> <span class="sr-only">100% Complete (success)</span> </div>
                </div>
                <table style="width: 100%" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No Bukti</th>
                            <th>Tgl. Reservasi</th>
                            <th>Check In/Out</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="reservation in reservations">
                            <td>{{reservation.nobukti}}</td>
                            <td>{{reservation.tanggal}}</td>
                            <td>{{reservation.checkin}}<br/>{{reservation.checkout}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script type="text/javascript">

</script>
