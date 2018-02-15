if(document.getElementById("housekeepingkembali")!=null){

  function getGuest(ele){
      var data=JSON.parse(ele.dataset.guestJson);
      $('[name="nobukti"]').val(data.nobukti);
      $('[name="pinjam"]').val(data.kuantitas);
  }

  function myFunction(id) {
  var idku = id;
  document.getElementById("namabarang").value = idku;
  }

  function myFunction1(id) {
  var idku = id;
  document.getElementById("harga").value = idku;
  }

  function myFunction2(id) {
  var idku = id;
  document.getElementById("sewa").value = idku;
  }
  function myFunction3(id) {
  var idku = id;
  document.getElementById("kamar").value = idku;
  }
  function myFunction4(id) {
  var idku = id;
  document.getElementById("id").value = idku;
  }
}
