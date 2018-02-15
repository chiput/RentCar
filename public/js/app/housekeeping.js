if(document.getElementById("housekeeping")!=null){

  function getGuest(ele){
      var data=JSON.parse(ele.dataset.guestJson);
      $('[name="checkinid"]').val(data.checkin_code);
      $('[name="guests_address"]').val(data.address);
  }

  function myFunction(id) {
  var idku = id;
  console.log(id);
  document.getElementById("kamar").value = idku;
  }
}
