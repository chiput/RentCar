if (document.getElementById('costListBuild') != null) {

    var app = new Vue({
        el: '#costListBuild',
        data: {
            tes: '',
            reservations: [],
            guest: [],
            addcharges: [],
        }
    });

       
        var btns = document.getElementsByClassName("btnDetail");
        [].forEach.call(btns, function(ele) {
            
            ele.addEventListener('click', function(btn) {

                app.reservations = [];
                app.guest = [];
                app.addcharges = [];


                var progress = document.querySelectorAll('#costListBuild .progress');
                Array.prototype.map.call(progress, function(ele) {
                    ele.style.display = 'block';
                });


                var guestId = this.dataset.id;
                $('#costListBuild').modal();
                $.ajax({
                        url: document.getElementById("urlajax").value + guestId,
                        dataType: 'json',
                    })
                    .done(function(data) {
                        // console.log(data);
                        app.reservations = data.reservations.map(function(ele) {
                            ele.tanggal = ele.tanggal.substring(0, 10);
                            ele.checkin = ele.checkin.substring(0, 10);
                            ele.checkout = ele.checkout.substring(0, 10);
                            return ele;
                        });
                        app.guest = data.guest;
                        app.guest.sex = (app.guest.sex == 1 ? "Pria" : "Wanita");
                        app.addcharges = data.addcharges.map(function(ele) {
                            ele.ntotal = numeral(ele.ntotal).format('0,0');
                            return ele;
                        });
                    })
                    .fail(function() {
                        // console.log("error");
                    })
                    .always(function() {
                        // console.log("complete");
                        var progress = document.querySelectorAll('#costListBuild .progress');
                        Array.prototype.map.call(progress, function(ele) {
                            ele.style.display = 'none';
                        });
                    });

            });
        });
        //alert();


}