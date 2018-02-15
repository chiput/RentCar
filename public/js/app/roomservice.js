if(document.getElementById("roomservice") != null){
        function getBuilding(id) {
          var idku = id;
          document.getElementById("building").value = idku;
        }

        function getKamar(id) {
          var idku = id;
          document.getElementById("kamar").value = idku;
        }

        function Kamar(id){
          var idku = id;
          $("#"+idku+"").addClass("hidden");
        }

        function hide(ele){
          ele.preventDefault();
        }

        tambah= function(e){
          var ele = "'"+e+"'"
          var doc = document;
          var tbody = doc.querySelector('#tabledetail tbody');
          var tr = doc.createElement("tr");
          var td = '<td>' +
            '<a href="#" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>' +
            '</td>' +
            '<td>' +
            '<input type="hidden" value="" />' +
            e+
            '</td>' +
            '<td>' +
            genSelect1() +
            '</td>' +
            '<td>' +
            '<input type="hidden" name="tipekamar[]" class="form-control" value="" />' +
            '</td>' +
            '<td>' +
            '<a href="#" data-toggle="tooltip" data-original-title="Tambah"> <i class="fa fa-plus" onclick="hide(event); tambah('+ele+');" ></i> </a>' +
            '</td>';
          tr.innerHTML = td;
          tbody.appendChild(tr);
          listenDelete();
        }
        tambah1= function(e){
          var ele = "'"+e+"'"
          var doc = document;
          var tbody = doc.querySelector('#tabledetail1 tbody');
          var tr = doc.createElement("tr");
          var td = '<td>' +
            '<a href="#" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>' +
            '</td>' +
            '<td>' +
            '<input type="hidden" value="" />' +
            e+
            '</td>' +
            '<td>' +
            genSelect() +
            '</td>' +
            '<td>' +
            '<input type="text" name="kuantitas[]" style="width:100px;" class="form-control" value="" />' +
            '</td>' +
            '<td>' +
            '<a href="#" data-toggle="tooltip" data-original-title="Tambah"> <i class="fa fa-plus" onclick="hide(event); tambah1('+ele+');" ></i> </a>' +
            '</td>';
          tr.innerHTML = td;
          tbody.appendChild(tr);
          listenDelete();
        }

        window.seltype=function(e){
        	var opt=$(e).find('option[value="'+e.value+'"]').get(0);
        	var deb=$(e).parent().next().get(0);

        	deb.innerHTML='<input type="hidden" name="tipekamar[]" value="'+opt.dataset.debCode+'" />'
        		+opt.dataset.debCode;
        };

        var genSelect = function(){
            var select = document.createElement("select");
            select.setAttribute('name','kamar_id1[]');
            select.setAttribute('class','form-control');

            var units = JSON.parse(document.getElementById('listUnits').value);
            var optkosong = document.createElement('option');
            select.appendChild(optkosong);
            units.forEach(function(room){
                var test = $('#building').val();
                if(room.buildings_id==test){
                  var opt = document.createElement('option');
                  opt.innerHTML = room.number;
                  opt.value = room.id;
                  select.appendChild(opt);
                }
            });
            return select.outerHTML;
        };
        var tipekamar;
        var genSelect1 = function(){
            var select = document.createElement("select");
            select.setAttribute('name','kamar_id[]');
            select.setAttribute('class','form-control');
            select.setAttribute('onchange', 'window.seltype(this)');

            var units = JSON.parse(document.getElementById('listUnits').value);
            var optkosong = document.createElement('option');
            select.appendChild(optkosong);
            units.forEach(function(room){
                var test = $('#kamar').val();
                if(room.buildings_id==test){
                  var opt = document.createElement('option');
                  opt.value = room.id;
                  opt.setAttribute('data-deb-code', room.tipekamar);
                  opt.innerHTML = room.number;
                  select.appendChild(opt);
                }
            });
            return select.outerHTML;
        };



        var listenDelete = function(){
            var deletes = document.querySelectorAll('.fa-close.text-danger');
            [].forEach.call(deletes, function(del) {
                del.parentElement.removeEventListener('click',function(e){});
                del.removeEventListener('click',function(e){});
                del.parentElement.addEventListener("click",function(e){
                  var data1 = this.dataset.gedung;
                  console.log(data1);
                    e.preventDefault();
                    this.parentElement.parentElement.remove();
                    $("#"+data1+"").removeClass("hidden");
                    return false;
                });
            });
        }
        listenDelete();

        document.querySelectorAll('#barangModal table a').forEach(function(ele){
            ele.addEventListener("click",function(e){
                e.preventDefault();
                var nama;
                var doc = document;
                var tbody = doc.querySelector('#tabledetail1 tbody');
                var tr = doc.createElement("tr");
                nama = "'"+this.dataset.name+"'";
                var td='<td>'+
                            '<a data-gedung="'+this.dataset.id+'" href="#" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>'+
                        '</td>'+
                        '<td>'+
                          '<input type="hidden" class="form-control" style="width:100px;" />'+
                          this.dataset.name+
                        '</td>'+
                        '<td>'+
                          '<input type="hidden" name="kamar_id[]" class="form-control" value="'+this.dataset.id+'" style="width:100px;" />'+
                          this.dataset.kamar+
                        '</td>'+
                        '<td>'+
                          '<input type="hidden" class="form-control" style="width:100px;" value="" />'+
                          this.dataset.tipe+
                        '</td>';
                tr.innerHTML = td;
                tbody.appendChild(tr);
                listenDelete();
            });
        });

}
