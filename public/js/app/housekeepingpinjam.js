if(document.getElementById("housekeepingpinjam")!=null){

  function getGuest(ele){
      var data=JSON.parse(ele.dataset.guestJson);
      $('[name="sewa"]').val(data.sewa);
      $('[name="namabarangid"]').val(data.barangid);
  }

  function myFunction(id) {
  var idku = id;
  document.getElementById("harga").value = idku;
  }

  function myFunction1(id) {
  var idku = id;
  document.getElementById("namabarang").value = idku;
  }

  function getGuest1(ele){
      var data=JSON.parse(ele.dataset.guestJson);
      $('[name="namakamarid"]').val(data.checkin_code);
  }

  function myFunction2(id) {
  var idku = id;
  document.getElementById("namakamar").value = idku;
  }
}
