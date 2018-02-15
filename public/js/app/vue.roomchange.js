if(document.getElementById("roomChange")!=null){

  var format = new curFormatter();

  var getAvail=function(radio){
    var selRoom=roomChange.rooms_booked.filter(function(ele){
      return radio.value==ele.rooms_id;
    });
    console.log(selRoom[0].id);
    roomChange.reservations_detail_id=selRoom[0].id;

      $("#alertRoom").slideDown(500);
      $.ajax({
        method:"GET",
        dataType:"JSON",
        url:room_url+$("input[name='date']").val()+'/'+selRoom[0].checkout.substring(0,10)+'/'+selRoom[0].agent_id
      }).done(function(msg){
        var avail=msg.filter(function(ar){
          return ar.status=='Vacant';
        }).map(function(ar){

          var price=0;
          for(var x in ar.rates){
            price+=parseInt(ar.rates[x].room_price.split(".").join(""));
            pricetampil = numeral(price).format('0,0');
          }
          ar.price=format.format(price);
          ar.pricetampil=pricetampil;
          return ar;
        });
        roomChange.rooms_avail=avail;
        $("#alertRoom").slideUp(500);

      });

  }

  var setRoom=function(e){
    var selRoom=roomChange.rooms_avail.filter(function(room){
      return room.id==e.value;
    });
    roomChange.selAvail=selRoom[0];
    //console.log(roomChange.selAvail.price);
  };

  var reload=function(e){
    //e.preventDefault();
    $("#alertResv").slideDown(500);
    $.ajax({
      method:"POST",
      dataType:"json",
      data:"date="+$("input[name='date']").val(),
      url:"ajax_reserved_room"
    }).done(function(msg){
      roomChange.rooms_booked=msg;
      $("#alertResv").slideUp(500);
    });

    
  }


  var roomChange=new Vue({
    el: '#roomChange',
    data: {
      rooms_booked: [],
      reservations_detail_id: 0,
      selAvail: {price:0},
      rooms_avail: [],
    },
    methods:{

    }    
  });

  $(document).ready(function(){
    reload();
  });

  
}