<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Tambah Pesanan',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Restoran',
    'submain_location' => 'Pesanan'
  ]);

?>



<div class="row" id='Form_Pesanan'>
    <div class="col-sm-12">
        <div class="white-box">
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
        <?php endif; ?>    
        <div id="divDataKosongValid" style="display: none">
             <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" onclick="tutuppesanerror()">&times;</button>
                 <ul  id="divDataKosongValidtagli">
                   
                  </ul>
            
            </div>
        </div>

            <h3 class="box-title m-b-0">Form Pesanan </h3>
            <p class="text-muted m-b-30">Menambah Pesanan</p>
         
            <form class="form-horizontal" id='pesananform' action="<?php echo $this->pathFor('pesanan-save'); ?>" method="post">
            <input type="hidden" class="form-control" value="<?php echo @$Respesanan->id ?>" name="id">
            <div class="row">
                

                    <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Tanggal</span></label>
                        <div class="col-md-12">
                         
                            <input type="text" data-date-format="yyyy-mm-dd" class="form-control mydatepicker" value="<?php echo substr((@$Respesanan->tanggal==''?date('Y-m-d'):@$Respesanan->tanggal),0,10) ?>" name="tanggal" id="tanggal">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">No. Bukti </span></label>
                        <div class="col-md-12">
                            <input readonly type="text" class="form-control" value="<?php if(@$Respesanan->nobukti){echo @$Respesanan->nobukti;}else{ echo @$NoBukti;}  ?>" name="nobukti" id="nobukti">
                        </div>
                    </div>

                        <?php 
if(@$Respesanan->jenispelanggan=='2'){
    $pelangan=@$Respesanan->pelangganid;
    $pelangganDis='';
    $nokamarDis='disabled';
}else{
    $nokamar=@$Respesanan->pelangganid;
    $nokamarDis='';
    $pelangganDis='disabled';

}
                        ?> 
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Pelanggan</span></label>
                        <div class="col-md-10">
                            <select  class="form-control select2" name="pelangganid" id='pelangganid' <?=@$pelangganDis?> >
                            <option value='-'>Silakan Pilih</option>
                            <?php foreach($Respelanggans as $Respelanggan) { ?>
                                <option
                                <?php if(@$pelangan==$Respelanggan->id){echo 'selected="selected"';$checkedP='checked="checked"';}?>
                                 value="<?=$Respelanggan->id?>"><?=$Respelanggan->nama?></option>
                            <?php } ?>
                            </select>

                            
                        </div>
                            <div class="radio radio-danger col-md-2">
                            <input id="jenispelanggan1" type="radio" value="2" <?=@$checkedP?>   name="jenispelanggan" onchange="cekjenipelanggan(this.value);">
                            <label for="is_editable"></label>
                            </div>
                    </div>
                     <div class="form-group">
                        <label class="col-md-12"> <span class="help">No. Kamar</span></label>
                        <div class="col-md-10">
                          

                            <select  class="form-control select2" name="nokamarid" id='nokamarid'  <?=@$nokamarDis?> >
                            <option value='-'>Silakan Pilih</option>
                            <?php foreach($Rooms as $Room) { ?>
                                <option
                                <?php if(@$nokamar==$Room->id){echo 'selected="selected}"';$checkedK='checked="checked"';}?>
                                 value="<?=$Room->reservationdetails_id ?>"><?=$Room->number;?> || <?=$Room->namapengunjung;?></option>
                            <?php } ?>
                            </select>
                           
                        </div>
                       <div class="radio radio-danger col-md-2">
                            <input id="jenispelanggan2" type="radio" value="1" <?=@$checkedK?><?=@$checkedAdd?> name="jenispelanggan" onchange="cekjenipelanggan(this.value);">
                            <label for="is_editable"></label>
                            </div>

                    </div>
                    </div>
                    <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-12"> <span class="help">Meja</span></label>
                       <div class="col-md-12">
                        <select  class="form-control select2" name="mejaid" id='mejaid' > 
                        <option value=''>Silakan Pilih</option>
                        <?php foreach($Resmejas as $Resmeja) { ?>
                            <option
                            <?php if((@$idmeja!='0')and(@$idmeja==$Resmeja->id||@$Respesanan->mejaid==$Resmeja->id)){echo 'selected="selected"';}?>
                             value="<?=$Resmeja->id?>"><?=$Resmeja->kode?> - <?=$Resmeja->keterangan?></option>
                        <?php } ?>
                        </select>
                    </div>
                </div>
                     <div class="form-group">
                        <label class="col-md-12"> <span class="help">Keterangan</span></label>
                        <div class="col-md-12">
                            <textarea class="form-control" name="Keterangan" id="Keterangan" style="margin: 0px; height: 214px; width: 627px;"><?=@$Respesanan->Keterangan?></textarea>
                        </div>
                    </div>
                    
                    </div>
                    <div class="col-md-12">
                        <div class="form-group" >
                            <div>
                            <h1 class="box-title m-b-0">Menu </h1>
                    <table class="table " id='table_barang'>
                        <thead>
                            <tr>
                                <th>Kode Menu</th>
                                <th>Nama Menu</th>
                                <th>Kuantitas</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                            </tr>    
                        </thead>
                        <tbody>
                          <?php
                          $i=0;
                           foreach ($pesanandetails as  $pesanandetail) {?>
                            <tr>
                                <td>
                                <input type='hidden' class='form-control' value='<?=$pesanandetail->id?>' name='id_<?=$i?>' id='id_<?=$i?>'><input type='hidden' class='form-control' value='<?=$pesanandetail->menuid?>' name='idmenu_<?=$i?>' id='idmenu_<?=$i?>'>
                                    <?=$pesanandetail->kodemenu?>
                                </td>
                                <td>
                                    <?=$pesanandetail->namamenu?>
                                </td>
                                <td><input type='text' class='form-control' value='<?=$pesanandetail->kuantitas?>' name='kuantitas_<?=$i?>' id='kuantitas_<?=$i?>' onkeyup='total(this.value,this.id);GetTotalMenu();'>
                                    
                                </td>
                                <td>
                                <input type='text' readonly  class='form-control' name='harga_<?=$i?>'  id='harga_<?=$i?>' value='<?=$pesanandetail->harga;?>'>
                                    
                                </td>
                                <td>
                                  <input type='text' readonly class='form-control' name='total_<?=$i?>'  id='total_<?=$i?>' value='<?=$pesanandetail->kuantitas*$pesanandetail->harga?>'>
                                    
                                </td>
                            </tr>
                          <?php $i++;} ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colSpan="4">
                                    <a href="#" alt="default" data-toggle="modal" data-target="#responsive-modal-Barang" className="model_img img-responsive">Tambah Menu</a>        
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    
                </div>    

                        </div>

                    </div>
                    <div class="col-md-4">
                    <div class="form-group">
                         <label class="col-md-12"> <span class="help">Total</span></label>
                        <input readonly  type="text" class="form-control" id='finaltotal' name='finaltotal'> 
                    </div>
                    <div class="form-group" style="display: none">
                         <label class="col-md-12"> <span class="help">Jumlah Row </span></label>
                        <input  type="text" class="form-control" id='jumrow' name='jumrow'> 
                    </div>
                    <button type="button" class="btn btn-success waves-effect waves-light m-r-10" onclick="Simpan()">Simpan</button>
                    <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('pesanan')?>">Batal</a>
                </div>
            </div>
            
            

            </form>
        </div>
    </div>
</div>
<div id="responsive-modal-Barang" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Daftar Barang</h4>
      </div>
      <div class="modal-body">
        <form>
            
        
            <table class="table myDataTable">
            <thead>
                <tr class="ppp">
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                 <?php foreach ($Resmenus as $Resmenu) {
                   ?>

                    <tr>
                    <td><?=$Resmenu->kode;?></td>
                    <td><?=$Resmenu->nama;?></td>
                    <td><button type="button" class="btn btn-info waves-effect waves-light" data-dismiss="modal" onclick="TambahrRow('<?=$Resmenu->id;?>','<?=$Resmenu->kode;?>','<?=$Resmenu->nama;?>','<?=$Resmenu->hargajual;?>')">Pilih</button></td>
                </tr>
            </tbody>
            <?php
                } ?> 
               

            </table>
         
        </form>
      </div>
     <!--  <div class="modal-footer">
        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger waves-effect waves-light">Save changes</button>
      </div> -->
    </div>
  </div>
</div>

<script type="text/javascript">


$(document).ready(function(){
  
    
   var rowCount = $('#table_barang tr').length-2;
    $('#jumrow').val(rowCount);

    <?php 

        if(@$Respesanan->jenispelanggan=='2'){?>
            $('#jenispelanggan1').prop('checked', true);
         
           
             
             
              
              <?php
        }else if(@$Respesanan->jenispelanggan=='1'){
            ?>
        
            
                $('#jenispelanggan2').prop('checked', true);
                <?php
        }
       ;
    ?>
      
    GetTotalMenu();
 
});
function tutuppesanerror(){
    $('#divDataKosongValid').toggle();
}
function Simpan(){
    var tanggal, meja,nobukti,pelangal,jenis,totrow,kuantitas,total;
    totrow=$('#jumrow').val();
    if($('#jenispelanggan1').is(':checked')){
        jenis='pelangan';
    }else{
        jenis='kamar';
    }
    if(jenis=='pelangan'){
      pelangal=$('#pelangganid').val();  
    }else{
        pelangal=$('#nokamarid').val();
    }  
    kuantitas=true;
    if(totrow==0){
        kuantitas=false;
    }
    for (var i = 0; i < totrow; i++) {
       
        if(isNaN($('#kuantitas_'+i).val())){
            kuantitas=false;
        }
    }
    tanggal=$('#tanggal').val();
    meja=$('#mejaid').val();
    nobukti=$('#nobukti').val();
    total=$('#finaltotal').val();

    if ( jenis && pelangal && kuantitas && tanggal && nobukti && total && meja ){


        // alert('yeahh');
        // alert(jenis);
        // alert(pelangal);
        // alert(kuantitas);
        // alert(tanggal);
        // alert(nobukti);
        // alert(total);
        // alert(meja);
        
        $('#pesananform').submit();
    }else{
       // alert('hooohh');
        // alert(jenis);
        // alert(pelangal);
       
        error_pesan(jenis,pelangal,kuantitas,tanggal,nobukti,total,meja);
    }
}

function error_pesan(jenis,pelangal,kuantitas,tanggal,nobukti,total,meja){
    if($('#divDataKosongValid').css('display')=='block'){
        $('#divDataKosongValid').toggle();
    }
   var data=[];
        if(!pelangal){
            data.push('Pelanggan');
        }
        if(!kuantitas){
            data.push('Menu atau Kuantitas');
        }
         if(!tanggal){
            data.push('Tanggal');
        }
        if(!nobukti){
            data.push('Nomber Bukti');
        }
        if(!meja){   
            data.push('Meja');
        }
        $('#divDataKosongValidtagli').empty();
        $.each(data, function( k, v ) {
         $('#divDataKosongValidtagli').append("<li>"+v+" Kosong Atau Tidak Valid</li>");
        });
        $('#divDataKosongValid').toggle();
        $('#divDataKosongValid').focus();
        $("html, body").animate({ scrollTop: 0 }, "slow");

}
  function cekjenipelanggan(value){
    if (value==2){
        $("#pelangganid").select2("val", "-");
        $("#nokamarid").select2("val", "-");
        $("#nokamarid").prop('disabled', true);
        $("#pelangganid").prop('disabled', false);
    }else{
         
         $("#nokamarid").select2("val", "-");
          $("#pelangganid").select2("val", "-");
         $("#nokamarid").prop('disabled', false);
         $("#pelangganid").prop('disabled', true);
        // $('#pelangganid').enable(false);
        $
    }
  }
 function total(value,id){
    console.log('1');
    id=id.split('_');  
    var total,hargabeli;
    hargabeli=CekNanNParseInt($('#harga_'+id[1]).val());
    total=hargabeli*value;    
    $('#total_'+id[1]).val(total);
  }

  function GetTotalMenu(){
    
    var rowCount;
    rowCount = $('#table_barang tr').length;
    rowCount=rowCount-2;
    
    var finaltotal=0;
    for (x = 0; x < rowCount; x++) { 
        //alert($('#total_'+x).val());
        finaltotal=finaltotal+CekNanNParseInt($('#total_'+x).val());
    }
     
    $('#finaltotal').val(finaltotal);

   
  }
 
  function ValidasiHargaJual(){
    value=CekNanNParseInt($('#hargajual').val());
        if(CekNanNParseInt($('#finaltotal').val())>value){
                $("#HargajualValid").fadeToggle(350);
                setTimeout(function(){ $("#HargajualValid").fadeToggle(350);$("#hargajual").focus(); }, 1000);
                
                
        }
  }
  function isNumberRestoran(value,id){
    if(isNaN(value)){
      $("#"+id).focus();
      $("#NotANumber").fadeToggle(350);
      setTimeout(function(){ $("#NotANumber").fadeToggle(350); }, 1000);
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



function TambahrRow(id,kode,nama,harga){
    var i=$('#table_barang tr').length-2;


    var update=false;
    var idupdate=0;
    for (var j = 0 ; j < i; j++) {
       
        
        if($('#idmenu_'+j).val()==id){
            update=true;
            idupdate=j;
           
           
        }
    }
    console.log(update);
     if(update){

       var jumlah= CekNanNParseInt($('#kuantitas_'+idupdate).val())+1;

       $('#kuantitas_'+idupdate).val(jumlah);
       total($('#kuantitas_'+idupdate).val(),'id_'+idupdate);
        
      // hitungJumlah(idupdate);

    }else{

    $('#table_barang').find('tbody').append("<tr><td><input type='hidden' class='form-control' value='0' name='id_"+i+"' id='id_"+i+"'><input type='hidden' class='form-control' value='"+id+"' name='idmenu_"+i+"' id='idmenu_"+i+"'>"+kode+"</td><td>"+nama+"</td><td><input type='text' class='form-control' value='1' name='kuantitas_"+i+"' id='kuantitas_"+i+"' onkeyup='total(this.value,this.id);GetTotalMenu();'></td><td><input type='text' readonly  class='form-control' name='harga_"+i+"'  id='harga_"+i+"' value='"+harga+"'></td><td><input type='text' readonly class='form-control' value='"+harga+"'  name='total_"+i+"' id='total_"+i+"'></td></tr>");
     
         
     
     $('#kuantitas_'+i).focus();
    var rowCount = $('#table_barang tr').length-2;
    $('#jumrow').val(rowCount);
    i=i+1;
    }
    GetTotalMenu();
  }
</script>