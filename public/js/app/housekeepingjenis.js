if(document.getElementById("housekeepingjenis")!=null){
  function getGuest(ele){
      var data=JSON.parse(ele.dataset.guestJson);

      $('[name="namabarang"]').val(data.nama);
      $('[name="namabarangid"]').val(data.id);
      $('[name="harga"]').val(data.hargajual);

  }
  function myFunction(id) {
    var idku = id;
    console.log(id);
    document.getElementById("kamar").value = idku;
  }
}
