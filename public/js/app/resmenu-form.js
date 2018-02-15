if(document.getElementById("Form_Menu")!=null){

$(document).ready(function(){
  
   var rowCount = $('#table_barang tr').length-2;
    $('#jumrow').val(rowCount);
    //alert(111);
    //$('#biayalain').val('0');
  GetTotalBahan();
  GetHargaJual();

});


  function total(value,id){
    var format = new curFormatter();

    id=id.split('_');  
    var total,hargabeli,konversi;
    hargabeli=$('#harga_'+id[1]).val();
    // console.log($('#satuan_'+id[1]).val());
     konversi=Konversi($('#satuanpakai_'+id[1]).val(),$('#satuan_'+id[1]).val());
     //alert(konversi);
    total=(format.unformat(hargabeli)*konversi)*value;    


    $('#total_'+id[1]).val(format.format(total));
  }
  function GetTotalBahan(){
    var format = new curFormatter();
    var rowCount;
    rowCount = $('#table_barang tr').length;
    rowCount=rowCount-2;
    var finaltotal=0;
    var totalbahan;
    for (x = 0; x < rowCount; x++) {
        //alert($('#total_'+x).val());
        totalbahan = $('#total_'+x).val();
        finaltotal=finaltotal+parseInt(format.unformat(totalbahan));
    }

    $('#totalbahan').val(format.format(finaltotal));
    GetHargaJual();
  }
  function GetHargaJual(){
    var format = new curFormatter();
    var biayalain;
    var totaljual;
   if(isNaN((parseInt($('#biayalain').val())))){
        biayalain=0;
   }else{
      biayalain = $('#biayalain').val();
        biayalain=parseInt(format.unformat(biayalain));
   }
    totaljual = $('#totalbahan').val();
    var totaljual =parseInt(format.unformat(totaljual))+format.unformat(biayalain);
    $('#finaltotal').val(format.format(totaljual));

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
}
