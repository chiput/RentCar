if(document.getElementById("accounting-jurnal") != null){

    window.onload = (function(){

        var calTotal = function(inputs){
            var debet = 0;
            var kredit = 0;
            [].forEach.call(inputs,function(input){
                var n = input.value.split('.');
                n = n.join('');
                if(input.name=="debet[]") debet+=parseFloat(n);
                if(input.name=="kredit[]") kredit+=parseFloat(n); 
                input.value = numeral(n).format('0,0');
            });
            var total = debet-kredit;
            // document.getElementsByClassName("total")[0].innerHTML = '<h2 class="text-'+(total>=0?'success':'danger')+'">'+numeral(total).format('0,0')+'</h2>';
            // document.getElementsByClassName("total")[1].innerHTML = document.getElementsByClassName("total")[0].innerHTML;
        }

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

        var numberFormat = (function(){
            var inputs = document.querySelectorAll('[name="debet[]"], [name="kredit[]"]');
            calTotal(inputs);
            [].forEach.call(inputs,function(input){
                input.addEventListener('keyup',function(e){
                    calTotal(inputs);
                });
            });
        });

        numberFormat();
        listenDelete();
        
        document.querySelectorAll('#accounts-modal table a').forEach(function(ele){
            ele.addEventListener("click",function(e){
                e.preventDefault();
                var doc = document;
                if(doc.querySelector('[name="account_id[]"][value="'+this.dataset.id+'"]') != null){
                    return false;
                }
                var tbody = doc.querySelector('#table-account tbody');
                var tr = doc.createElement("tr");
                var td='<td>'+
                            '<a href="#" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>'+
                        '</td>'+
                        '<td>'+
                            '<input type="hidden" name="account_id[]" value="'+this.dataset.id+'" />'+
                            this.dataset.code+
                        '</td>'+
                        '<td>'+
                            this.dataset.name+
                        '</td>'+
                        '<td>'+
                            '<input type="text" name="debet[]" value="0" class="form-control"/>'+
                        '</td>'+
                        '<td>'+
                            '<input type="text" name="kredit[]" value="0" class="form-control"/>'+
                        '</td>';
                tr.innerHTML = td;
                tbody.appendChild(tr);
                // console.log(tr);
                numberFormat();
                listenDelete();
            });
        });
    });

}