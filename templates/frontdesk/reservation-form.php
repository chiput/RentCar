<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Reservasi',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Reservasi',
    'submain_location' => 'Form Reservasi'
  ]);
$det=[];

$canmove = (@$reservation->canmove == 1 || (!isset($reservation->canmove)))? true : false;

?>

<?php if ($this->getSessionFlash('error')): ?>
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('error'); ?>
</div>
<?php endif; ?>

<div class="row" id="reservation-app">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Form Reservasi</h3>
            <p class="text-muted m-b-30"></p>
            <?php if (!is_null(@$errors)): ?>
            <div>
                <p>
                    Error:
                </p>
                <p>
                    <?php echo implode('<br>', $errors); ?>
                </p>
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
            <form class="form-horizontal" action="<?php echo $this->pathFor('frontdesk-reservation-save'); ?>" method="post">
            <input type="hidden" class="form-control" value="<?php echo @$reservation->id ?>" name="id">

            <div class="row">
                <div class="col-md-6">
                    <h3 class="box-title"> Data Reservasi</h3>
                    <hr />

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> No. Bukti</span></label>
                            <div class="col-md-12">
                                <input readonly type="text" class="form-control" value="<?php echo ( (isset($newCode) ? $newCode : @$reservation->nobukti ) ); ?>" name="nobukti">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Status</span></label>
                            <div class="col-md-12">
                                <select class="form-control" name="status">
                                    <option value="0">Reservasi</option>
                                    <!-- <option value="1" <?=@$reservation->status==1?'selected="selected"':''?> >Waiting List</option> -->
                                    <option value="2" <?=@$reservation->status==2?'selected="selected"':''?>>Batal</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group hidden">
                          <div class="checkbox checkbox-success">
                            <input id="canmove" name="canmove" type="checkbox" value="0" <?=!$canmove?'checked="checked"':''?>>
                            <label for="canmove"> Tidak Bisa Pindah </label>
                          </div>
                        </div>


                    </div>

                    <div class="col-md-6">

                        <!-- temporary hidden -->
                        <div class="form-group hidden">
                            <label class="col-md-12"> <span class="help"> Kontrak</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="<?php echo @$reservation->contracts_id ?>" name="contracts_id">
                            </div>
                        </div>
                        <!-- temporary hidden -->
                        <div class="form-group hidden">
                            <label class="col-md-12"> <span class="help"> Waiting List</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="<?php echo @$reservation->waitinglists_id ?>" name="waitinglists_id">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Tanggal</span></label>
                            <div class="col-md-12">
                                <input type="text" data-date-format="dd-mm-yyyy" class="form-control mydatepicker" value="<?php echo convert_date(substr((@$reservation->tanggal == '' ? date('Y-m-d') : @$reservation->tanggal),0,10)) ?>" name="tanggal">
                            </div>
                        </div>

                        <div class="form-group hidden">
                            <label class="col-md-12"> <span class="help"> Dewasa</span></label>
                            <div class="col-md-12">
                                <input type="number" class="form-control" value="<?php echo @$reservation->adult | 0 ?>" name="adult">
                            </div>
                        </div>

                        <div class="form-group hidden">
                            <label class="col-md-12"> <span class="help"> Anak-anak</span></label>
                            <div class="col-md-12">
                                <input type="number" class="form-control" value="<?php echo @$reservation->child | 0?>" name="child">
                            </div>
                        </div>

                        <div class="form-group" id="canceldate">
                            <label class="col-md-12"> <span class="help"> Tanggal Batal</span></label>
                            <div class="col-md-12">
                                <input type="text" data-date-format="dd-mm-yyyy" class="form-control mydatepicker" value="<?php echo convert_date(substr((@$reservation->canceldate==''?date('Y-m-d'):@$reservation->canceldate),0,10)) ?>" name="canceldate">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Sopir</span></label>
                            <div class="col-md-12">
                                <select name="agent_id" class="form-control">
                                    <option value="0"> -- Pilih Sopir -- </option>
                                <?php foreach ($agents as $agent): ?>
                                    <option <?=($agent->id==@$reservation->agent_id?'selected="selected"':'')?> value="<?php echo $agent->id; ?>"><?php echo $agent->name; ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Tanggal Check In </span></label>
                            <div class="<?=$canmove?'input-daterange':''?> input-group" id="date-range" data-date-format="dd-mm-yyyy">
                                    <input  type="text" class="form-control" name="checkin"
                                    value="<?=convert_date(substr(@$reservation->checkin,0,10))==""?date("d-m-Y"):convert_date(substr(@$reservation->checkin,0,10))?>"
                                    <?=!$canmove?'readonly="readonly"':''?>
                                    >
                                <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                                    <input type="text" class="form-control" name="checkout"
                                    <?php $startDate = date("d-m-Y"); ?>
                                    value="<?=convert_date(substr(@$reservation->checkout,0,10))==""?date("d-m-Y" , strtotime("$startDate +1 day")):convert_date(substr(@$reservation->checkout,0,10))?>"
                                    <?=!$canmove?'readonly="readonly"':''?>
                                    >
                            </div>
                        </div>

                        <table class="table" id="room">
                            <thead>
                                <tr>
                                    <th>Nama Mobil</th>
                                    <th>Jenis Mobil</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(!is_object(@$reservation->details)) $reservation=(object)["details"=>[]];
                                        $harga = 0;
                                        foreach (@$reservation->details as $detail) {
                                    ?>
                                <tr>
                                    <td rowspan="2"><?=$detail->room->number?><input type="hidden" name="rooms_id[]" value="<?=$detail->rooms_id?>" />
                                    <?php if($canmove) { ?>
                                      <a href="javascript:void(0)"  data-toggle="tooltip" onclick="deleteRoom(this)" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i></a>
                                      <?php } ?>
                                    </td>
                                    <td><?=$detail->room->roomType->name?></td>
                                    <td><input type="number" class="form-control" name="price[]" value="<?=$detail->price?>" /></td>
                                </tr>
                                <tr>
                                    <td>Harga Sopir</td>
                                    <td><input type="number" class="form-control" name="priceExtra[]" value="<?=$detail->priceExtra?>" /></td>
                                </tr>
                                <?php
                                        $harga = $harga + $detail->price + $detail->priceExtra;
                                        }
                                    //} ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colSpan="2">
                                      <?php if($canmove) { ?>
                                        <a href="javascript:void(0)" alt="default" data-toggle="modal" data-target=".mymodal" onclick="window.getRooms()" class="model_img img-responsive btn btn-default">Tambah Mobil</a>
                                      <?php } ?>
                                    </td>
                                    <td colSpan="2" id="tot">
                                        <b>Total Harga: </b>Rp. <?= number_format($harga,0,',','.'); ?> 
                                    </td>
                                        
                                      <script type="text/javascript">
                                        function findTotal()
                                        {
                                        var sum=0;
                                        var texts = document.getElementsByName("price[]");
                                        var price = document.getElementsByName("priceExtra[]");
                                        var format = new curFormatter();

                                        for( var i = 0; i < texts.length; i ++ ) {
                                            var n = parseInt(format.unformat(texts[i].value));
                                            var z = parseInt(format.unformat(price[i].value));
                                            sum = sum + n + z;
                                        }

                                        var number_string = sum.toString(),
                                            sisa    = number_string.length % 3,
                                            rupiah  = number_string.substr(0, sisa),
                                            ribuan  = number_string.substr(sisa).match(/\d{3}/g);
                                                
                                        if (ribuan) {
                                            separator = sisa ? '.' : '';
                                            rupiah += separator + ribuan.join('.');
                                        }


                                        document.getElementById("tot").innerHTML='<b>Total Harga: </b>Rp. '+rupiah;
                                        }
                                     </script>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Jaminan </span></label>
                        <div class="col-md-12">
                                <input type="text" class="form-control" value="<?php echo @$reservation->remarks ?>" name="remarks">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-6" id="guestInfo">
                    <h3 class="box-title"> Data Pelanggan</h3>
                        <hr />
                        <div class="col-md-12">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#guestsModal" class="btn btn-primary"><i class="fa fa-search"></i> Cari</a>

                                <a href="javascript:void(0)" onclick="clearGuest()" class="btn btn-danger"><i class="fa fa-times"></i> Bersihkan</a>
                        </div>
                    <div class="col-md-6">

                        <input type="hidden"  value="<?php echo @$reservation->guests_id?>" name="guests_id">
                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Nama</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="<?php echo @$reservation->guest->name ?>" name="guests_name">
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Alamat</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="<?php echo @$reservation->guest->address ?>" name="guests_address">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Perusahaan / Institusi</span></label>
                            <div class="col-md-12">
                                <select name="guests_company_id" class="form-control" id="guests_company_id">
                                    <option> -- Pilih Perusahaan -- </option>
                                <?php foreach ($companies as $company): ?>
                                    <option <?=($company->id==@$reservation->guest->company_id?'selected="selected"':'')?> value="<?php echo $company->id; ?>"><?php echo $company->name; ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Tanggal Lahir</span></label>
                            <div class="col-md-12">
                                <input type="text" data-date-format="dd-mm-yyyy" class="form-control mydatepicker" value="<?php echo convert_date(@$reservation->guest->date_of_birth) ?>" name="guests_date_of_birth">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Jenis Kelamin</span></label>
                            <div class="col-md-12">
                                <select class="form-control" name="guests_sex">
                                <option value="1">Pria</option>
                                <option value="2" <?=(@$reservation->guest->sex==2?'selected="selected"':'')?>>Wanita</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Jenis Identitas</span></label>
                            <div class="col-md-12" >
                                <select class="form-control" name="guests_idtype_id">
                                <?php foreach($idtypes as $idtype){ ?>
                                <option value="<?=$idtype->id?>"
                                    <?=(@$reservation->guest->idtype_id==$idtype->id?'selected="selected"':'')?> >
                                    <?=$idtype->name?>
                                    </option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Kode Identitas</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="<?php echo @$reservation->guest->idcode ?>" name="guests_idcode">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Negara</span></label>
                            <div class="col-md-12">
                                <select class="form-control" name="guests_countries_id">
                                <?php foreach($countries as $country){ ?>
                                <option value="<?=$country->id?>"
                                    <?=(@$reservation->guest->country_id==$country->id?'selected="selected"':'')?> >
                                    <?=$country->nama?>
                                </option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> State</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="<?php echo @$reservation->guest->state ?>" name="guests_state">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Kota</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="<?php echo @$reservation->guest->city ?>" name="guests_city">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Kode pos</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="<?php echo @$reservation->guest->zipcode ?>" name="guests_zipcode">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Phone</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="<?php echo @$reservation->guest->phone ?>" name="guests_phone">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Fax</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="<?php echo @$reservation->guest->fax ?>" name="guests_fax">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> E-mail</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="<?php echo @$reservation->guest->email ?>" name="guests_email">
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Jenis Kartu Kredit</span></label>
                            <div class="col-md-12">
                                <select name="jeniskartukredit" class="form-control">
                                <option value="0">---</option>
                                <?php foreach ($creditcards as $card) : ?>
                                <option value="<?php echo $card->id ?>" <?php if (isset($reservation->creditcard_id) && $card->id == $reservation->creditcard_id) { echo "selected"; } ?>><?php echo $card->name ?></option>
                                <?php endforeach; ?>
                            </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> No. Kartu Kredit</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="<?php echo @$reservation->creditcard ?>" name="creditcard">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Tanggal Kedaluwarsa</span></label>
                            <div class="col-md-12">
                                <input type="text" data-date-format="dd-mm-yyyy" class="form-control mydatepicker" value="<?php echo convert_date(@$reservation->creditcarddate) ?>" name="creditcarddate">
                            </div>
                        </div> -->

                    </div>
                </div>

            </div>

            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
            <a class="btn btn-danger waves-effect waves-light m-r-10" href="javascript:window.history.back();">Batal</a>

            </form>
        </div>
    </div>
</div>

<div id="guestsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myModalLabel">Daftar Pelanggan</h4>
      </div>
      <div class="modal-body">
        <table class="table datatable myDataTable">
            <thead>
                <tr>
                    <th>Aksi</th>
                    <th>ID Identitas</th>
                    <th>Nama</th>
                    <th>Negara</th>
                    <th>Email</th>
                    <th>Black List</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($guests as $guest): ?>
                <tr>
                    <td>
                        <a href="javascript:void(0)" data-guest-json='<?=$guest?>'  onclick="getGuest(this)" data-toggle="tooltip" data-original-title="Pilih" data-dismiss="modal"><button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Pilih</button></a>
                    </td>
                    <td><?=$guest->idcode?></td>
                    <td><?=$guest->name?></td>
                    <td><?=$guest->country->nama?></td>
                    <td><?=$guest->email?></td>
                    <td><?=($guest->is_blacklist==1?"Black List":"")?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
      </div>
     <!--  <div class="modal-footer">
        <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
      </div> -->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div id="roomModal" class="modal fade" tabIndex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display:none" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="mySmallModalLabel">Daftar Mobil</h4>
            </div>
            <div class="modal-body">
                <table id="roomTable" class="table toggle-circle">
                    <thead>
                        <tr>
                            <th>Nama Mobil</th>
                            <th>Plat Nomor</th>
                            <th>Jenis Mobil</th>
                            <th hidden>Harga</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="theurl" value="<?php echo $this->pathFor('frontdesk-reservation-room',["checkin"=>"0","checkout"=>"0","agent"=>"0"]); ?>">
<script type="text/javascript">

</script>
