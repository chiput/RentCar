<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Kasir',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Restoran',
    'submain_location' => 'Kasir'
  ]);

?>
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
  <div id="divDataKosongValid" style="display: none;">
             <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" onclick="tutuppesanerror()">&times;</button>
                 <ul  id="divDataKosongValidtagli">
                   
                  </ul>
            
            </div>
  </div>
  <div id="DataKosongValid" class="myadmin-alert myadmin-alert-icon myadmin-alert-click alert-danger myadmin-alert-top alerttop"> <i class="fa fa-ban"></i> Ada Data Kosong !  <a href="#" class="closed">&times;</a> </div>

<div class="row">
    <div class="col-sm-9">
           <div class="white-box">
            <h3 class="box-title m-b-0">Form Data Kasir </h3>
            <p class="text-muted m-b-30">Menambah Data Kasir</p>
           
            <form class="form-horizontal" id="kasirform" action="<?php echo $this->pathFor('kasir-save'); ?>" method="post">
            <input type="hidden" class="form-control" value="<?php echo @$meja->id ?>" name="id">
            <input type="hidden" class="form-control" value="<?=$idpesanan;?>" name="pesanaidURL">
            <input type="hidden" class="form-control" value="<?=$idmeja;?>" name="mejaidURL">
            <div class="row">

            
                <div class="col-md-12">
                <div class="col-md-6">


                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Tanggal</span></label>
                       <div class="col-md-12">
                            <input type="text" data-date-format="dd-mm-yyyy" class="form-control mydatepicker" value="<?php echo substr((@$Respesanan->tanggal==''?date('Y-m-d'):@$Respesanan->tanggal),0,10) ?>" name="tanggal"  id="tanggal">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">No Bukti</span></label>
                        <div class="col-md-12">
                          <input type="text" class="form-control" value="<?php echo @$NoBukti ?>" name="nobukti" id="nobukti" readonly>
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-md-12"> <span class="help">Pelangan<?=$jenispelanggan?></span></label>
                        <div class="col-md-12">
                         <select  class="form-control select2" name="pelangganid" id='pelangganid' onchange="PembayaranRadio()" <?=@$pelangganDis?> >
                            <option value='-'>Silakan Pilih</option>
                            <?php foreach($Respelanggans as $Respelanggan) { ?>
                                <option
                                <?php if(@$pelangganid==$Respelanggan->id and @$jenispelanggan=='2'){echo 'selected="selected"';}?>
                                 value="<?=$Respelanggan->id?>"><?=$Respelanggan->nama?></option>
                            <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Pesanan</span></label>
                        <div class="col-md-10">
                         <table class="table" id="table_pesanan">
                             <tr>
                                <th>Meja</th>
                                <th>No Pesanan</th>
                                <th></th>
                             </tr>
                             
                         </table>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                          <button class="btn btn-default" type="button" data-toggle="modal" data-target="#responsive-modal-Pesanan" >+</button>
                          </div>
                          <div class="form-group" style="display: none">
                          <button class="btn btn-danger" type="button">-</button>
                          </div>
                          
                        </div>
                    </div>
                     <div class="form-group" style="display: none">
                        <label class="col-md-12"> <span class="help">Jumlah Row Pesanan</span></label>
                        <div class="col-md-12">
                          <input type="text" class="form-control"  name="jumlahrowpesanan" id="jumlahrowpesanan">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                 <div class="form-group"  style="margin-bottom: 1px;">
                        <label class="col-md-12"> <span class="help">Pembayaran</span></label>

                        <?php 
                          if (@$jenispelanggan=='2'){
                            $tuniachecked='checked="checked"';
                          }elseif(@$jenispelanggan=='1'){
                            $kamarchecked='checked="checked"';
                          }else{
                            $tuniachecked='checked="checked"';
                          }


                        ?>
                        <div class="col-md-12">
                                <div class="radio radio-danger col-md-4">
                                <br></br>
                                <input id="jenispembayaran1" type="radio" <?php // echo @$tuniachecked;?> onclick="PembayaranRadio('tunai');" value="1" name="jenispembayaran" >

                                &nbsp&nbsp<label for="is_editable">Tunai</label>
                                </div>
                                <div class="radio radio-danger col-md-4" style="display: none">
                                <input id="jenispembayaran2" type="radio" onclick="PembayaranRadio('tempo');" value="2" name="jenispembayaran" >
                                 <label for="is_editable">Tempo</label> --> 
                                </div>
                                <div class="form-group col-md-4" style="display: none">
                                <label class="col-md-4"> <span class="help">Hari</span></label> 
                                <div class="col-md-8">
                                 <input type="text" class="form-control" value="0" name="tempohari" id="tempohari"> 
                                </div>
                                </div>
                        </div>
                    </div>
                     <div class="col-md-12">
                        <div class="radio radio-danger col-md-4">
                                <br></br>
                                <input id="jenispembayaran3" type="radio"  <?=@$kamarchecked?> onclick="PembayaranRadio('kamar');" value="3" name="jenispembayaran" >
                                <label for="is_editable">Kamar</label>
                        </div>
                        <div class="col-md-8">
                        <br></br>
                          <select  class="form-control select2"  name="nokamarid" id='nokamarid' >
                            <option value='-'>Silakan Pilih</option>
                            <?php foreach($Rooms as $Room) { ?>
                                <option
                                <?php if(@$pelangganid==$Room->id and @$kamarchecked){echo 'selected="selected}"';}?>
                                 value="<?=$Room->reservationdetails_id ?>"><?=$Room->number;?> || <?=$Room->namapengunjung;?></option>
                            <?php } ?>
                            </select>
                        </div>
                        
                    </div>
                    <div class="form-group">
                         <div class="radio radio-danger col-md-12">
                                <!-- <input id="jenispembayaran4" type="radio" onclick="PembayaranRadio('voucer');" value="4" name="jenispembayaran" >
                                <label for="is_editable">Voucer</label> -->
                          </div>
                    </div>
                     <div class="form-group">
                         <div class="checkbox checkbox-danger col-md-12">
                                <!-- <input id="faktur" type="checkbox" value="2" name="faktur" >
                                <label for="is_editable">Faktur Pisah</label> -->
                          </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Keterangan</span></label>
                        <div class="col-md-12">
                            <textarea class="form-control" value="<?php echo @$meja->orang ?>" name="keterangan" style="margin: 0px; width: 586px; height: 119px;"> </textarea>
                        </div>
                    </div>
                     <div class="form-group" style="display: none">
                        <label class="col-md-12"> <span class="help">Jumlah Row</span></label>
                        <div class="col-md-12">
                            <input type="text" name="jumrowmenu" id="jumrowmenu" value="0">
                        </div>
                    </div>
                    <div class="form-group" style="display: none">
                        <label class="col-md-12"> <span class="help">Jumlah Row untuk pesan error</span></label>
                        <div class="col-md-12">
                            <input type="text" name="jumrowmenupesanerror" id="jumrowmenupesanerror" value="0">
                        </div>
                    </div>
                </div>
                                   
                </div>

                <div class="col-md-12">

                   <table class="table" id='table_menu'>
                        <thead>
                            <tr>
                                <th>Kode Menu</th>
                                <th>Nama Menu</th>
                                <th>Kuantitas</th>
                                <th>Harga</th>
                                <th>Diskon</th>
                                <th>Jumlah</th>
                            </tr>    
                        </thead>
                        <tbody>
                     
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colSpan="4">
                                    <a href="#" alt="default" data-toggle="modal" data-target="#responsive-modal-Menu" className="model_img img-responsive">Tambah Menu</a>        
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12"> <span class="help">SubTotal</span></label>
                            <div class="col-md-12">
                              <input type="text" class="form-control" value="<?php echo 0 ?>" id="subtotal" name="subtotal" readonly="true">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-md-12"> <span class="help">Service</span></label>
                            <div class="col-md-3">
                              <input type="text" class="form-control" value="<?php echo 0 ?>" name="persenservice" id="persenservice"  onkeyup="GetService()">
                            </div>
                             <div class="col-md-1">
                              <button type="button" class="btn btn-default" readonly>%</button>
                            </div>
                            <div class="col-md-8">
                              <input type="text" class="form-control" value="<?php echo @$meja->orang ?>" name="service" id="service"  onkeyup="GetService('persen')">
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12"> <span class="help">Diskon</span></label>
                            <div class="col-md-3">
                              <input type="text" class="form-control" value="<?php echo 0 ?>" onkeyup='GetDiskon();' name="persendiskon" id="persendiskon">
                            </div>
                             <div class="col-md-1">
                              <button type="button" class="btn btn-default" readonly>%</button>
                            </div>
                            <div class="col-md-8">
                              <input type="text" class="form-control"  value="<?php echo 0 ?>" onkeyup="GetDiskon('persen');" name="diskon" id="diskon">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-md-12"> <span class="help">PPN</span></label>
                            <div class="col-md-3">
                              <input type="text" class="form-control" value="<?php echo 0 ?>" name="persenppn" id="persenppn"  onkeyup="GetPPN()">
                            </div>
                             <div class="col-md-1">
                              <button type="button" class="btn btn-default" readonly>%</button>
                            </div>
                            <div class="col-md-8">
                              <input type="text" class="form-control" value="<?php echo 0 ?>" name="ppn" id="ppn" onkeyup="GetPPN('persen')">
                            </div>
                        </div> 
                    </div>
                  <div class="col-md-6"> 
                     <div class="form-group">
                        <label class="col-md-12"> <span class="help">Total</span></label>
                        <div class="col-md-12">
                          <input type="text" class="form-control" value="<?php echo 0 ?>" name="total" id="total" readonly="true">
                        </div>
                    </div>
                    <div id='bayarkamar'>
                      <div class="form-group">
                          <label class="col-md-12"> <span class="help">Tunai</span></label>
                          <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo 0 ?>" name="tunai" id="tunai" onchange="GetKembali();">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-12"> <span class="help">Kartu</span></label>
                          <div class="col-md-10">
                            <input type="text" class="form-control" value="0" name="kartu" id="kartu" readonly="true">
                          </div>
                          <div class="col-md-1">
                            <button type="button" class="btn btn-default" onclick="$('#tabel_kartu').fadeIn('slow','swing');" >Cari</button>
                          </div>
                      </div> 
                      <div class="form-group">
                          <label class="col-md-12"> <span class="help">Bayar</span></label>
                          <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo 0 ?>" name="bayar" id="bayar" readonly="true">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-12"> <span class="help">Kembali</span></label>
                          <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo 0 ?>" id="kembali" name="kembali" readonly="true">
                          </div>
                      </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <table class="table" id='tabel_kartu'>
                        <thead>
                            <tr>
                                <th>Kartu</th>
                                <th>No. Kartu</th>
                                <th>Bayar</th>
                                <th>Biaya</th>
                                <th>Total</th>
                            </tr>    
                        </thead>
                        <tbody>
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colSpan="3">
                                    <a href="#" alt="default" data-toggle="modal" data-target="#responsive-modal-kartu" className="model_img img-responsive" onclick="$('#totalk_modal').val(parseInt($('#total').val())-(parseInt($('#grandtotalK').text())+parseInt($('#tunai').val())))">Tambah Kartu</a>        
                                </td>
                                <td>
                                  Total
                                </td>
                                <td id='grandtotalK'>
                                0
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

              <div class="col-md-12">
            <button type="button" class="btn btn-success waves-effect waves-light m-r-10" onclick="Bayar()" id='isBAyarButton'>Bayar</button>
                    <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('statusmeja')?>">Batal</a> 
                    </div> 
          
          </div>
            
            

            </form>
        </div>
    </div></div>
     <div class="col-sm-3">
         <div class="white-box" style="position: fixed;">

            <input type="text" class="form-control" onkeyup="Pencarian_Menu();" id="myInput2">
            <table class="table" id='myTable2'>
                <tr class="ppp">
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
                 <?php foreach ($Resmenus as $Resmenu) {
                   ?>

                    <tr>
                    <td><?=$Resmenu->kode;?></td>
                    <td><?=$Resmenu->nama;?></td>
                    <td><button type="button" class="btn btn-danger waves-effect waves-light" onclick="TambahrRow('<?=$Resmenu->id;?>','<?=$Resmenu->kode;?>','<?=$Resmenu->nama;?>','<?=$Resmenu->hargajual;?>')" >Pilih</button></td>
                </tr>

            <?php
                } ?> 
               

            </table>
         </div>
     </div>



<div id="responsive-modal-Menu" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Daftar Menu</h4>
      </div>
      <div class="modal-body">
        <form>
            
         
            <input type="text" class="form-control" onkeyup="Pencarian_Menu2();" id="myInput_FormMenu">
            <table class="table" id='myTable2_FormMenu'>
                <tr class="ppp">
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
                 <?php foreach ($Resmenus as $Resmenu) {
                   ?>

                    <tr>
                    <td><?=$Resmenu->kode;?></td>
                    <td><?=$Resmenu->nama;?></td>
                    <td><button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal" onclick="TambahrRow('<?=$Resmenu->id;?>','<?=$Resmenu->kode;?>','<?=$Resmenu->nama;?>','<?=$Resmenu->hargajual;?>')">Pilih</button></td>
                </tr>

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
<div id="responsive-modal-Pesanan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Daftar Pesanan</h4>
      </div>
      <div class="modal-body">
        <form>
            
         
            <input type="text" class="form-control" onkeyup="Pencarian_Pemesan();" id="myInput_FormPemesan">
            <table class="table" id='myTable2_FormPemesan'>
                <tr class="ppp">
                    <th>Tanggal</th>
                    <th>No. Pesanan</th>
                    <th>Pelanggan/No. Kamar</th>
                    <th>Meja</th>
                    <th></th>
                </tr>
                 <?php foreach ($Respesanans as $Respesanan) {
                   ?>

                    <tr>
                    <td><?=$Respesanan->tanggal;?></td>
                    <td><?=$Respesanan->nobukti;?></td>
                    <td><?php if($Respesanan->jenis='1'){echo $Respesanan->nokamar;}else{echo $Respesanan->pelanggannama;}?></td>
                    <td><?=$Respesanan->kodemeja;?></td>
                    <td><button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal" onclick="TambahrRowPesanan('<?=$Respesanan->id;?>','<?=$Respesanan->kodemeja;?>','<?=$Respesanan->mejaid;?>','<?php if($Respesanan->jenis='1'){echo $Respesanan->nokamar;}else{echo $Respesanan->pelanggannama;}?>','<?=$Respesanan->nobukti;?>')" >Pilih</button></td>
                </tr>

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
<div id="responsive-modal-kartu" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Daftar Kartu</h4>
      </div>
      <div class="modal-body" style=" min-height: 415px;">
        <form class="col-sm-12">
          
          <div class="form-group">
              <label class="col-md-12"> <span class="help">Total</span></label>
              <div class="col-md-12">
                <input type="text" class="form-control" value="<?php echo 0 ?>" id="totalk_modal" name="totalk_modal" readonly="true">
              </div>
          </div>
          <div class="form-group">
              <label class="col-md-12"> <span class="help">Kartu</span></label>
              <div class="col-md-12">
               <select  class="form-control select2" name="kartu_modal" id='kartu_modal' >
                                <option value=''>Silakan Pilih</option>
                                <option value="Master Card">Master Card</option>
                                <option value="Visa">Visa</option>
                </select>
              </div>
          </div>
          <div class="form-group">
              <label class="col-md-12"> <span class="help">Nomor</span></label>
              <div class="col-md-12">
                <input type="text" class="form-control"  id="nomorK_modal" name="nomorK_modal" >
              </div>
          </div>
          <div class="form-group">
              <label class="col-md-12"> <span class="help">Bayar</span></label>
              <div class="col-md-12">
                <input type="text" class="form-control"  id="bayarK_modal" name="bayarK_modal" onkeyup="$('#sisaK_modal').val(CekNanNParseInt($('#totalk_modal').val()-CekNanNParseInt(this.value)))">
              </div>
          </div>
          <div class="form-group">
              <label class="col-md-12"> <span class="help">Sisa</span></label>
              <div class="col-md-12">
                <input type="text" class="form-control"  id="sisaK_modal" name="sisaK_modal" readonly="true" >
              </div>
          </div>
          <div class="form-group">
              <label class="col-md-12"> <span class="help">Biaya</span></label>
              <div class="col-md-12">
                <input type="text" class="form-control"  id="biayaK_modal" value="0" name="biayaK_modal" readonly="true" >
              </div>
          </div>
       
       
         
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger waves-effect waves-light" onclick="kartu_save()" data-dismiss="modal">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
var lastrowpesanan=0;
$(document).ready(function(){
$('#tabel_kartu').toggle('false');
   var  isPembayaranForKAmar=false;
//ajax('<?=$idpesanan;?>');
 <?php 

    if (@$jenispelanggan=='1'){?>
      $('#bayarkamar').toggle();
      $('#isBAyarButton').text('Simpan');
      isPembayaranForKAmar=true;
    <?php }
?>
PembayaranRadio('<?=@$jenispelanggan?>');
TambahrRowPesanan('<?=@$LoadPesananRow->id?>','<?=@$LoadPesananRow->kodemeja?>','<?=@$LoadPesananRow->mejaid?>','<?php if(@$LoadPesananRow->jenis='1'){echo @$LoadPesananRow->nokamar;}else{echo @$LoadPesananRow->pelanggannama;}?>','<?=@$LoadPesananRow->nobukti?>');



});


function tutuppesanerror(){
    $('#divDataKosongValid').toggle();
}
function error_pesan(jenis,pelangal,kuantitas,tanggal,nobukti,total){
    if($('#divDataKosongValid').css('display')=='block'){
        $('#divDataKosongValid').toggle();
    }
   var data=[];
        if(!pelangal){
            data.push('Pelanggan,No Kamar, Atau Hari');
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
        if(!total){
            data.push('Bayar');
        }

        
        $('#divDataKosongValidtagli').empty();
        $.each(data, function( k, v ) {
         $('#divDataKosongValidtagli').append("<li>"+v+" Kosong Atau Tidak Valid</li>");
        });
        $('#divDataKosongValid').toggle();
        $('#divDataKosongValid').focus();
        $("html, body").animate({ scrollTop: 0 }, "slow");

}
function Bayar(){

     var  isPembayaranForKAmar=false;
//ajax('<?=$idpesanan;?>');
 <?php 

    if (@$jenispelanggan=='1'){?>
     
      isPembayaranForKAmar=true;
    <?php }
?>
    var tanggal,nobukti,pelangal,jenis,totrow,kuantitas,total;
    totrow=$('#jumrowmenupesanerror').val();
    kuantitas=true;
    total=false;
    pelangal=false;
    if($('#jenispembayaran1').is(':checked')){
        jenis='pelangan';
    }else if($('#jenispembayaran2').is(':checked')){
        jenis='tempo';
    }else if($('#jenispembayaran3').is(':checked')){
        jenis='kamar';
    }else if($('#jenispembayaran4').is(':checked')){
        jenis='voucer';
    }
    if(jenis=='pelangan'){
      if($('#pelangganid').val()!='-'){
        pelangal=true;
      } 
    }else if(jenis=='tempo'){
        if($('#tempohari').val()){
          pelangal=true;
        } 
    }else if(jenis=='kamar'){
        if($('#nokamarid').val()!='-'){
          pelangal=true;
        } 
    }else if(jenis=='voucer'){
      pelangal=true;
    }  
    
    if(totrow==0){
        kuantitas=false;
    }
    for (var i = 0; i < totrow; i++) {
       
        if(isNaN($('#kuantitas_'+i).val())){
            kuantitas=false;
        }
    }
    tanggal=$('#tanggal').val();
    
    nobukti=$('#nobukti').val();

    if(parseInt($('#tunai').val())>0 && !isNaN($('#tunai').val())){
      total=true
    }
   

    if ( (jenis && pelangal && kuantitas && tanggal && nobukti && total && !isPembayaranForKAmar) ||  (jenis && pelangal && kuantitas && tanggal && nobukti && !total && isPembayaranForKAmar )){


         //alert('yeahh');
        // alert(jenis);
        // alert(pelangal);
        // alert(kuantitas);
        // alert(tanggal);
        // alert(nobukti);
        // alert(total);
        // alert(meja);
        
        $('#kasirform').submit();
    }else{
        // alert('hooohh');
        //  alert(jenis);
        //  alert(pelangal);
        //  alert(kuantitas);
        //  alert(tanggal);
        //  alert(nobukti);
         //  alert(total);
         // alert(parseInt($('#tunai').val()));
         // alert(isNaN($('#tunai').val()));
        
        error_pesan(jenis,pelangal,kuantitas,tanggal,nobukti,total);

    }
    
}
function kartu_save(){
var total,kartu,nommor,bayar,biaya,sisa,total,totalgrand;

total=CekNanNParseInt($('#totalk_modal').val());
kartu=$('#kartu_modal').val();
nommor=$('#nomorK_modal').val();
bayar=CekNanNParseInt($('#bayarK_modal').val());
biaya=CekNanNParseInt($('#biayaK_modal').val());
sisa=CekNanNParseInt($('#sisaK_modal').val());
total=bayar+biaya;

if(!kartu || !bayar || !nommor ){
   $("#DataKosongValid").fadeToggle(350);
}else{
    totalgrand=0;
    var i=$('#tabel_kartu tr').length-2;
    $('#tabel_kartu').find('tbody').append("<tr><td>"+kartu+"</td><td>"+nommor+"</td><td>"+bayar+"</td><td>"+biaya+"</td><td id='total"+i+"'>"+total+"</td></tr>");
     }01

     for (var j = 0; j <= i; j++) {

         totalgrand=totalgrand+CekNanNParseInt($('#total'+j).text());
     }
      $('#grandtotalK').text(totalgrand);
      $('#kartu').val(totalgrand);
      GetKembali();
}
  





function Pencarian_Menu2() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput_FormMenu");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable2_FormMenu");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    td2 = tr[i].getElementsByTagName("td")[1];
    if (td||td2) {
      if ((td.innerHTML.toUpperCase().indexOf(filter) > -1)||(td2.innerHTML.toUpperCase().indexOf(filter) > -1)) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}


function Pencarian_Menu() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput2");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable2");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    td2 = tr[i].getElementsByTagName("td")[1];
    if (td||td2) {
      if ((td.innerHTML.toUpperCase().indexOf(filter) > -1)||(td2.innerHTML.toUpperCase().indexOf(filter) > -1)) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

function Pencarian_Pemesan() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput_FormPemesan");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable2_FormPemesan");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    td2 = tr[i].getElementsByTagName("td")[1];
    if (td||td2) {
      if ((td.innerHTML.toUpperCase().indexOf(filter) > -1)||(td2.innerHTML.toUpperCase().indexOf(filter) > -1)) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

function hitungJumlah(id){

    var harga = CekNanNParseInt($('#harga_'+id).val());
    var diskon = CekNanNParseInt($('#diskon_'+id).val());
    var kuantitas = CekNanNParseInt($('#kuantitas_'+id).val());

    var total =(kuantitas*harga)-diskon;

     $('#jumlah_'+id).val(total);
     GetTotalSubMenu();
   

}
  function GetTotalSubMenu(){
    
    var rowCount;
    rowCount = $('#table_menu tr').length;
    rowCount=rowCount-2;
    
    var finaltotal=0;
    for (x = 0; x < rowCount; x++) { 
        //alert($('#total_'+x).val());
        finaltotal=finaltotal+CekNanNParseInt($('#jumlah_'+x).val());
    }
   
    $('#subtotal').val(finaltotal);

    GetTotalMenu();
   
  }

  function GetTotalMenu(){
    GetDiskon('perdiskon',false);
    GetPPN('persenppn',false);
    GetService('persenservice',false);
    var Dis,Sev,PPN,sub,total;
     sub=CekNanNParseInt($('#subtotal').val());
     Dis=CekNanNParseInt($('#diskon').val());
     Sev=CekNanNParseInt($('#service').val());
     PPN=CekNanNParseInt($('#ppn').val());
     total =(sub+ Sev +PPN)- Dis

     $('#total').val(total);
  }

   function GetDiskon(status='perdiskon',loadtotalmenu=true){
    
    var diskon,sub,PerDis,Dis;
     sub=CekNanNParseInt($('#subtotal').val());
     PerDis=CekNanNParseInt($('#persendiskon').val());
     Dis=CekNanNParseInt($('#diskon').val());
     if(status=='perdiskon'){
        diskon=(sub*PerDis)/100;
        $('#diskon').val(diskon);

     }else{
        diskon=sub/Dis;
        $('#persendiskon').val(diskon);

     }
     if(loadtotalmenu){
        GetTotalMenu();
    }
   }

function GetService(status='persenservice',loadtotalmenu=true){
    
    var service,sub,PerSer,Ser;
     sub=CekNanNParseInt($('#subtotal').val());
     PerSer=CekNanNParseInt($('#persenservice').val());
     Ser=CekNanNParseInt($('#service').val());
     if(status=='persenservice'){
        service=(sub*PerSer)/100;
        $('#service').val(service);

     }else{
        service=sub/Ser;
        $('#persenservice').val(service);

     }
     if(loadtotalmenu){
        GetTotalMenu();
    }
   }
function GetPPN(status='persenppn',loadtotalmenu=true){
    
    var PPNTot,sub,PerPPN,PNN;
     sub=CekNanNParseInt($('#subtotal').val());
     PerPPN=CekNanNParseInt($('#persenppn').val());
     PPN=CekNanNParseInt($('#ppn').val());
     if(status=='persenppn'){
        PPNTot=(sub*PerPPN)/100;
        $('#ppn').val(PPNTot);

     }else{
        PPNTot=sub/PPN;
        $('#persenppn').val(PPNTot);

     }
     if(loadtotalmenu){
        GetTotalMenu();
    }
   }

function GetKembali(){
    
    var tunai,total,kartu,bayar,kembali;
        tunai=CekNanNParseInt($('#tunai').val());
        total=CekNanNParseInt($('#total').val());
        kartu=CekNanNParseInt($('#kartu').val());
        bayar=tunai+kartu;
        kembali=bayar-total;
        $('#bayar').val(bayar);
        $('#kembali').val(kembali);

   }
function DeleteRow(id,idpesananrow){
    
  $('.pesananid_'+id).remove();
  $('#idpesananrow_'+idpesananrow).remove();
}

function PembayaranRadio(status='tunai'){
    
    $("#tempohari").prop('disabled', true);
    $("#tempohari").val('');
   
    

    
 if(status=='kamar'){
    $("#nokamarid").prop('disabled', false);
    $("#pelangganid").select2("val", "-");
    $("#jenispembayaran3").prop("checked", "checked");
 }else if(status=='tempo'){
    $("#tempohari").prop('disabled', false);
    $("#pelangganid").select2("val", "-");
    $("#jenispembayaran2").prop("checked", "checked");
 }else if(status=='tunai' || status=='2'){
   $("#nokamarid").prop('disabled', true);
    $("#nokamarid").select2("val", "-");
   
   $("#jenispembayaran1").prop("checked", "checked");
 }
}

function TambahrRow(id,kode,nama,harga,pesananid=0,kuantitas=1,tambah=true){


    var i=$('#table_menu tr').length-2;
  
    var update=false;
    var idupdate=0;
    for (var j = 0 ; j < i; j++) {  

        if($('#id_'+j).val()==id){
            update=true;
            idupdate=j;       
        }
    }

    if(update){

       var jumlah= CekNanNParseInt($('#kuantitas_'+idupdate).val())+1;

       $('#kuantitas_'+idupdate).val(jumlah);
      // alert(id+'+'+$('#pesananid_'+idupdate).val()+'+'+jumlah+' '+idupdate);
      ajaxkuantitas(id,$('#pesananid_'+idupdate).val(),jumlah);
       hitungJumlah(idupdate);

    }else{
    $('#table_menu').find('tbody').append("<tr class='pesananid_"+pesananid+"'><input type='hidden' id='pesananid_"+i+"' value='"+pesananid+"'><td><input class='form-control' type='hidden' value='"+id+"' id='id_"+i+"' name='id_"+i+"'>"+kode+"</td><td>"+nama+"</td><td><input class='form-control' type='text' value='"+kuantitas+"' id='kuantitas_"+i+"' name='kuantitas_"+i+"' onkeyup='hitungJumlah("+i+");ajaxkuantitas("+id+","+pesananid+",this.value);'></td><td><input class='form-control' type='hidden' value='"+harga+"' id='harga_"+i+"' name='harga_"+i+"'>"+harga+"</td><td><input class='form-control' type='text' value='0' id='diskon_"+i+"' name='diskon_"+i+"' onkeyup='hitungJumlah("+i+");'></td><td><input class='form-control' type='text' id='jumlah_"+i+"' name='jumlah_"+i+"' readonly></td></tr>");


     }
         
     
     hitungJumlah(i);
    var rowCount = $('#table_menu tr').length-2;
    if(tambah){
      $('#jumrowmenu').val(rowCount);
    }
    $('#kuantitas_'+rowCount).focus();
     $('#jumrowmenupesanerror').val(rowCount);
    
    i=i+1;
}

function TambahrRowPesanan(id,kodemeja,mejaid,namapemesan,nobukti){


    var i=$('#table_pesanan tr').length-1;
  
    var update=false;
    var idupdate=0;
    for (var j = 0 ; j < i; j++) {
       
        
        if($('#idpesanan_'+j).val()==id){
            update=true;
            idupdate=j;
           
           
        }
    }
    if(update){


    }else{
    var rowCount = $('#table_pesanan tr').length-1; 
    //alert(rowCount);
    if(lastrowpesanan==rowCount){
        rowCount=rowCount+1;
    }else{
        rowCount=lastrowpesanan;
    }
    $('#table_pesanan').find('tbody').append("<tr id='idpesananrow_"+i+"'><td><input type='hidden' id='idpesanan_"+i+"' name='idpesanan_"+i+"' value='"+id+"'><input type='hidden' id='idmeja_"+i+"' name='idmeja_"+i+"' value='"+mejaid+"'>"+kodemeja+"</td><td>"+nobukti+"</td><td><button class='btn btn-danger' type='button' onclick='DeleteRow("+id+","+i+")'>-</button></td></tr>");

    lastrowpesanan=rowCount;
  
    $('#jumlahrowpesanan').val(rowCount);


    ajax(id);

    }
         
     
   
}

function ajax(id){
      $.ajax({
        url: "<?php echo $this->pathFor('kasir-ajax'); ?>",
        type: "POST",
        dataType: "json",
        data: "id=" + id,
        success: function(data) {
            $.each(data, function( k, v ) {
             //alert( v[''] + ", Value: " + v );
            TambahrRow(v['id'],v['kode'],v['nama'],v['hargajual'],id,v['kuantitaspesanan'],false);

            });

            //console.log(data);
            
      }
    });
}
function ajaxkuantitas(idmenu,idpesanan,jum){

  if(idpesanan!=0){
      $.ajax({
        url: "<?php echo $this->pathFor('kasir-ajaxupdate'); ?>",
        type: "POST",
        dataType: "json",
        data: "idmenu=" + idmenu+'&idpesanan='+idpesanan+'&kuantitas='+jum,
        success: function(data) {
         
            console.log(data);
            
      },error:function(data) {
         
            console.log(data);
            
      }
    });
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
</script>

