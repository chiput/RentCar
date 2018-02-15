<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Kasir',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Restorant',
    'submain_location' => 'Form Kasir'
  ]);

   function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }

//print_r($reservations);
$arrStatus=["Out Of Service","Dirty"];
?>
<?php if (@$errors!=""): ?>
<div class="row">
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php foreach($errors as $error){
            echo $error."<br>";
        } ?>
    </div>
</div>
<?php endif; ?>
<div class="row">
    <div class="col-sm-8">
        <div class="white-box">
            <h3 class="box-title m-b-0">Form Kasir </h3>
            <p class="text-muted m-b-30"></p>
            <form class="form-horizontal" method="POST" action="<?php echo $this->pathFor('kasirku-save'); ?>">
            <div class="row">
                    <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Table</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?= @$reskasirku->meja ?>" name="meja">
                        </div>
                    </div>
                    </div>
                    <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Pax</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?= @$reskasirku->pax ?>" name="kapasitas">
                        </div>
                    </div>
                    </div>
                    <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Waiters</span></label>
                        <div class="col-md-12">
                           <select class="form-control" name="waiter">
                                <option value="">-Pilih Waiters-</option>
                                <?php foreach($waiters as $waiter) { ?>
                                    <option value="<?=$waiter->id;?>" <?php if($waiter->id==@$reskasirku->waiters_id){ echo "selected"; } ?>><?=$waiter->nama?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-12"> <span class="help">Keterangan</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="<?= @$reskasirku->keterangan ?>" name="keterangan">
                            </div>
                        </div>
                    </div>
                </div>

                <h4 class="box-title m-b-0">Pesanan </h4>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-3">
                                <input type="text" id="kuantita" class="form-control" value="" name="qty" placeholder="kuantitas">
                            </div>
                            <div class="col-md-9">
                               <select  class="form-control select2" name="menu" id='menuid' onchange="TambahrRow()">
                                <option>-Pilih Menu-</option>
                                <?php foreach($Menus as $menu) { ?>
                                    <option value="<?=$menu->id?>'<?=$menu->kode;?>'<?=$menu->nama;?>'<?=$menu->hargajual;?>"><?=$menu->kode?> - <?=$menu->nama?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-12">
                                 <table id="tblmenu" class="table table-striped table-bordered">
                                 <thead>
                                    <tr>
                                        <th style="width: 78px;">Hapus</th>
                                        <th style="width: 100px;">Qty</th>
                                        <th colspan="2" style="width: 250px;">Menu</th>
                                        <th style="width: 200px;">@Harga</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody class="beer">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6">
                                            <a href="javascript:void(0)" onclick="tambahanmenu()" data-toggle="modal" data-target="#goods-modal" data-original-title="Tambah"> <i class="fa fa-plus-circle"></i> </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: right;">Total Harga</td>
                                        <td id="totalharga" name="totalharga">Rp.
                                        </td>
                                    </tr>
                                </tfoot>
                                </table>
                                <br/>
                                <div class="col-md-7" style="float: right; margin-right: -5px;">
                                    <div class="form-group">
                                        <div class="col-md-5">
                                            <label class="col-md-4 control-label"><span class="help">Diskon :</span></label>
                                            <div class="col-md-6">
                                                <input type="number" id="diskon" class="form-control" value="<?= @$reskasirku->diskon ?>" name="diskon" onkeyup="diskonbro()">
                                            </div>
                                            <label class="control-label"><span class="help">%</span></label>
                                        </div>
                                        <div class="col-md-7" style="float: right;">
                                            <label class="col-md-2 control-label"><span class="help">Rp.</span></label>
                                            <div class="col-md-9">
                                                <input type="text" id="totaldiskon" name="totaldiskon" placeholder="Total Bayar" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="text" id="totalharganya" name="totalnya" class="hidden" value="<?= @$reskasirku->total?>" />
                                <input type="text" id="bayar" name="bayar" class="hidden"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <button style="float: right;" class="btn btn-default btn-rounded waves-effect waves-light"><span class="btn-label"><i class="fa fa-print"></i></span>Print</button>
                            <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('kasirku')?>">Batal</a>
                        </div>
                    </div>
                </div>
            <!-- </form> -->
        </div>
    </div>
    <div class="col-md-4 form-horizontal">
        <div class="white-box">
            <!-- <form class="form-horizontal"> -->
            <div class="form-group">
                <label class="col-sm-3 control-label" style="text-align: left;">No. Bukti</label>
                <div class="col-md-9">
                     <input readonly type="text" class="form-control" value="<?php if(@$Respesanan->nobukti){echo @$Respesanan->nobukti;}else{ echo @$NoBukti;}  ?><?= @$reskasirku->nobukti?>" name="nobukti" id="nobukti">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" style="text-align: left;">Tanggal</label>
                <div class="col-md-9" id="date-range" data-date-format="dd-mm-yyyy">
                        <input  type="text" class="form-control" name="date" value="<?php echo convert_date(@$date) ?><?= convert_date(@$reskasirku->tanggal)?>" >
                </div>
            </div>
            <h4></h4>
            <hr>
            <label><h4 class="box-title m-b-0">Payment</h4></label>
            <div id="shcompany">
                <hr>
                <div class="form-group">
                    <label class="col-md-3 control-label" style="text-align: left;"><b>Kartu Kredit</b></label>
                    <div class="col-md-9">
                        <select name="jeniskartukredit" class="form-control">
                            <option value="0">---</option>
                            <?php foreach ($creditcards as $card) : ?>
                            <option value="<?php echo $card->id ?>" <?php if(@$reskasirku->jenis_kartukredit == $card->id){ echo 'selected'; }?>><?= $card->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-5 control-label" style="text-align: right;">Nominal</span></label>
                    <div class="col-md-7">
                        <input id="totalcreditcard" type="text" class="form-control" value="<?= @$reskasirku->kartubayar?>" v-model="checkout.creditcardAmount" name="totalcreditcard" onkeyup="kalkulasi()">
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="col-md-3 control-label" style="text-align: left;"><b>Bill ke Kamar</b></label>
                    <div class="col-md-9">
                        <select  class="form-control select2" name="nokamarid" id='nokamarid'  <?=@$nokamarDis?> >
                        <option value=''>- Pilih Kamar -</option>
                        <?php foreach($Rooms as $Room) { 
                            if(@$reskasirku->checkinid==$Room->id){
                                $selected = "selected";
                            } else {
                                $selected = "";
                            }?>
                          <option value="<?=$Room->id?>" <?= $selected; ?>><?=$Room->room->number?> | <?= $Room->reservation->guest->name?></option>
                          <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-5 control-label" style="text-align: right;">Nominal</label>
                    <div class="col-md-7">
                        <input id="totalkamar" type="text" class="form-control" value="<?php echo @$reskasirku->totalkamar; ?>" v-model="checkout.creditcardAmount" name="totalkamar" onkeyup="kalkulasi()">
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="col-sm-3 control-label" style="text-align: left;"><b>Cash</b></label>
                    <div class="col-md-9">
                         <input id="cash" type="text" class="form-control" value="<?php echo @$reskasirku->tunai; ?>" v-model="checkout.cash" name="cash" onkeyup="kalkulasi()">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <input id="pembayaran" type="text" class="form-control" placeholder="Total Pembayaran" value="<?php echo @$reskasirku->bayar; ?>" v-model="checkout.cash" name="pembayaran" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <input id="kembalian" readonly type="text" class="form-control" placeholder="kembali" value="<?php echo @$reskasirku->kembalian; ?>" v-model="checkout.cash" name="kembalian">
                    </div>
                </div>
            </div>
            <input  type="text" class="hidden" id='jumrow' name='jumrow'>
            <input type="text" class="hidden" name="checks" value="<?= @$check;?>">
            <input type="text" class="hidden" name="zid" value="<?= @$reskasirku->id;?>">
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var format = new curFormatter();
        format.input("[name='totalharga']");
        format.input("[name='totaldiskon']");
        format.input("[name='totalcreditcard']");
        format.input("[name='totalkamar']");
        format.input("[name='cash']");
    });

    $('#paymentnya').click(function () {
         var $this = $(this);
         if ($this.is(':checked')) {
             $('#shcompany').show();
         } else {
             $('#shcompany').hide();
         }
     });

    function kalkulasi(){
        var format = new curFormatter();
        cash=CekNanNParseInt(format.unformat($('#cash').val()));
        cc=CekNanNParseInt(format.unformat($('#totalcreditcard').val()));
        kmr=CekNanNParseInt(format.unformat($('#totalkamar').val()));
        tot=CekNanNParseInt(format.unformat($('#totalharga').val()));
        total=format.format(format.unformat(cash)+format.unformat(cc)+format.unformat(kmr));
        kembalian = format.format(format.unformat(tot)-format.unformat(total));
        document.getElementById('pembayaran').value = total;
        document.getElementById('kembalian').value = kembalian;
    }

    function diskonbro(){
        var format = new curFormatter();
        diskon=CekNanNParseInt(format.unformat($('#diskon').val()));
        totalharga=CekNanNParseInt(format.unformat($('#totalharganya').val()));
        diskon = format.unformat(totalharga) * format.unformat(diskon) / 100;
        total = format.unformat(totalharga) - format.unformat(diskon);
        $('#totalharga').val(total);

        var number_string = total.toString(),
            sisa    = number_string.length % 3,
            rupiah  = number_string.substr(0, sisa),
            ribuan  = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        
        document.getElementById('totaldiskon').value = rupiah;
    }

    function GetTotalMenu(){
        var format = new curFormatter();
        var rowCount;
        rowCount = $('#tblmenu tr').length;
        rowCount=rowCount-2;

        var finaltotal=0;
        var tot; 
        for (x = 0; x < rowCount; x++) {
            //alert($('#total_'+x).val());
            tot = $('#total_'+x).val();
            finaltotal=finaltotal+CekNanNParseInt(format.unformat(tot));
        }

        $('#totalharga').val(finaltotal);

        var number_string = finaltotal.toString(),
            sisa    = number_string.length % 3,
            rupiah  = number_string.substr(0, sisa),
            ribuan  = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        $('#totalharganya').val(finaltotal);
        document.getElementById("totalharga").innerHTML='Rp. '+rupiah;


      }
    function TambahrRow(){
        var format = new curFormatter();
        var x = document.getElementsByName('qty')[0].value;
        var e = document.getElementById("menuid");
        if(x==""){
            document.getElementById("kuantita").focus();
        } else {
            var strUser = e.options[e.selectedIndex].value;

            var parts = strUser.split("'")
            var total = parseInt(format.unformat(parts[3]))*parseInt(x);

            var i=$('#tblmenu tr').length-2;

            var number_string = total.toString(),
                sisa    = number_string.length % 3,
                rupiah  = number_string.substr(0, sisa),
                ribuan  = number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            var update=false;
            var idupdate=0;
            for (var j = 0 ; j < i; j++) {


                // if($('#ids_'+j).val()==id){
                //     update=true;
                //     idupdate=j;


                // }
            }
             if(update){

               var jumlah= CekNanNParseInt($('#kuantitas_'+idupdate).val())+1;

               $('#qty'+idupdate).val(jumlah);
               total($('#qty'+idupdate).val(),'id_'+idupdate);

              // hitungJumlah(idupdate);

            }else{

            $('#tblmenu').find('tbody').append(
                "<tr>"+
                    "<td>"+
                        "<a href='javascript:void(0)'  data-toggle='tooltip' onclick='del(this)'' data-original-title='Hapus'> <i class='fa fa-close text-danger'></i></a>"+
                    "</td>"+
                    "<td>"+
                        "<input onkeyup='hartot("+i+");GetTotalMenu();' onclick='hartot("+i+");GetTotalMenu();' class='form-control' type='number' name='qty[]' id='qty_"+i+"' value='"+x+"'style='width:60px;'/>"+
                    "</td>"+
                    "<td colspan='2'>"+parts[2]+"</td>"+
                    "<td>"+format.format(parts[3])+"</td>"+
                    "<td>"+
                        "<input id='harga_"+i+"' class='hidden' value='"+parts[3]+"' name='harga_"+i+"'/>"+
                        "<input class='hidden' id='ids_"+i+"' value='"+parts[0]+"' name='ids[]'/>"+
                        "<input class='form-control' id='total_"+i+"' value='"+format.format(total)+"' name='hargatot[]' readonly/>"+
                        "<input type='hidden' class='form-control' value='0' name='id[]' id='id_"+i+"'>"+
                    "</td>"+
                "</tr>");



            $('#kuantitas_'+i).focus();
            var rowCount = $('#tblmenu tr').length-2;
            $('#jumrow').val(rowCount);
            i=i+1;
            }
            $('.select2').prop('selectedIndex',0);
            document.getElementById("kuantita").value = "";
            document.getElementById("kuantita").focus();

            GetTotalMenu();
        }
      }
    function CekNanNParseInt(value){
        var value;
        if(isNaN(parseInt(value))){
            value=0;
        }else{
            value=parseInt(value);
        }
        return value;
      }
    function hartot(id){
        var format = new curFormatter();
        kts=CekNanNParseInt($('#qty_'+id).val());
        tot=CekNanNParseInt(format.unformat($('#harga_'+id).val()));
        total=format.format(kts*(format.unformat(tot)));
        document.getElementById('total_'+id).value = total;
        // $('#total_'+id).val(total);
      }
    function del(ele) {
        var toprow = $(ele).closest("tr");
        toprow.remove();
        GetTotalMenu();
    }

    $("document").ready(function(){
        var rowCount = $('#tblmenu tr').length-2;
        $('#jumrow').val(rowCount);
    });

   <?php if(isset($iids)){ ?>
   $("document").ready(function(){
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });
        jQuery.ajax({
            url:'<?php echo $this->pathFor('kasirku-ajax', ['id' => $iids]); ?>',
            async: false,
            type: 'GET',
            success: function( data ){
                 $('.beer').html(data);
            },
            error: function (xhr, b, c) {
                console.log("xhr=" + xhr + " b=" + b + " c=" + c);
            }
        });
    });
   <?php } ?>
   function tambahanmenu(){
        var i=$('#tblmenu tr').length-2;
        $('#tblmenu').find('tbody').append(
            "<tr>"+
                "<td>"+
                    "<a href='javascript:void(0)'  data-toggle='tooltip' onclick='del(this)'' data-original-title='Hapus'> <i class='fa fa-close text-danger'></i></a>"+
                "</td>"+
                "<td>"+
                    "<input id='kuantitastmbh_"+i+"' onkeyup='hrgtambahan("+i+");GetTotalMenu();' onclick='hrgtambahan("+i+");GetTotalMenu();' class='form-control' type='number' name='qty[]' style='width:60px;'/>"+
                "</td>"+
                "<td colspan='2'>"+
                    "<input class='form-control' type='text' name='ids[]'/>"+
                "</td>"+
                "<td>"+
                    "<input id='tmbharga_"+i+"' onkeyup='hrgtambahan("+i+");GetTotalMenu();' onclick='hrgtambahan("+i+");GetTotalMenu();' class='form-control' type='text' style='width:100%;'/>"+
                "</td>"+
                "<td>"+
                    "<input id='total_"+i+"' class='form-control' name='hargatot[]' readonly=''>"+
                "</td>"+
            "</tr>");
   }
   function hrgtambahan(id){
        var format = new curFormatter();
        kts=CekNanNParseInt($('#kuantitastmbh_'+id).val());
        tot=CekNanNParseInt(format.unformat($('#tmbharga_'+id).val()));
        total=format.format(kts*(format.unformat(tot)));
        document.getElementById('total_'+id).value = total;
        $('#tmbharga_'+id).val(format.format(tot));
   }
</script>
