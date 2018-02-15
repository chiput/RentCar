if(document.getElementById("logistic-barcode-app") != null){   
        
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
                            '<input type="text" name="kode[]" value="'+this.dataset.kode+'" class="form-control"/>'+
                        '</td>'+
                        '<td>'+
                            '<input type="hidden" name="nama[]" value="'+this.dataset.nama+'" />'+
                            this.dataset.nama+
                        '</td>';
                tr.innerHTML = td;
                tbody.appendChild(tr);
                listenDelete();
            });
        });

}