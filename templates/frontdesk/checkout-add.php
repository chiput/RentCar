<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Tambah Pengembalian - Frontdesk',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Front Desk',
    'submain_location' => 'Tambah Pengembalian'
  ]);
  function convert_date($date){
    $exp = explode('-', $date);
    if (count($exp)==3) {
        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
    }
    return $date;
}
?>
<style type="text/css">
    @media print {
        .printpreview {
            display: none !important;
        }
        #hiddenhrg {
            display: none;  
        }
        .printshow {
            display: block !important; 
        }
        .white-box {
            font-size: 10px !important;
        }
        td, th {
            padding: 5px 10px !important;
        }
        h4 {
            margin-top: 10px !important;
            font-size: 12px !important;
        }
        h2 {
            font-size: 16px !important;
            margin-bottom: 0px !important;
        }
        p {
            font-size: 10px !important;
        }
        #selected-checkin {
            margin-bottom: 20px !important;
        }
        .printpadding {
            padding: 10px;
        }
        table {
            margin-bottom: 5px !important;
        }
        footer {
            display: none !important;
        }
    }
    .printshow {
        display: none;
    }
    .printpreview {
        display: block;
    }
</style>
<div id="checkout-form">
    <input type="hidden" value="<?php echo $this->pathFor('frontdesk-checkout-add-deposit'); ?>" v-model="url.deposit"/>
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <div class="hidden-print">
                    <h3 class="box-title m-b-0">Form Pengembalian
                        <span class="pull-right">
                            <a href="#" class="btn btn-default" onclick="window.print();">Print Preview</a>
                        </span>
                    </h3>
                    <p class="text-muted m-b-30"></p>
                </div>
                <div class="visible-print-block">
                    <h3 class="box-title m-b-0">Pengembalian Print Preview</h3>
                </div>

                <!-- print show -->
                    <div class="printshow">
                        <table class="header">
                          <tbody>
                            <tr>
                              <td><img width="70" src="<?=$this->baseUrl()?>img/<?=$options['profile_logo']?>"></td>
                              <td style="padding-left: 20px">
                                <h2><?=$option['profile_name']?></h2>
                                <p><?=$option['profile_address']?><br/>
                                Phone : <?=$option['profile_phone']?> Fax : <?=$option['profile_fax']?><br/>
                                Website : <?=$option['profile_website']?> Email : <?=$option['profile_email']?></p>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <hr style="margin-top: -10px !important;" />
                        <label>Tanggal: <?php echo date('d-m-Y'); ?></label><br/>
                        <label>No Bukti: <?php echo  $this->formValue(@$checkout->checkout_code, $checkout_code) ?></label>
                    </div>

                <!-- end print show -->

                <form class="form-horizontal" action="<?php echo $this->pathFor('frontdesk-checkout-save'); ?>" method="post" id="form-checkout">
                    <input type="hidden" v-model="getResvDetailURL" value="<?php echo $this->pathFor('frontdesk-checkout-addservices'); ?>" />

                    <div id="selected-checkin" class="form-group">
                        <roomtablecontainer v-if="displayRoomTable">
                        <h4>Mobil</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        Nama Mobil
                                    </th>
                                    <th>
                                        Jenis Mobil
                                    </th>
                                    <th>
                                        Nama Pelanggan
                                    </th>
                                    <th>
                                        Harga
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="sCheckin in selectedCheckin">
                                    <input type="hidden" value="{{ sCheckin }}" name="reservation_detail_id[]">
                                    <td>{{ checkInItems[sCheckin].roomNumber }}</td>
                                    <td>{{ checkInItems[sCheckin].roomType }}</td>
                                    <td>{{ checkInItems[sCheckin].guest_name }}</td>
                                    <td>
                                        {{ checkout.harga}}
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3">Total Room</th>
                                    <th>{{ checkout.totalRooms }}</th>
                                </tr>
                            </tfoot>
                        </table>
                        </roomtablecontainer>
                        <button class="btn hidden-print" data-toggle="modal" data-target="#modal-reservation" type="button">Pilih Pengembalian</button>

                        <label id="hiddenhrg"><input type="checkbox" name="hiddenhrgkamar" value="1" :true-value="1" :false-value="0"> Hidden Harga Mobil</label>
                        <div class="printpadding"></div>
                        <h4>Biaya Tambahan</h4>
                        <div class="progress" v-show="loading.biayaTambahan">
                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                <span class="sr-only">100% Complete</span>
                            </div>
                        </div>
                        <div v-if="displayAddChargeDataTable" id="additional-service-container">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            Deskripsi
                                        </th>
                                        <th>
                                            No Bukti
                                        </th>
                                        <th>
                                            Price
                                        </th>
                                        <th>
                                            Qty
                                        </th>
                                        <th>
                                            Total
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="sCharge in addChargeData">
                                        <td>{{ sCharge.name }}</td>
                                        <td>{{ sCharge.nobukti }}</td>
                                        <td>
                                            {{ sCharge.sell }}
                                        </td>
                                        <td>
                                            {{ sCharge.qty }}
                                        </td>
                                        <td>
                                            {{ sCharge.subtotal }}
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4">Total Biaya Tambahan</th>
                                        <th>{{ checkout.totalAddCharge }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div v-else>
                            <p><i>Biaya tambahan tidak tersedia.</i></p>
                        </div>
                    </div>

                    <!-- print show -->
                        <div class="printshow">
                            <label>Subtotal: {{ checkout.subtotal }}</label><br/>
<!--                             <label>Discount: {{ checkout.discountPercent }} %</label><br/>
                            <label>Service Charge: {{ checkout.servicePercent }}</label><br/>
                            <label>PPN: {{ checkout.taxPercent }}</label><br/> -->
                            <label>Deposit: {{ checkout.deposit }}</label><br/>
                            <label>Total: {{ checkout.total }}</label>

                        </div>

                    <!-- end print show -->


                    <!-- start preview -->
                    <div class="printpreview">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="help"> Tanggal</span></label>
                                    <div class="col-md-12">
                                        <input type="text" data-date-format="dd-mm-yyyy" class="form-control mydatepicker" value="<?php echo date('d-m-Y'); ?>" name="date_checkout">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="help"> Jam</span></label>
                                    <div class="col-md-12">
                                        <input type="text" data-date-format="yyyy-mm-dd" class="form-control clockpicker" value="<?php echo date('H:i'); ?>" name="time_checkout">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="help"> No. Bukti</span></label>
                                    <div class="col-md-12">
                                        <input type="text" readonly class="form-control" value="<?php echo  $this->formValue(@$checkout->checkout_code, $checkout_code) ?>" name="checkout_code">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Subtotal</span></label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" value="{{ checkout.subtotal }}" name="subtotal" v-model="checkout.subtotal">
                            </div>
                        </div>

                        <div class="form-group hidden-print">
                            <div class="col-md-12">
                                <label><input type="checkbox" name="displayDiscount" v-model="displayDiscount" :true-value="1" :false-value="0"> Tampilkan discount, service, PPN</label>
                            </div>
                        </div>

                        <div class="row" id="dicount-ppn">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="help"> Discount</span></label>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="{{ checkout.discountPercent }}" name="discount_percent" v-model="checkout.discountPercent">
                                            <span class="input-group-addon">%</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" value="{{ checkout.discount }}" name="discount" v-model="checkout.discount">
                                    </div>
                                    <div class="col-md-12">
                                        <label><input type="radio" name="is_discount_room_only" v-model="checkout.is_discount_room_only" :value="0"> Semua</label>
                                        <label><input type="radio" name="is_discount_room_only" v-model="checkout.is_discount_room_only" :value="1"> Mobil</label>
                                        <label><input type="radio" name="is_discount_room_only" v-model="checkout.is_discount_room_only" :value="2"> Biaya Tambahan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="help"> Service Charge</span></label>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="{{ checkout.servicePercent }}" v-model="checkout.servicePercent" name="service_percent">
                                            <span class="input-group-addon">%</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" value="{{ checkout.service }}" v-model="checkout.service" name="service_charge">
                                    </div>
                                    <div class="col-md-12">
                                        <label><input type="radio" name="is_service_room_only" v-model="checkout.is_service_room_only" :value="0"> Semua</label>
                                        <label><input type="radio" name="is_service_room_only" v-model="checkout.is_service_room_only" :value="1"> Mobil</label>
                                        <label><input type="radio" name="is_service_room_only" v-model="checkout.is_service_room_only" :value="2"> Biaya Tambahan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="help"> PPN</span></label>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="{{ checkout.taxPercent }}" v-model="checkout.taxPercent" name="tax_percent">
                                            <span class="input-group-addon">%</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" value="{{ checkout.tax }}" v-model="checkout.tax" name="tax_charge">
                                    </div>
                                    <div class="col-md-12">
                                        <label><input type="radio" name="is_tax_room_only" v-model="checkout.is_tax_room_only" :value="0"> Semua</label>
                                        <label><input type="radio" name="is_tax_room_only" v-model="checkout.is_tax_room_only" :value="1"> Mobil</label>
                                        <label><input type="radio" name="is_tax_room_only" v-model="checkout.is_tax_room_only" :value="2"> Biaya Tambahan</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="progress" v-show="loading.deposit">
                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                <span class="sr-only">100% Complete</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3">
                                <label class="col-md-12"> <span class="help"> Deposit</span></label>
                                <div>
                                    <input type="text" class="form-control" value="{{ checkout.deposit }}" v-model="checkout.deposit" name="deposit">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="col-md-12"> <span class="help"> Refund</span></label>
                                <div>
                                    <input type="text" class="form-control" value="{{ checkout.refund }}" v-model="checkout.refund" name="refund" readonly="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="col-md-12"> <span class="help"> Total</span></label>
                                <div>
                                    <input type="text" class="form-control" value="{{ checkout.total }}" v-model="checkout.total" name="total" readonly="">
                                </div>
                            </div>
                        </div>

                        <hr />
                        <h3>Pembayaran</h3>

                        <div class="form-group">
                            <div class="col-md-3">
                                <label class="col-md-12"> <span class="help">Nominal Tunai</span></label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" value="{{ checkout.cash }}" v-model="checkout.cash" name="cash" onkeyup="kalkulasi()">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="col-md-12"> <span class="help">Remaks</span></label><br/>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="remarks" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group hidden">
                            <div class="col-md-3">
                                <label class="col-md-12"> <span class="help"> Creditcard</span></label>
                                <select name="creditcard_id" class="form-control">
                                    <option value="0">---</option>
                                    <?php foreach ($creditcards as $card) : ?>
                                    <option value="<?php echo $card->id ?>" <?php if (isset($checkin) && $card->id == $checkin->creditcard_id) { echo "selected"; } ?>><?php echo $card->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="col-md-12"> <span class="help"> Nomor Credit Card</span></label>
                                <input type="text" class="form-control" value="<?php echo  $this->formValue(@$checkout->creditcard_number) ?>" name="creditcard_number">
                            </div>
                            <div class="col-md-3">
                                <label class="col-md-12"> <span class="help"> Total CreditCard</span></label>
                                <input type="text" class="form-control" value="{{ checkout.creditcardAmount }}" v-model="checkout.creditcardAmount" name="creditcard_amount" onkeyup="kalkulasi()">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Balance</span></label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" value="{{ checkout.paymentChange }}" v-model="checkout.paymentChange" name="paymentChange" readonly="">
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" id="buttonSaveCheckout">Simpan</button>
                            <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('frondesk-checkout')?>">Batal</a>
                        </div>
                    </div><!-- end div print preview -->
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-reservation">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Pilih Peminjaman</h4>
                </div>
            <div class="modal-body">
                <table class="table table-striped myDataTable">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Tanggal Resv</th>
                            <th>Mobil</th>
                            <th>No. Resv</th>
                            <th>Peminjaman</th>
                            <th>Pengembalian</th>
                            <th>Nama</th>
                            <th>Sopir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $checkinItems = []; ?>
                        <?php foreach ($checkins as $checkin) :?>
                        <tr>
                            <td>
                            <input type="checkbox" value="<?php echo $checkin->id ?>" name="checkin_id" class="checkin-id" v-model="selectedCheckin" />
                            </td>
                            <td><?php echo convert_date(substr($checkin->reservation->tanggal,0,10)) ?></td>
                            <td align="center"><?php echo $checkin->room->number ?>
                            <?php
                                if($checkin->change_code == 1){
                                    echo '<br/><span class="label label-warning">Pindah</span>';
                                }
                            ?></td>
                            <td><?php echo $checkin->reservation->nobukti ?></td>
                            <td><?php echo convert_date(substr($checkin->checkin_at,0,10))." ".substr($checkin->checkin_at,10,18); ?></td>
                            <td><?php echo convert_date(substr($checkin->reservation->checkout,0,10))." ".substr($checkin->reservation->checkout,10,18); ?></td>
                            <td><?php echo $checkin->reservation->guest->name ?></td>
                            <td><?php echo @$checkin->reservation->agent->name ?></td>
                        </tr>
                        <?php
                            $checkinItems[$checkin->id] = [
                                'id' =>  $checkin->id,
                                'roomNumber' =>  $checkin->room->number,
                                'roomType' => $checkin->room->roomType->name,
                                'price' => $checkin->price,
                                'priceExtra' => $checkin->priceExtra,
                                'guest_name' => $checkin->reservation->guest->name
                            ];
                        ?>
                        <?php endforeach; ?>
                    <tbody>
                </table>
            </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div><!-- id="checkout-form" -->
<script>
    window.checkin = {};
    window.checkin.checkInItems = <?php echo json_encode($checkinItems, JSON_NUMERIC_CHECK); ?>;

    $("document").ready(function(){
        var total = $("input[name=paymentChange]").val();

        if(total >= 0){
           $('#buttonSaveCheckout').removeAttr("disabled");
        } else {
            $('#buttonSaveCheckout').attr("disabled", "disabled");
            $('#buttonSaveCheckout').prop('disabled', true)
        }
    });

    $('#buttonSaveCheckout').attr("disabled", "disabled");
    function kalkulasi() {
        var total = $("input[name=paymentChange]").val();

        if(total >= 0){
           $('#buttonSaveCheckout').removeAttr("disabled");
        } else {
            $('#buttonSaveCheckout').attr("disabled", "disabled");
            $('#buttonSaveCheckout').prop('disabled', true)
        }

    }
    $(document).ready(function(){
        var format = new curFormatter();
        format.input("[name='subtotal']");
        format.input("[name='discount']");
        format.input("[name='service_charge']");
        format.input("[name='tax_charge']");
        format.input("[name='deposit']");
        format.input("[name='refund']");
        format.input("[name='total']");
        format.input("[name='cash']");
        format.input("[name='creditcard_amount']");
        format.input("[name='paymentChange']");
    });
</script>
