<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Menu',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Restoran',
    'submain_location' => 'Menu'
  ]);
?>
<!-- <?php if(@$this->getSessionFlash('error_messages')){ ?>
<div class="error">
    <?php print_r($this->getSessionFlash('error_messages')) ?>
    <?php print_r($this->getSessionFlash('post_data'));?>
    <?php //print_r($jurnal);?>
    <?php //print_r($jurnaldetail);?>
    <pre>
    <?php
        //echo json_encode($jurnaldetail);
        // foreach ($jurnaldetail as $key => $value) {
        //     //print_r($value->account->name);
        // }
    ?>
    </pre>
    <?php
    ?>
</div>
<?php } ?> -->

<!--Start Pemberitahuan-->
  <div id="NotANumber" class="myadmin-alert myadmin-alert-icon myadmin-alert-click alert-danger myadmin-alert-top alerttop"> <i class="fa fa-ban"></i> Harus Masukan Anggka  !  <a href="#" class="closed">&times;</a> </div>

  <div id="HargajualValid" class="myadmin-alert myadmin-alert-icon myadmin-alert-click alert-danger myadmin-alert-top alerttop"> <i class="fa fa-ban"></i> Jumlah Harga Jual Terlalu Kecil !  <a href="#" class="closed">&times;</a> </div>

  <div id="DataKosongValid" class="myadmin-alert myadmin-alert-icon myadmin-alert-click alert-danger myadmin-alert-top alerttop"> <i class="fa fa-ban"></i> Ada Data Kosong !  <a href="#" class="closed">&times;</a> </div>


<!--End Pemberitahuan-->
<div class="row" id="Form_Menu">
    <div class="col-sm-12">
      <div class="white-box">

        <h3 class="box-title m-b-0">Form Menu</h3>
        <p class="text-muted m-b-20 font-13"> </p>
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
        <form class="form-horizontal" id='menu_form' action="<?php echo $this->pathFor('restoran-menu-save') ?>" method="POST">
        <input type="hidden" class="form-control" value="<?=@$menu->id?>" name="id">
        <div class="form-group col-md-12">
            <label class="col-md-12"> <span class="help">Kode</span></label>
            <div class="col-md-12">
              <input type="text" class="form-control" id='kode'  name="kode" value="<?=@$menu->kode;?>">
            </div>
        </div>
        <div class="form-group col-md-6">
            <label class="col-md-12"> <span class="help">Nama</span></label>
            <div class="col-md-12">
              <input type="text" class="form-control" id='nama'  name="nama" value="<?=@$menu->nama;?>">
            </div>
        </div>
        <div class="form-group col-md-6">
            <label class="col-md-12"> <span class="help">Kategori</span></label>
            <div class="col-md-12">

              <select  class="form-control" name='kategoriid'  id='kategoriid'>
                  <option value="">Silakan Pilih</option>
                  <?php
                  foreach($Menu_kategoris as $Menu_kategori){
                    if(@$menu->kategoriid==$Menu_kategori->id){
                        $selected="selected='selected'";
                    }else{
                           $selected="";
                    }

                    ?>

                  <option value="<?=$Menu_kategori->id;?>" <?=$selected;?> ><?=$Menu_kategori->nama;?></option>
                  <?php } ?>
              </select>


            </div>
        </div>
        <div class="form-group">
            <label class="col-md-12"> <span class="help">Pembuatan</span></label>
            <div class="col-md-12">
            <textarea class="form-control" id='pembuatan' name='pembuatan'><?=@$menu->keterangan;?></textarea>
            </div>
        </div>

        <h3 class="box-title m-b-0">Bahan</h3>    
        <div  class="form-group" id="root">
            <div>
                    <table class="table" id='table_barang'>
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Barang</th> 
                                <th>Harga Beli</th>
                                <th></th>
                                <th>Satuan</th>
                                <th>Gudang</th>
                                <th>Sat.Paka</th>
                                <th>Kuantitas</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php
                           if(count($menudetails)>0){
                                $i=0;
                                foreach ($menudetails as $menudetail) {?>
                               <tr>
                                   <td>
                                    <?=@$menudetail->kode;?>
                                    <input type='hidden' id='id_<?=$i;?>' name='id_<?=$i;?>' value="<?=@$menudetail->id;?>">
                                    <input type='hidden' id='idbarang_<?=$i;?>' name='idbarang_<?=$i;?>' value="<?=$menudetail->barangid;?>"></td>
                                    </td>
                                    <td>
                                    <?=@$menudetail->barangnama;?>
                                    </td>
                                    <td><input class='form-control'  type='text' readonly id='harga_<?=$i;?>' value="<?=@$menudetail->hargajual;?>"></td>
                                    <td>/</td>
                                    <td>
                                     <select style="display: none" disabled class='form-control' name='satuan_<?=$i;?>'  id='satuan_<?=$i;?>'>
                                    <option value="">Silakan Pilih</option>
                                    <?php
                                    $satuaanid=@$menudetail->satuanbarang;
                                    foreach (@$Bargsatuans as $Bargsatuan) {
                                    if(@$satuaanid==$Bargsatuan->id){
                                    $selected="selected='selected'";
                                    $nama=$Bargsatuan->nama;
                                    }else{
                                    $selected="";

                                    }?>

                                    <option value='<?=@$Bargsatuan->id;?>' <?=$selected;?> > <?=@$Bargsatuan->nama;?></option>
                                    <?php } ?>
                                    </select>
                                    <?php if($nama){echo $nama;}else{echo "-";}?>
                                    </td>
                                     <td >
                                    

                                    <input type='text' name='gudang_<?=$i;?>'  id='gudang_<?=$i;?>' value="<?=@$menudetail->gudangid;?>" style="display: none"><?=@$menudetail->gudangid;?>
                                    </td>
                                     <td>

                                    <select class='form-control' name='satuanpakai_<?=$i;?>'  id='satuanpakai_<?=$i;?>' onchange="total($('#kuantitas_<?=$i;?>').val(),this.id);GetTotalBahan();">
                                    <option value="">Silakan Pilih</option>
                                    <?php
                                    $satuaanid=@$menudetail->satuan;
                                    foreach (@$Bargsatuans as $Bargsatuan) {
                                    if($satuaanid==@$Bargsatuan->id){
                                    $selected="selected='selected'";
                                    }else{
                                    $selected="";
                                    }?>

                                    <option value='<?=@$Bargsatuan->id;?>' <?=$selected;?> > <?=@$Bargsatuan->nama;?></option>
                                    <?php } ?>
                                    </select>
                                    </td>
                                    <td>
                                    <input class='form-control'  type='text'  onkeyup="total(this.value,this.id);GetTotalBahan();" id='kuantitas_<?=$i;?>' name='kuantitas_<?=$i;?>' value='<?=@$menudetail->kuantitas;?>'>
                                    </td>
                                   
                                   
                                    <td>
                                    <input class='form-control'  id='total_<?=$i;?>' type='text' readonly value='<?=@$menudetail->hargajual*@$menudetail->kuantitas;?>'>
                                    </td>
                                </tr>

                             <?php  $i++; }
                           }else{
                            }?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colSpan="4">
                                    <a href="#" alt="default" data-toggle="modal" data-target="#responsive-modal-Barang" className="model_img img-responsive">Tambah Barang</a>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                </div>
        </div>
        <div class="form-group col-md-6">
            <label class="col-md-12"> <span class="help">Total Bahan</span></label>
            <div class="col-md-12">
            <input type="text" class="form-control" id='totalbahan'  name="totalbahan" readonly>
            </div>
        </div>
          <div class="form-group col-md-6">
            <label class="col-md-12"> <span class="help">Account Penjualan</span></label>
            <div class="col-md-9"><?php //echo $menu->accountid; ?>
            <input type="text" class="form-control" id='Account'  name="Account" readonly  value="<?=@$Accountnama;?>">

            <input type="hidden" class="form-control" id='Accountid'  name="Accountid" value="<?=@$Accountid?>">
            </div>
             <div class="col-md-3">
                           <button type="button" class="form-control btn btn-primary"  data-toggle="modal" data-target="#responsive-modal">Cari</button>
                        </div>
        </div>
        <div class="form-group col-md-12">
            <label class="col-md-12"> <span class="help">Biaya Lain</span></label>
            <div class="col-md-12">
            <input type="text" class="form-control" onchange="isNumberRestoran(this.value,this.id)" id='biayalain' onkeyup="GetTotalBahan();"  name="biayalain" value="<?=@$menu->biayalain;?>">
            </div>
        </div>
        <div class="form-group col-md-12">
            <label class="col-md-12"> <span class="help">Total</span></label>
            <div class="col-md-12">
            <input type="text" class="form-control" id='finaltotal'  name="finaltotal" readonly>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label class="col-md-12"> <span class="help">Harga Jual</span></label>
            <div class="col-md-12">
            <input type="text" class="form-control" id='hargajual' value="<?=@$menu->hargajual;?>" name="hargajual" onchange="isNumberRestoran(this.value,this.id);ValidasiHargaJual()">
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="checkbox checkbox-success">
                <input id="active" type="checkbox" value="1" <?php if(@$menu->aktif==1||@$aktif==2){echo 'checked="checked"';}  ?>  name="is_active">
                <input id="aktif" type="checkbox" value="1" <?php if(@$menu->aktif==1||@$V_aktif=='2'){echo 'checked="checked"';}?> name="aktif">
                <label for="active"> Aktif </label>
            </div>
        </div>
        <div class="form-group col-md-12" style="display: none">
            <label class="col-md-12"> <span class="help">Jumlah Row</span></label>
            <div class="col-md-12">
            <input type="text" class="form-control" id='jumrow'  name="jumrow">
            </div>
        </div>
        <button type="button"  class="btn btn-success waves-effect waves-light m-r-10" id="simpan">Simpan</button>
        <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('menu')?>">Batal</a>

        </form>
      </div>
    </div>
</div>
<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Daftar Account</h4>
      </div>
      <div class="modal-body">
        <form>

            <input type="text" class="form-control" onkeyup="Pencarian_accunt();" id="myInput1">
            <table class="table" id="myTable1">
                <tr class="ppp">
                    <th>No Account</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
                 <?php foreach ($Accounts as $Account) {
                   ?>

                    <tr>
                    <td><?=$Account->code;?></td>
                    <td><?=$Account->name;?></td>
                    <td><button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal" onclick="$('#Accountid').val('<?=$Account->id?>');$('#Account').val('<?=$Account->code?>');">Pilih</button></td>
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
<div id="responsive-modal-Barang" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Daftar Barang</h4>
      </div>
      <div class="modal-body">
        <form>


            <input type="text" class="form-control" onkeyup="Pencarian_Barang();" id="myInput2">
            <table class="table" id='myTable2'>
                <tr class="ppp">
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Gudang</th>
                    <th>Aksi</th>
                </tr>
                 <?php foreach ($Barangs as $Barang) {
                   ?>

                    <tr>
                    <td><?=$Barang->kode;?></td>
                    <td><?=$Barang->nama;?></td>
                    <td><?=$Barang->namagud;?></td>
                    <td><button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal" onclick="TambahrRow('<?=$Barang->kode;?>','<?=$Barang->nama;?>','<?=$Barang->brgsatuan_id;?>','<?=$Barang->hargajual;?>','<?=$Barang->id;?>','<?=$Barang->satuannama;?>','<?=$Barang->gudid;?>','<?=$Barang->namagud;?>')">Pilih</button></td>
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

<script type="text/javascript">
$(document).ready(function(){
// alert('<?=@$menu->biayalain;?>');
 Konversi();
    $('#biayalain').val('<?php if(@$menu->biayalain){echo @$menu->biayalain;}else{echo 0;}?>');



    $( "#simpan" ).click(function() {

        var rowCount = $('#table_barang tr').length-2;
        //alert(rowCount);
        var ValidasiGudang=true;
        for (var i = 0 ; i < rowCount; i++) {
            //alert(i);
            if($('#gudang_'+i).val()==''){
                ValidasiGudang=false;
            }
        }
       // alert(ValidasiGudang);
        if(ValidasiGudang){
           $('#menu_form').submit(); 
       }else{
            $("#DataKosongValid").fadeToggle(350);
            setTimeout(function(){ $("#DataKosongValid").fadeToggle(350); }, 1000);
       }
        
        
    });
});

function Konversi(br1,br2){
    var nilai;
    if(br1==br2){
        nilai=1;
    }else{
        var konversi=<?=json_encode($Konversi);?>;
        nilai=0;
       // alert(br1+'&'+br2);
        for (var i = konversi.length - 1; i >= 0; i--) {
            if (br1==konversi[i]['brgsatuan_id1'] && br2==konversi[i]['brgsatuan_id2']){
                nilai=konversi[i]['nilai'];
            }
        }
    }
    return nilai; 
}
function kuantitasfungsi(id) {
    var id2=id;
     id=id.split('_');  
  total($("#kuantitas_"+id[1]).val(),id2);
  GetTotalBahan();
}
function TambahrRow(kode,nama,satuan,hargabeli,id,namasatuan,idgud,namagud){
    var i=$('#table_barang tr').length-2;

    var update=false;
    var idupdate=0;
    for (var j = 0 ; j < i; j++) {
       
        
        if($('#idbarang_'+j).val()==id){
            update=true;
            idupdate=j;
           
           
        }
    }
     console.log(update);
    if(update){

       var jumlah= CekNanNParseInt($('#kuantitas_'+idupdate).val())+1;

       $('#kuantitas_'+idupdate).val(jumlah);
       total($('#kuantitas_'+idupdate).val(),'id_'+idupdate);
        GetTotalBahan();
      // hitungJumlah(idupdate);

    }else{
//<select  class='form-control' name='gudang_"+i+"'  id='gudang_"+i+"' required><option value=''>Silakan Pilih</option> <?php foreach ($Gudangs as  $Gudang){ ?> <option value='<?=$Gudang->id;?>'><?=$Gudang->nama;?></option><?php } ?></select>

    var kuantitas="#kuantitas_"+i;
    // $('#table_barang').find('tbody').append(" <tr><td>"+kode+"<input type='hidden' id='idbarang_"+i+"' name='idbarang_"+i+"' value='"+id+"'><input type='hidden' id='id_"+i+"' name='id_"+i+"' value='0'></td><td>"+nama+"</td><td><input class='form-control'  type='text' readonly id='harga_"+i+"' value='"+hargabeli+"'></td><td>/</td><td>"+namasatuan+"<input type='hidden' value='"+satuan+"' name='satuan_"+i+"'  id='satuan_"+i+"'></td><td><select  class='form-control' name='gudang_"+i+"'  id='gudang_"+i+"' required><option value=''>Silakan Pilih</option><?php foreach ($Gudangs as  $Gudang){ ?> <option value='<?=$Gudang->id;?>'><?=$Gudang->nama;?></option><?php } ?></select></td><td><select  class='form-control' name='satuanpakai_"+i+"'  id='satuanpakai_"+i+"' onchange='kuantitasfungsi(this.id)'><option value=''>Silakan Pilih</option><?php foreach ($Bargsatuans as  $Bargsatuan){ ?> <option value='<?=$Bargsatuan->id;?>'><?=$Bargsatuan->nama;?></option><?php } ?></select></td><td><input class='form-control'  type='text'  onkeyup='total(this.value,this.id);GetTotalBahan();' id='kuantitas_"+i+"' name='kuantitas_"+i+"' value=1></td><td><input class='form-control'  id='total_"+i+"' value='"+hargabeli+"' type='text' readonly></td></tr>");
//Diatas Yanglama 
       $('#table_barang').find('tbody').append(" <tr><td>"+kode+"<input type='hidden' id='idbarang_"+i+"' name='idbarang_"+i+"' value='"+id+"'><input type='hidden' id='id_"+i+"' name='id_"+i+"' value='0'></td><td>"+nama+"</td><td style='display:block'><input class='form-control'  type='text' readonly id='harga_"+i+"' value='"+hargabeli+"'></td><td>/</td><td>"+namasatuan+"<input type='hidden' value='"+satuan+"' name='satuan_"+i+"'  id='satuan_"+i+"'></td><td  >"+namagud+"<input style='display:none' type='text' name='gudang_"+i+"'  id='gudang_"+i+"' value='"+idgud+"'></td><td><select  class='form-control' name='satuanpakai_"+i+"'  id='satuanpakai_"+i+"' onchange='kuantitasfungsi(this.id)'><option value=''>Silakan Pilih</option></select></td><td><input class='form-control'  type='text'  onkeyup='total(this.value,this.id);GetTotalBahan();' id='kuantitas_"+i+"' name='kuantitas_"+i+"' value=1></td><td><input class='form-control'  id='total_"+i+"' value='"+hargabeli+"' type='text' readonly></td></tr>");
    
    ajaxkonversi(i,satuan);

    $("#satuanpakai_"+i).val(satuan);
    $("#gudang_"+i).val(idgud);
    }

     $('#kuantitas_'+i).focus();
    var rowCount = $('#table_barang tr').length-2;
    $('#jumrow').val(rowCount);
    i=i+1;
  }
function Pencarian_Barang() {
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
function Pencarian_accunt() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput1");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable1");
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
function ajaxkonversi(no,satuan){
    $.ajax({
        url: "<?php echo $this->pathFor('restoran-menu-ajaxKonversi'); ?>",
        type: "POST",
        dataType: "json",
        data: "id=" + satuan,
        success: function(data) {
            $.each(data, function( k, v ) {
            
            $('#satuanpakai_'+no).append("<option value='"+v['brgsatuan_id2']+"'>"+v['nama']+"</option>");

            });

            //console.log(data);      
      },error : function(data){
        console.log(data);
      }
    }); 
}
</script>
