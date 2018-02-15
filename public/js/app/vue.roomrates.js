// // var rates; var roomrates=[];
// // if(document.getElementById("roomrates-vue")!=null){
// //   var rs = JSON.parse(document.getElementById('room_rates').value);
// //   for( var rate in rs){
// //     //console.log(rs[rate]);
// //     roomrates[rs[rate].dayname_id]=rs[rate];
// //   }

// //     // window.onload = (function(){
// //     //     var breakfast = Array.from(document.querySelectorAll('.breakfast-price'));
// //     //     breakfast.map(function(ele){
// //     //         ele.addEventListener('keypress',function(e){
// //     //             e.preventDefault();
// //     //         })
// //     //     });
// //     // });

// //     var rates = new Vue({
// //       el: '#roomrates-vue',
// //       data: {
// //         daynames : JSON.parse(document.getElementById('daynames').value),
// //         roomrates : roomrates
// //       }
// //     })
  
// // }

// window.onload = (function(){
//   if(document.getElementById("roomrates")!=null){
//     var fnBind = function(ele){
//         ele.addEventListener('keypress',(e)=>{fnTotal(ele);})
//         ele.addEventListener('keydown',(e)=>{fnTotal(ele);})
//         ele.addEventListener('keyup',()=>{fnTotal(ele);})
//     }
//     var fnTotal= function(ele){
//         var format = new curFormatter(); 
//         let breakfast = ele.parentNode.parentNode.getElementsByClassName('breakfast-price')[0];
//         let room = ele.parentNode.parentNode.getElementsByClassName('room-only')[0];
//         let rate = ele.parentNode.parentNode.getElementsByClassName('room-price')[0];
//         // console.log(room.value);
//         // console.log(breakfast.value);
//         rate.value = format.unformat(room.value*1) + format.unformat(breakfast.value*1);
//         // /console.log(rate.value);
//     }

//     var breakfast = Array.from(document.querySelectorAll('.breakfast-price'));
//     breakfast.map(function(ele){
//         fnBind(ele);
//     });
//     var room = Array.from(document.querySelectorAll('.room-only'));
//     room.map(function(ele){
//         fnBind(ele);
//     });
//   }
// });