if(document.getElementById("logistic-mutation-app") != null){   
        var genSelect = function(){
            var select = document.createElement("select");
            select.setAttribute('name','brgsatuan_id[]');
            select.setAttribute('class','form-control');
            
            var units = JSON.parse(document.getElementById('listUnits').value);
            units.forEach(function(unit){
                var opt = document.createElement('option'); 
                opt.innerHTML = unit.nama;
                opt.value = unit.id;
                select.appendChild(opt);
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
                            '<input type="hidden" name="brgsatuan_id[]" value="'+this.dataset.unitid+'" />'+
                            this.dataset.unitname+
                        '</td>'+
                        '<td>'+
                            '<input type="number" name="kuantitas[]" value="0" class="form-control" max="'+this.dataset.stock+'" step="0.001"/>'+
                            '<small> Maksimal '+this.dataset.stock+'</small>'+
                        '</td>';
                tr.innerHTML = td;
                tbody.appendChild(tr);
                listenDelete();
            });
        });

}