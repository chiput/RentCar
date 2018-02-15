if(document.getElementById("reservation-vue")!=null){
  // window.initRooms=JSON.parse(document.getElementById("roomlist").value);
  // window.selList=JSON.parse(document.getElementById("sellist").value);



  var roomSelect=new Vue({
    el: '#reservation-vue',
    data: {
      rooms: [],
      selectedRooms: [],

    },
    methods:{
      loadRoom:function(e){

      },
      search:function(e){
        // var str=e.target.value;
        // var myVue=this;
        // if(e.target.value==""){
        //     $.each(myVue.rooms,function(index, el) {
        //         el.hidden=="";
        //     });
        // }else{
        //     $.each(myVue.rooms,function(index, el) {
        //         console.log(el.number.toUpperCase().indexOf(str.toUpperCase()));
        //         if(el.number.toUpperCase().indexOf(str.toUpperCase())<0){
        //             el.hidden=="display:none";    
        //         }else{
        //             el.hidden=="";    
        //         }
        //     });
        // }
      },
      addRoom:function(e){
        if(this.roomType+this.bedType!=''){
            this.selectedRooms=[];
        }
        this.roomType=''; 
        this.bedType='';     
        
      },
      checking:function(e){
        if(this.roomType+this.bedType!=''){
            this.roomType=''; 
            this.bedType='';     
            this.selectedRooms=[];
        }
        //this.selectedRooms=[];
        // this.roomType=''; 
        // this.bedType=''; 
      },
      roomFilter:function(e){
        var typeId=e.target.value;
        this.selectedRooms=[];
        var myVue=this;
        $.each(myVue.rooms,function(index,ele){
          if((ele.room_type_id==myVue.roomType && ele.bed_type_id==myVue.bedType)||(ele.room_type_id==myVue.roomType && myVue.bedType=="")
            ||(myVue.roomType=="" && ele.bed_type_id==myVue.bedType)){
            myVue.selectedRooms.push(ele.id);
          }
        });
      },
      deleteRoom:function(e){
        var roomId=e.target.dataset.roomId;
        console.log(e.target);
        periodicRate.selectedRooms=periodicRate.selectedRooms.filter(function(ele){
            return (ele!=roomId);
        });
      }
    }
  });

  $.each(selList,function(index, el) {
    periodicRate.selectedRooms.push(el.rooms_id);
  });
  
}