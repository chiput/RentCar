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
    'submain_location' => 'Check In'
  ]);

  function convert_date($date){
            $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
            return $date;
        } 
?>
<div class="row">
    <div class="col-md-6">
        <div class="white-box">
            <h3 class="box-title m-b-0">Form Peminjaman</h3>
            <p class="text-muted m-b-30"></p>

            <form class="form-horizontal" action="<?php echo $this->pathFor('frontdesk-checkingroup-save'); ?>" method="post">
            <input type="hidden" class="form-control" value="<?php echo @$reservation->id ?>" name="reservation_id">

            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Kode Peminjaman</span></label>
                <div class="col-md-3">
                    <input type="text" class="form-control" value="<?php echo  $this->formValue(@$checkin->checkin_code, $checkin_code) ?>" name="checkin_code" readonly="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Sopir</span></label>
                <div class="col-md-12">
                    <input type="text" class="form-control" value="<?php echo  @$reservation->agent->name ?>" readonly="">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                <label class="col-md-30"> <span class="help"> Pilih Mobil</span></label>
                    <div>
                        <?php foreach ($reservation_details as $reservation_detail) : ?>
                        <label>
                            <input type="checkbox" value="<?php echo $reservation_detail->id; ?>" name="reservation_detail_id[]"
                            <?=$reservation_detail->checkin_at!=null?'checked="checked"':'""'?>
                            >
                                <?php echo @$reservation_detail->room->number; ?> (<?php echo @$reservation_detail->room->roomType->name; ?>)
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Peminjaman</span></label>
                <div class="col-md-6">
                    <input type="text" data-date-format="dd-mm-yyyy" class="form-control mydatepicker" value="<?php echo  $this->formValue(date('d-m-Y', strtotime(@$checkin->checkin_at==''?@$reservation->checkin:@$checkin->checkin_at)), date('d-m-Y')) ?>" name="date_checkin">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control clockpicker" value="<?php echo  $this->formValue(date('H:i', strtotime(@$checkin->checkin_at==''?date('d-m-Y H:i'):@$checkin->checkin_at)), date('H:i')) ?>" name="time_checkin">
                </div>
            </div>
            <div class="form-group">
                <label>
                    <input name="is_compliment" type="checkbox" value="1" <?php if (isset($checkin) && 1 == $checkin->is_compliment) { echo "checked"; } ?> />
                    Compliment
                </label>
            </div>

            <div class="form-group m-b-0">
                <div class="col-md-12">
                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
                <a class="btn btn-danger waves-effect waves-light m-r-10" href="javascript:window.history.back();">Batal</a>
                </div>
            </div>


        </div>
    </div>
    <div class="col-md-6">
        <div class="white-box">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#resv-tab" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Reservation</span></a>
                </li>
                <li role="presentation"><a href="#guest-tab" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Pelanggan</span></a>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="resv-tab">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">No. Reservasi</label>
                            <div class="col-sm-9">
                                <p class="form-control-static">
                                      <?php echo $reservation->nobukti; ?>
                                      <!-- <a href="<?php echo $this->pathFor('frontdesk-reservation-edit', ['id' => $reservation->id]); ?>">Edit Reservasi</a> -->
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Peminjaman</label>
                            <div class="col-sm-9">
                              <p class="form-control-static"><?php echo convert_date(substr($reservation->checkin,0,10))." ".substr($reservation->checkin,10,18); ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Pengembalian</label>
                            <div class="col-sm-9">
                              <p class="form-control-static"><?php echo convert_date(substr($reservation->checkout,0,10))." ".substr($reservation->checkin,10,18); ?></p>
                            </div>
                        </div>
                        <div class="form-group hidden">
                            <label class="col-sm-3 control-label">Dewasa</label>
                            <div class="col-sm-9">
                              <input type="number" class="form-control" value="<?php echo  $this->formValue(@$reservation->adult, 0) ?>" name="adult">
                            </div>
                        </div>
                        <div class="form-group hidden">
                            <label class="col-sm-3 control-label">Anak-anak</label>
                            <div class="col-sm-9">
                              <input type="number" class="form-control" value="<?php echo  $this->formValue(@$reservation->child, 0) ?>" name="children">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jaminan</label>
                            <div class="col-sm-9">
                              <textarea name="remarks" class="form-control"><?php echo  $this->formValue(@$reservation->remarks) ?></textarea>
                            </div>
                        </div>
                        <div class="form-group hidden">
                            <div class="col-sm-9 col-sm-push-3">
                                <a href="<?php echo $this->pathFor('frontdesk-reservation-edit', ['id' => $reservation->id]); ?>" class="btn btn-warning">Edit Reservasi</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="guest-tab">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nama</label>
                            <div class="col-sm-9">
                                <input name="id_guest" type="text" class="form-control hidden" value=" <?php echo $guest->id; ?>" />
                                <input name="name" type="text" class="form-control" value="<?php echo $guest->name; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jenis Kelamin</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="guests_sex">
                                <option value="1">Pria</option>
                                <option value="2" <?=(@$reservation->guest->sex==2?'selected="selected"':'')?>>Wanita</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                              <input name="email" type="text" class="form-control" value=" <?php echo $guest->email; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Alamat</label>
                            <div class="col-sm-9">
                              <input name="address" type="text" class="form-control" value=" <?php echo $guest->address; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Kota</label>
                            <div class="col-sm-9">
                              <input name="city" type="text" class="form-control" value="<?php echo $guest->city; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Kode Pos</label>
                            <div class="col-sm-9">
                              <input name="zipcode" type="text" class="form-control" value="<?php echo $guest->zipcode; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                        <label class="col-sm-3 control-label"> Negara</label>
                        <div class="col-sm-9">
                            <select name="country" class="form-control select2">
                            <?php foreach ($countries as $country): ?>
                                <option value="<?php echo $country->id; ?>" <?php if (isset($guest) && $guest->country_id == $country->id) { echo "selected"; } ?>><?php echo $country->nama; ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Telepon</label>
                            <div class="col-sm-9">
                              <input name="phone" type="text" class="form-control" value="<?php echo $guest->phone; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                        <label class="col-md-3 control-label">Perusahaan</label>
                        <div class="col-md-9">
                            <select name="company" class="form-control select2">
                                <option> -- Pilih Perusahaan -- </option>
                            <?php foreach ($companies as $company): ?>
                                <option <?=($company->id==@$guest->company_id?'selected="selected"':'')?> value="<?php echo $company->id; ?>"><?php echo $company->name; ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tanggal Lahir</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control mydatepicker" data-date-format="dd-mm-yyyy" value="<?php echo @$guest->date_of_birth ?>" name="date_of_birth">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Identitas</label>
                            <div class="col-sm-9">
                              <select name="idtype" class="form-control select2">
                                <?php foreach ($idtypes as $idtype): ?>
                                    <option value="<?php echo $idtype->id; ?>" <?=(@$guest->idtype_id==$idtype->id?'selected="selected"':'')?>><?php echo $idtype->name; ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">No. Identitas</label>
                            <div class="col-sm-9">
                              <input name="idcode" type="text" class="form-control" value="<?php echo $guest->idcode; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tanggal Valid</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control mydatepicker" data-date-format="dd-mm-yyyy" value="<?php echo @$guest->date_of_validation ?>" name="date_of_validation">
                            </div>
                        </div>
                        <div class="form-group hidden">
                            <div class="col-sm-9 col-sm-push-3">
                                <a href="<?php echo $this->pathFor('frontdesk-guest-update', ['id' => $guest->id]); ?>" class="btn btn-warning">Edit Reservasi</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
