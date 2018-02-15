<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Kasir',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Spa',
    'submain_location' => 'Form Kasir'
  ]);
?>
<div class="row">
    <?php if ($this->getSessionFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $this->getSessionFlash('success'); ?>
    </div>
    <?php endif; ?>

     <?php if ($this->getSessionFlash('error_messages')): ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
         <ul>
          <?php
            foreach($this->getSessionFlash('error_messages') as $key => $error) {
            ?>
            <li><?php echo $error; ?></li>
            <?php
            }
          ?>
          </ul>
    </div>
    <?php endif;
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
</div>
<div class="row">
    <div class="col-sm-8">
        <div class="white-box">
            <h3 class="box-title m-b-0">Form Kasir </h3>
            <p class="text-muted m-b-30"></p>
            <form class="form-horizontal" method="POST" action="<?php echo $this->pathFor('kasirspa-save'); ?>">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Pelanggan</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?= @$spakasir->namapelanggan ?>" name="pelanggan">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Pax</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?= @$spakasir->pax ?>" name="kapasitas">
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Keterangan</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?= @$spakasir->keterangan ?>" name="keterangan">
                        </div>
                    </div>
                </div>
                </div>

                <h4 class="box-title m-b-0">Layanan</h4>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div>
                                <input type="text" id="kuantita" class="form-control hidden" value="1" name="qty" placeholder="kuantitas">
                            </div>
                            <div class="col-md-8">
                               <select  class="form-control select2" name="layanan" id='layananid'>
                                <option>Pilih Layanan</option>
                                <?php foreach($Kasir as $kasir) { ?>
                                    <option value="<?=$kasir->id?>'<?=$kasir->kode;?>'<?=$kasir->nama_layanan;?>'<?=$kasir->hargajual;?>'<?=$kasir->diskon;?>"><?=$kasir->kode?> - <?=$kasir->nama_layanan?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                               <select class="form-control select2" name="terapis" id='terapisid' onchange="TambahrRow()">
                                <option>Pilih Terapis</option>
                                <?php foreach($terapis as $terapi) { ?>
                                    <option value="<?=$terapi->id;?>'<?=$terapi->nama?>"><?=$terapi->nama?></option>
                                <?php } ?>
                            </select>
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-12">
                                 <table id="tbllayanan" class="table table-striped table-bordered">
                                 <thead>
                                    <tr>
                                        <th style="width: 78px;">Hapus</th>
                                        <th colspan="3" style="width: 250px;">Layanan</th>
                                        <th colspan="2" style="width: 200px;">Terapis</th>
                                        <th>@Harga</th>
                                        <th>@Diskon</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody class="beer">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="8" style="text-align: right;">Total Harga</td>
                                        <td id="totalharga" name="totalnya">Rp.</td>
                                    </tr>
                                </tfoot>
                                </table>
                                </br>

                                <div class="col-md-9" style="float: right; margin-right: -5px;">
                                    <div class="form-group">
                                        <label class="col-md-6 control-label"><span class="help">Diskon Layanan:</span></label>
                                        <div class="col-md-2">
                                            <input type="number" id="diskon" class="form-control" value="<?= @$spakasir->diskon ?>" name="diskon" onkeyup="diskonspa()">
                                        </div>
                                        
                                        <label class="control-label" style="text-align: center;"><span class="help">&nbsp%</span> &nbsp  Rp.</label>
                                        
                                        <div class="col-md-3" style="float: right;">
                                            <input type="text" id="totaldiskon" name="totaldiskon" placeholder="Total Bayar" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                                <input type="number" id="totalharganya" name="totalnya" class="hidden"/>
                                <input type="number" id="bayar" name="bayar" class="hidden" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <button style="float: right;" class="btn btn-default btn-rounded waves-effect waves-light"><span class="btn-label"><i class="fa fa-print"></i></span>Print</button>
                            <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('kasirspa')?>">Batal</a>
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
                     <input readonly type="text" class="form-control" value="<?php if(@$Respesanan->nobukti){echo @$Respesanan->nobukti;}else{ echo @$NoBukti;}  ?><?= @$spakasir->nobukti?>" name="nobukti" id="nobukti">
                </div>
            </div> 
            <div class="form-group">
                <label class="col-sm-3 control-label" style="text-align: left;">Tanggal</label>
                <div class="col-md-9" id="date-range" data-date-format="dd-mm-yyyy">
                        <input  type="text" class="form-control" name="date" value="<?php echo convert_date(@$date) ?><?= convert_date (@$spakasir->tanggal)?>" >
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
                        <option value="<?php echo $card->id ?>" <?php if(@$spakasir->jenis_kartukredit == $card->id){ echo 'selected'; }?>><?= $card->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-5 control-label" style="text-align: right;"><b>Nominal</b></span></label>
                <div class="col-md-7">
                    <input id="totalcreditcard" type="text" class="form-control" value="<?=  @$spakasir->kartubayar?>" v-model="checkout.creditcardAmount" name="totalcreditcard" onkeyup="kalkulasi()">
                </div>
            </div>
            <hr>
            <div class="form-group">
                    <label class="col-md-3 control-label" style="text-align: left;"><b>Bill ke Kamar</b></label>
                    <div class="col-md-9">
                    <select  class="form-control select2" name="nokamarid" id='nokamarid'  <?=@$nokamarDis?> >
                    <option value='0'>- Pilih No. Kamar -</option>
                     <?php foreach($Rooms as $Room) { 
                        if(@$spakasir->checkinid==$Room->id){
                            $selected = "selected";
                        } else {
                            $selected = "";
                        }?>
                      <option value="<?=$Room->id?>" <?= $selected; ?>><?=$Room->room->number?> || <?=$Room->reservation->guest->name;?></option>
                    <?php } ?>
                    </select> 
                </div>
            </div>
            <div class="form-group">
                    <label class="col-md-5 control-label" style="text-align: right;"><b>Nominal</b></label>
                    <div class="col-md-7">
                        <input id="totalkamar" type="text" class="form-control" value="<?php echo @$spakasir->totalkamar; ?>" v-model="checkout.creditcardAmount" name="totalkamar" onkeyup="kalkulasi()"> 
                    </div>
            </div>
            <hr>
            <div class="form-group">
                <label class="col-sm-3 control-label" style="text-align: left;"><b>Cash</b></label>
                <div class="col-md-9">
                     <input id="cash" type="text" class="form-control" value="<?php echo @$spakasir->tunai; ?>" v-model="checkout.cash" name="cash" onkeyup="kalkulasi()">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <input id="pembayaran" type="text" class="form-control" placeholder="Total Pembayaran" value="<?php echo @$spakasir->bayar; ?>" v-model="checkout.cash" name="pembayaran" readonly>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <input id="kembalian" readonly type="text" class="form-control" placeholder="kembali" value="<?php echo @$spakasir->kembalian; ?>" v-model="checkout.cash" name="kembalian">
                    </div>
                </div>
            </div>
            <input  type="text" class="hidden" id='jumrow' name='jumrow'> 
            <input type="text" class="hidden" name="checks" value="<?= @$check;?>">
            <input type="text" class="hidden" name="zid" value="<?= @$spakasir->id;?>">
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
        format.input("[name='pembayaran']");
        format.input("[name='kembalian']");
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

    function diskonspa(){
        var format = new curFormatter();

        diskon=CekNanNParseInt($('#diskon').val());
        totalharga=CekNanNParseInt(format.unformat($('#totalharganya').val()));
        diskon = format.unformat(totalharga) * diskon / 100;
        total = format.unformat(totalharga) - diskon;
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
        // document.getElementById("totalharga").innerHTML='Rp. '+rupiah;
    }

    function GetTotalLayanan(){
        var format = new curFormatter();
        var rowCount;
        rowCount = $('#tbllayanan tr').length;
        rowCount=rowCount-2;
        
        var finaltotal=0;
        var tot;
        for (x = 0; x < rowCount; x++) { 
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
        var z = document.getElementById("terapisid");
        var e = document.getElementById("layananid");
        if(x==""){
            document.getElementById("kuantita").focus();
        } else {
            //tampil row layanan
            var strUser = e.options[e.selectedIndex].value;
            var parts = strUser.split("'")

            //tampil row Terapis
            var strUser1 = z.options[z.selectedIndex].value;
            var parts1 = strUser1.split("'")
            var diskon = parseInt(format.unformat(parts[4]))/100*parseInt(format.unformat(parts[3]));
            var total = parseInt(format.unformat(parts[3])) - format.unformat(diskon)*parseInt(x);
            var i=$('#tbllayanan tr').length-2;

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
               total($('#qty'+idupdate).val('1'),'id_'+idupdate);
                
              // hitungJumlah(idupdate);

            }else{

            $('#tbllayanan').find('tbody').append(
                "<tr>"+
                    "<td>"+
                        "<a href='javascript:void(0)'  data-toggle='tooltip' onclick='del(this)'' data-original-title='Hapus'> <i class='fa fa-close text-danger'></i></a>"+
                        "<input onkeyup='totalharg("+i+");GetTotalLayanan();' onclick='totalharg("+i+");GetTotalLayanan();' class='form-control hidden' type='number' name='qty[]' id='qty_"+i+"' value='"+x+"'style='width:60px;'/>"+
                    "</td>"+
                    "<td colspan='3'>"+parts[2]+"</td>"+
                    "<td colspan='2'>"+parts1[1]+"</td>"+
                    "<td>"+format.format(parts[3])+"</td>"+
                    "<td>"+parts[4]+"%</td>"+
                    "<td>"+
                        "<input id='harga_"+i+"' class='hidden' value='"+parts[3]+"' name='harga_"+i+"'/>"+
                        "<input id='diskon_"+i+"' class='hidden' value='"+parts[4]+"' name='diskon_"+i+"'/>"+
                        "<input class='hidden' id='terapis_"+i+"' value='"+parts1[0]+"' name='terapis[]'/>"+
                        "<input class='hidden' id='ids_"+i+"' value='"+parts[0]+"' name='ids[]'/>"+
                        "<input class='form-control' id='total_"+i+"' value='"+format.format(total)+"' name='hargatot[]' readonly/>"+
                        "<input type='hidden' class='form-control' value='0' name='id[]' id='id_"+i+"'>"+
                    "</td>"+
                "</tr>");             
             
            $('#kuantitas_'+i).focus();
            var rowCount = $('#tbllayanan tr').length-2;
            $('#jumrow').val(rowCount);
            i=i+1;
            }
            $('.select2').prop('selectedIndex',0);
            document.getElementById("kuantita").value = "1";
            document.getElementById("kuantita").focus();

            GetTotalLayanan();
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
    function totalharg(id){
        var format = new curFormatter();
        kts=CekNanNParseInt($('#qty_'+id).val('1'));
        tot=CekNanNParseInt(format.unformat($('#harga_'+id).val()));
        disc=CekNanNParseInt($('#diskon_'+id).val());

        total=format.format(kts*format.unformat(tot));
        document.getElementById('total_'+id).value = total;
      }
    function del(ele) {
        var toprow = $(ele).closest("tr");
        toprow.remove(); 
        GetTotalLayanan();
    }
    
    $("document").ready(function(){
        var rowCount = $('#tbllayanan tr').length-2;
        $('#jumrow').val(rowCount);
    });

   <?php if(isset($iids)){ ?>
   $("document").ready(function(){
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });
        jQuery.ajax({
            url:'<?php echo $this->pathFor('kasirspa-ajax', ['id' => $iids]); ?>',
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
// <select class="form-control" name="terapis" id='terapis'> "<option value='""'>-Pilih Terapis-</option> <?php foreach($terapis as $terapi) { ?> <option value='"<?=$terapi->id;?>"' <?php if($terapi->id==@$spakasir->terapis_id){ echo '"selected"'; } ?>><?=$terapi->nama?></option> <?php } ?> </select>"+

   function hrgtambahan(id){
        kts=CekNanNParseInt($('#kuantitastmbh_'+id).val());
        tot=CekNanNParseInt(format.unformat($('#tmbharga_'+id).val()));
        total=format.format(kts*format.unformat(tot));
        document.getElementById('total_'+id).value = total;
   }
</script>