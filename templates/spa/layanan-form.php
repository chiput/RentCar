<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Layanan',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Spa',
    'submain_location' => 'Layanan'
  ]);
?>
<!-- <?php if(@$this->getSessionFlash('error_messages')){ ?>
    <?php print_r($this->getSessionFlash('error_messages')) ?>
    <?php print_r($this->getSessionFlash('post_data'));?>
<?php } ?> -->

<!--Start Pemberitahuan-->
  <div id="NotANumber" class="myadmin-alert myadmin-alert-icon myadmin-alert-click alert-danger myadmin-alert-top alerttop"> <i class="fa fa-ban"></i> Harus Masukan Anggka  !  <a href="#" class="closed">&times;</a> </div>

  <div id="HargajualValid" class="myadmin-alert myadmin-alert-icon myadmin-alert-click alert-danger myadmin-alert-top alerttop"> <i class="fa fa-ban"></i> Jumlah Harga Jual Terlalu Kecil !  <a href="#" class="closed">&times;</a> </div>

  <div id="DataKosongValid" class="myadmin-alert myadmin-alert-icon myadmin-alert-click alert-danger myadmin-alert-top alerttop"> <i class="fa fa-ban"></i> Ada Data Kosong !  <a href="#" class="closed">&times;</a> </div>


<!--End Pemberitahuan-->
<div class="row" id="Form_Menu">
    <div class="col-sm-12">
      <div class="white-box">
        <h3 class="box-title m-b-0">Form Layanan SPA</h3>
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
        <form class="form-horizontal" id='menu_form' action="<?php echo $this->pathFor('spa-layanan-save') ?>" method="POST">
        <input type="hidden" class="form-control" value="<?=@$layanan->id?>" name="id">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-12"> <span class="help">Kode</span></label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" id='kode'  name="kode" value="<?=@$layanan->kode;?>">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-12"> <span class="help">Nama</span></label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" id='nama' name="nama" value="<?=@$layanan->nama_layanan;?>">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group ">
                    <label class="col-md-12"> <span class="help">Kategori</span></label>
                    <div class="col-md-12">
                      <select  class="form-control" name='kategoriid'  id='kategoriid'>
                          <option value="">Pilih Kategori</option>
                          <?php
                          foreach($kategori_layanan as $kategori_layanan){
                            if(@$layanan->kategoriid==$kategori_layanan->id){
                                $selected="selected='selected'";
                            }else{
                                   $selected="";
                            }

                            ?>

                          <option value="<?=$kategori_layanan->id;?>" <?=$selected;?> ><?=$kategori_layanan->nama;?></option>
                          <?php } ?>
                      </select>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="box-title m-b-0">Bahan</h3>    
        <div  class="form-group" id="root">
            <div>
                    <table class="table" id='table_barang'>
                        <thead>
                            <tr>
                                <th></th>
                                <th>Kode</th>
                                <th>Nama Barang</th> 
                                <th>Harga Beli</th>
                                <th></th>
                                <th>Satuan</th>
                                <th>Gudang</th>
                                <th>Sat.Pakai</th>
                                <th>Kuantitas</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php
                           if(count($layanandetails)>0){
                                $i=0;
                                foreach ($layanandetails as $layanandetail) {?>
                               <tr>
                                    <td><a href='javascript:void(0)'  data-toggle='tooltip' onclick='del(this)'' data-original-title='Hapus'> <i class='fa fa-close text-danger'></i></a></td>
                                    <td>
                                    <?=@$layanandetail->kode;?>
                                    <input type='hidden' id='id_<?=$i;?>' name='id_<?=$i;?>' value="<?=@$layanandetail->id;?>">
                                    <input type='hidden' id='idbarang_<?=$i;?>' name='idbarang_<?=$i;?>' value="<?=$layanandetail->barangid;?>"></td>
                                    <td>
                                    <?=@$layanandetail->barangnama;?>
                                    </td>
                                    <td><input class='form-control'  type='text' readonly id='harga_<?=$i;?>' value="<?=@$layanandetail->hargastok;?>"></td>
                                    <td>/</td>
                                    <td>
                                     <select style="display: none" disabled class='form-control' name='satuan_<?=$i;?>'  id='satuan_<?=$i;?>'>
                                    <option value="">Pilih Kategori</option>
                                    <?php
                                    $satuaanid=@$layanandetail->satuanbarang;
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
                                     <td>
                                    <input type='text' name='gudang_<?=$i;?>'  id='gudang_<?=$i;?>' value="<?=@$layanandetail->gudangid;?>" style="display: none"><?=@$layanandetail->gudangid;?>
                                    </td>
                                     <td>
                                    <select class='form-control' name='satuanpakai_<?=$i;?>'  id='satuanpakai_<?=$i;?>' onchange="total($('#kuantitas_<?=$i;?>').val(),this.id);GetTotalBahan();">
                                    <option value="">Pilih Kategori</option>
                                    <?php
                                    $satuaanid=@$layanandetail->satuan;
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
                                    <input class='form-control'  type='text'  onkeyup="total(this.value,this.id);GetTotalBahan();" id='kuantitas_<?=$i;?>' name='kuantitas_<?=$i;?>' value='<?=@$layanandetail->kuantitas;?>'>
                                    </td>
                                   
                                   
                                    <td>
                                    <input class='form-control'  id='total_<?=$i;?>' type='text' readonly value='<?=@$layanandetail->hargastok*@$layanandetail->kuantitas;?>'>
                                    </td>
                                </tr>

                             <?php  $i++; }
                           }else{
                            }?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colSpan="4">
                                    <a href="#" alt="default" data-toggle="modal" data-target="#responsive-modal-Barang" class="model_img img-responsive">Tambah Barang</a>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label class="col-md-12"> <span class="help">Total Bahan</span></label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" id='totalbahan'  name="totalbahan" readonly>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="col-md-12"> <span class="help">Biaya Lain</span></label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" id='biayalain' onkeyup="GetTotalBahan();" value="<?=@$layanan->biayalain;?>" name="biayalain"  onchange="isNumberRestoran(this.value,this.id)">
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="col-md-12"> <span class="help">Total</span></label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" id='finaltotal'  name="finaltotal" readonly>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-12"> <span class="help">Harga Jual</span></label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" id='hargajual' value="<?=@$layanan->hargajual;?>" name="hargajual" onchange="isNumberRestoran(this.value,this.id);ValidasiHargaJual()">
                    </div>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label class="col-md-12"> <span class="help">Diskon</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" value="<?=@$layanan->diskon==''?0:@$layanan->diskon?>" name="diskon" />
                    </div>
                        <label class="control-label" style="text-align: center;"><span class="help">&nbsp%</span></label>
                </div>
            </div>
            <div class="form-group col-md-6">
                <div class="checkbox checkbox-success">
                    <?php if (!isset($layanan->is_active)): ?>
                        <input id="is_active" name="is_active" type="checkbox" checked="checked" />
                        <label for="is_active"> Aktif</label>
                      <?php else: ?>
                        <input id="active" type="checkbox" value="1" <?=@$layanan->is_active==1?'checked="checked"':''?> name="is_active">
                        <label for="active"> Aktif </label>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group col-md-12" style="display: none">
                <label class="col-md-12"> <span class="help">Jumlah Row</span></label>
                <div class="col-md-12">
                <input type="text" class="form-control" id='jumrow'  name="jumrow">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <button type="button"  class="btn btn-success waves-effect waves-light m-r-10" id="simpan">Simpan</button>
                    <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('layanan')?>">Batal</a>
                </div>
            </div>
        </div>
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

            <input style="display: none;" type="text" class="form-control" onkeyup="Pencarian_accunt();" id="myInput1">
            <table class="table table-striped myDataTable " id="myTable1">
                <thead>
                <tr class="ppp">
                    <th>Aksi</th>
                    <th>No Account</th>
                    <th>Nama</th>
                </tr>
                </thead>
                <tbody>
                 <?php foreach ($Accounts as $Account) {
                   ?>

                    <tr>
                    <td><button type="button" class="btn btn-info waves-effect waves-light" data-dismiss="modal" onclick="$('#Accountid').val('<?=$Account->id?>');$('#Account').val('<?=$Account->code?>');">Pilih</button></td>
                    <td><?=$Account->code;?></td>
                    <td><?=$Account->name;?></td>
                </tr>
            <?php
                } ?>
                 </tbody>
            </table>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;" id="responsive-modal-Barang">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="">Daftar Barang</h4>
            </div>
            <div class="modal-body">
                <table class="table myDataTable">
                    <thead>
                        <tr>
                            <th>Aksi</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Gudang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($Barangs as $Barang){ ?>
                        <tr>
                    <td><button type="button" class="btn btn-info waves-effect waves-light" data-dismiss="modal" onclick="TambahrRow('<?=$Barang->kode;?>','<?=$Barang->nama;?>','<?=$Barang->brgsatuan_id;?>','<?=$Barang->hargastok;?>','<?=$Barang->id;?>','<?=$Barang->satuannama;?>','<?=$Barang->gudid;?>','<?=$Barang->namagud;?>')">Pilih</button></td>
                    <td><?=$Barang->kode;?></td>
                    <td><?=$Barang->nama;?></td>
                    <td><?=$Barang->namagud;?></td>
                   </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>

<script type="text/javascript">
$(document).ready(function(){
var format = new curFormatter();
format.input('.totalbahan');
format.input('#biayalain');
format.input('#hargajual');
format.input('.finaltotal');

  $('#myTable2').DataTable({
        "order": []
      }); //paging causing confusion
 Konversi();
    $('#biayalain').val('<?php if(@$layanan->biayalain){echo @$layanan->biayalain;}else{echo 0;}?>');



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
    var format = new curFormatter();
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
       $('#table_barang').find('tbody').append(" <tr><td><a href='javascript:void(0)'  data-toggle='tooltip' onclick='del(this)'' data-original-title='Hapus'> <i class='fa fa-close text-danger'></i></a></td><td>"+kode+"<input type='hidden' id='idbarang_"+i+"' name='idbarang_"+i+"' value='"+id+"'><input type='hidden' id='id_"+i+"' name='id_"+i+"' value='0'></td><td>"+nama+"</td><td style='display:block'><input class='form-control'  type='text' readonly id='harga_"+i+"' value='"+format.format(hargabeli)+"'></td><td>/</td><td>"+namasatuan+"<input type='hidden' value='"+satuan+"' name='satuan_"+i+"'  id='satuan_"+i+"'></td><td  >"+namagud+"<input style='display:none' type='text' name='gudang_"+i+"'  id='gudang_"+i+"' value='"+idgud+"'></td><td><select  class='form-control' name='satuanpakai_"+i+"'  id='satuanpakai_"+i+"' onchange='kuantitasfungsi(this.id)'><option value=''>Silakan Pilih</option><option value='"+satuan+"'>"+namasatuan+"</option></select></td><td><input class='form-control'  type='text'  onkeyup='total(this.value,this.id);GetTotalBahan();' id='kuantitas_"+i+"' name='kuantitas_"+i+"' value=1></td><td><input class='form-control'  id='total_"+i+"' value='"+format.format(hargabeli)+"' type='text' readonly></td></tr>");
    
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
function del(ele) {
        var toprow = $(ele).closest("tr");
        toprow.remove(); 
        GetTotalMenu();
    }
function ajaxkonversi(no,satuan){
    $.ajax({
        url: "<?php echo $this->pathFor('spa-layanan-ajaxKonversi'); ?>",
        type: "POST",
        dataType: "json",
        data: "id=" + satuan,
        success: function(data) {
            $.each(data, function( k, v ) {

            if(v.brgsatuan_id2 != satuan){
                $('#satuanpakai_'+no).append("<option value='"+v['brgsatuan_id2']+"'>"+v['nama']+"</option>");
            }

            });

            //console.log(data);      
      },error : function(data){
        console.log(data);
      }
    }); 
}
</script>
