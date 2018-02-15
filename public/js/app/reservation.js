var _mydatatable;
if(document.getElementById("reservation-app")!=null){
  var company_sel;
    var objcancel = document.querySelector('[name="canceldate"]');
    var objstatus = document.querySelector('[name="status"]');
    objstatus.addEventListener('change',function(){
        if(this.value=="2"){
            document.getElementById('canceldate').style.display='block';
        }else{
            document.getElementById('canceldate').style.display='none';
        }
    });
        
    $(document).ready(function() {
        company_sel=$("#guests_company_id").select(2);
        //if(document)
        if(objstatus.value=="2"){
            document.getElementById('canceldate').style.display='block';
        }else{
            document.getElementById('canceldate').style.display='none';
        }
    });

    window.getRooms=(function(){
        if(typeof _mydatatable=='object'){
          _mydatatable.destroy();
        }
        $("#roomModal").modal('show');
        $("#roomTable tbody").html('');
        $.ajax({
                dataType:'JSON',
                url:document.getElementById('theurl').value+'/../../../'+$("[name='checkin']").val()+'/'+$("[name='checkout']").val()+'/'+$("[name='agent_id']").val(),
            }).done(function( data ) {
                //console.log(data);
                var rooms=[];

                    var i; var r;
                    for(i=0;i<=data.length-1;i++){
                        for(r=0;r<=rooms.length-1;r++){
                            //console.log(' rooms:'+rooms[r].id+' data:'+data[i].id+' r:'+r+' i:'+i);
                            if(rooms[r].id==data[i].id){
                                data.splice(i,1);
                                r=rooms.length-1;
                            }
                        }
                    }
                    var tr="";
                    var selected=[];
                    $('[name="rooms_id[]"]').each(function(index, el) {
                        selected.push(el.value);
                    });
                    $.each(data,function(index, el) {
                        var rate="";
                        var cek=selected.filter(function(c){
                            return c==el.id;
                        });
                        //console.log(cek);
                        var message = "";

                        //Before
                        if(el.status != "Out of Service") {
                            message = '<button value='+"'"+JSON.stringify(el)+"'"+' ref="btn" onclick="sendRoom(this)" data-toggle="tooltip" class="btn btn-info" data-original-title="Pilih" data-dismiss="modal"> <i className="fa fa-pencil text-inverse m-r-10"></i> Pilih</button>';
                        }
                        if(el.status == "Booking") {
                            message = '<button value='+"'"+JSON.stringify(el)+"'"+' ref="btn" onclick="sendRoom(this)" data-toggle="tooltip" class="btn btn-danger disabled" disabled data-original-title="Pilih" data-dismiss="modal"> <i className="fa fa-pencil text-inverse m-r-10"></i> Pilih</button>';
                        }

                        //After
                        // if(el.status != "Out of Service") {
                        //     if(el.status == "Occupied") {
                        //         message = '<button value='+"'"+JSON.stringify(el)+"'"+' ref="btn" onclick="sendRoom(this)" data-toggle="tooltip" class="btn btn-danger" data-original-title="Pilih" data-dismiss="modal" disabled> <i className="fa fa-pencil text-inverse m-r-10"></i> Pilih</button>';
                        //     } else {
                        //     message = '<button value='+"'"+JSON.stringify(el)+"'"+' ref="btn" onclick="sendRoom(this)" data-toggle="tooltip" class="btn btn-info" data-original-title="Pilih" data-dismiss="modal"> <i className="fa fa-pencil text-inverse m-r-10"></i> Pilih</button>';
                        //     }
                        // }

                        if(cek.length<1){
                            $.each(el.rates,function(index, rt) {
                            var myDate=rt.date;
                            myDate=myDate.split("-");
                            var newDate=myDate[2]+"-"+myDate[1]+"-"+myDate[0];
                                rate+='<tr>'
                                    +'<td>'+newDate+'</td>'
                                    +'<td>'+rt.room_price+'</td>'
                                    +'<td>'+rt.room_only_price+'</td>'
                                    +'<td>'+rt.breakfast_price+'</td>'
                                +'</tr>';
                            });

                            tr+='<tr key={data.id}>'
                                +'<td>'+el.number+'</td>'
                                +'<td>'+el.plat_number+'</td>'
                                +'<td>'+el.type_name+'</td>'
                                +'<td hidden>'
                                    +'<table class="table">'
                                        +'<thead>'
                                            +'<tr>'
                                                +'<th>Tanggal</th>'
                                                +'<th>Total</th>'
                                                +'<th>Mobil</th>'
                                                +'<th>Bahan Bakar</th>'
                                            +'</tr>'
                                        +'</thead>'
                                        +'<tbody>'
                                        +rate
                                        +'</tbody>'
                                    +'</table>'
                                +'</td>'
                                +'<td>'+el.status+'</td>'
                                +'<td>'
                                    +message
                                +'</td>'
                            +'</tr>';
                        }
                    });
                        
                    $("#roomTable tbody").html(tr);
                    
                    _mydatatable = $("#roomTable").DataTable({
                      "order": []
                    });

                });
            
    });
        

    function getGuest(ele){

        var data=JSON.parse(ele.dataset.guestJson);
        var myDate=data.date_of_birth;
        myDate=myDate.split("-");
        var newDate=myDate[2]+"-"+myDate[1]+"-"+myDate[0];

        $('[name="guests_id"]').val(data.id);
        $('[name="guests_name"]').val(data.name);
        $('[name="guests_address"]').val(data.address);
        $('[name="guests_date_of_birth"]').val(newDate);
        $('[name="guests_sex"]').val(data.sex);
        $('[name="guests_idtype_id"]').val(data.idtype_id);
        $('[name="guests_idcode"]').val(data.idcode);
        $('[name="guests_countries_id"]').val(data.country_id);
        company_sel.val(data.company_id).trigger('change');
        $('[name="guests_state"]').val(data.state);
        $('[name="guests_city"]').val(data.city);
        $('[name="guests_zipcode"]').val(data.zipcode);
        $('[name="guests_phone"]').val(data.phone);
        $('[name="guests_fax"]').val(data.fax);
        $('[name="guests_email"]').val(data.email);      

    }

    function sendRoom(ele){
        console.log(ele.value);
        var format = new curFormatter();

        var rm=JSON.parse(ele.value);
        var price=0;
        var priceExtra=0;

        $.each(rm.rates,function(index, rate) {
            price+=parseInt(format.unformat(rate.room_price));
        });
        $("#room").append('<tr>'
                                +'<td rowSpan="2">'+rm.number+'<input type="hidden" name="rooms_id[]" value="'+rm.id+'" />'
                                +'<a href="javascript:void(0)" onclick="deleteRoom(this),findTotal()" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i></a> </td>'
                                +'<td>'+rm.type_name+'</td>'
                                +'<td><input type="text" class="form-control price'+rm.id+'" name="price[]" value="'+format.unformat(price)+'" onkeyup="findTotal()"/></td>'
                            +'</tr>'+
                            '<tr >'
                                +'<td>Harga Sopir</td>'
                                +'<td><input type="text" class="form-control priceExtra'+rm.id+'" name="priceExtra[]" value="'+priceExtra+'" onkeyup="findTotal()"/></td>'
                            +'</tr>');

        format.input('.price'+rm.id);
        format.input('.priceExtra'+rm.id);

        findTotal();
    }

    function deleteRoom(ele){
        var toprow = $(ele).closest("tr");
        toprow.next().remove(); 
        toprow.remove(); 

    }
    function clearGuest(){
        $("#guestInfo input,#guestInfo select").each(function(index, ele) {
            $(ele).val("");
            //$(ele).attr({'readonly':false,'disabled':false,'data-isEmpty':true});
        });
    }
  
}