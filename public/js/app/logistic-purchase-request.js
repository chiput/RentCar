if(document.getElementById("logistic-purchase-request-app") != null){   
        function genSelect(satuan_id){
            var select = document.createElement("select");
            select.setAttribute('name','satuan_id[]');
            select.setAttribute('class','form-control');
            
            var units = JSON.parse(document.getElementById('listUnits').value);
            units.forEach(function(unit){
                if(satuan_id == unit.id){
                    var opt = document.createElement('option'); 
                    opt.innerHTML = unit.nama;
                    opt.value = unit.id;

                    if(unit.id == satuan_id){
                        opt.setAttribute('selected', 'selected');
                    }
                    
                    select.appendChild(opt);
                }
            });

            var konversis = JSON.parse(document.getElementById('konversi').value);
            konversis.forEach(function(konversi){

                if(konversi.brgsatuan_id1 == satuan_id){

                    units.forEach(function(unit){
                        if(konversi.brgsatuan_id2 == unit.id){
                            var opt = document.createElement('option'); 
                            opt.innerHTML = unit.nama;
                            opt.value = unit.id;
                            
                            select.appendChild(opt);
                        }

                    });
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
                    e.preventDefault();
                    this.parentElement.parentElement.remove();
                    return false;
                });
            });
        }

        listenDelete();

        document.querySelectorAll('#goods-modal table a').forEach(function(ele){
            ele.addEventListener("click",function(e){
                e.preventDefault();
                var doc = document;
                if(doc.querySelector('[name="barang_id[]"][value="'+this.dataset.id+'"]') != null){
                    return false;
                }
                var tbody = doc.querySelector('#tabledetail tbody');
                var tr = doc.createElement("tr");
                var td='<td>'+
                            '<a href="#" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>'+
                        '</td>'+
                        '<td>'+
                            '<input type="hidden" name="barang_id[]" value="'+this.dataset.id+'" />'+
                            this.innerHTML+
                        '</td>'+
                        '<td>'+
                            genSelect(this.dataset.satuan)+
                        '</td>'+
                        '<td>'+
                            '<input type="number" name="kuantitas[]" value="0" class="form-control"/>'+
                        '</td>';
                tr.innerHTML = td;
                tbody.appendChild(tr);
                listenDelete();
            });
        });

}