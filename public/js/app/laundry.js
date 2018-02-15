if(document.getElementById("laundry")!=null){
  function getGuest(ele){
      var data=JSON.parse(ele.dataset.guestJson);
      $('[name="checkinid"]').val(data.checkin_code);
  }
  function getSupplier(ele){
      var data=JSON.parse(ele.dataset.supplierJson);
      $('[name="supplier"]').val(data.nama);
      $('[name="supplierid"]').val(data.id);
  }
  function myFunction(id) {
    var idku = id;
    document.getElementById("kamar").value = idku;
  }
    var listenDelete = function(){
        var deletes = document.querySelectorAll('.fa-close.text-danger');
        [].forEach.call(deletes, function(del) {
            del.parentElement.removeEventListener('click',function(e){});
            del.removeEventListener('click',function(e){});
            del.parentElement.addEventListener("click",function(e){
                e.preventDefault();
                this.parentElement.parentElement.remove();
                totaling();
                totalk();
                return false;
            });
        });
    }

    listenDelete();

    document.querySelectorAll('#tarifModal table a').forEach(function(ele){
        ele.addEventListener("click",function(e){
            e.preventDefault();
            var doc = document;
            var tbody = doc.querySelector('#tabledetail tbody');
            var tr = doc.createElement("tr");
            var i=$('#tabledetail tr').length-2;;
            var td='<td>'+
                        '<a href="#" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>'+
                    '</td>'+
                    '<td>'+
                        '<input type="hidden" name="kode[]" class="form-control" value="">'+
                        this.dataset.kode+
                    '</td>'+
                    '<td>'+
                        '<input type="text" name="nama[]" class="form-control" value="'+this.dataset.nama+'" readonly />'+
                    '</td>'+
                    '<td>'+
                        '<input type="text" name="layanan[]" class="form-control" value="'+this.dataset.layanan+'" readonly>'+
                        '<input type="hidden" name="tarifid[]" class="form-control" value="'+this.dataset.id+'">'+
                    '</td>'+
                    '<td>'+
                        '<input type="text" name="keterangandetail[]" class="form-control" value="'+this.dataset.keterangan+'">'+
                    '</td>'+
                    '<td>'+
                        '<input type="text" name="kuantitas[]" class="form-control" id="kuantitas_'+i+'" value="" onkeyup="totalk(this); kali(this.value,this.id); totaling(this);">'+
                    '</td>'+
                    '<td>'+
                        '<input type="text" name="harga[]" class="form-control" id="harga_'+i+'" value="'+this.dataset.harga+'" value="" onkeyup="kali(this.value,this.id); totaling(this);">'+
                    '</td>'+
                    '<td>'+
                        '<input type="text" name="diskon[]" id="diskon_'+i+'" class="form-control" value="0" onkeyup="kali(this.value,this.id); totaling(this);">'+
                    '</td>'+
                    '<td>'+
                        '<input type="text" name="jumlah[]" id="jumlah_'+i+'" class="form-control" value="">'+
                    '</td>';
            tr.innerHTML = td;
            tbody.appendChild(tr);
            listenDelete();
        });
    });
    function bayar1(){
      var bayar1, kembalian;
      bayar1=$("[name='bayar']").val()
      kembalian=bayar1-$("[name='totalkasir']").val();
      $("[name='kembalian']").val(kembalian);
    }
    function totalankasir(id){
        var diskonpersen, service, jumlahdiskon, totalan;
        diskonpersen=$('#diskonpersen').val()/100;
        service=$('#service').val()/100;
        jumlahdiskon=$('#totals').val()*(diskonpersen-service);
        totalan=$('#totals').val()-jumlahdiskon;
        $("[name='totalkasir']").val(totalan);
        bayar1();
    }
    function kali(value,id){
      id=id.split('_');
      var total,hargabeli,diskon;
      if(id[0]=='kuantitas'){
        var harga,kuantitas;
        diskon=$('#diskon_'+id[1]).val();
        harga=$('#harga_'+id[1]).val();
        kuantitas=$('#kuantitas_'+id[1]).val();
        total=kuantitas*(harga-diskon);
      }else if(id[0]=='harga'){
        var harga,kuantitas;
        diskon=$('#diskon_'+id[1]).val();
        harga=$('#harga_'+id[1]).val();
        kuantitas=$('#kuantitas_'+id[1]).val();
        total=kuantitas*(harga-diskon);
      }else{
        var harga,kuantitas;
        diskon=$('#diskon_'+id[1]).val();
        harga=$('#harga_'+id[1]).val();
        kuantitas=$('#kuantitas_'+id[1]).val();
        total=kuantitas*(harga-diskon);
      }
      $('#jumlah_'+id[1]).val(total);
    }
    function totalk(){
      var jumlah=0;
      $("[name='kuantitas[]']").each(function(index, el) {
        jumlah+=parseInt(el.value*1);
      });
      $("[name='totalkuantitas']").val(jumlah);
    }
    function totaling(){
    	var grandtotal=0;
    	$("[name='jumlah[]']").each(function(index, el) {
    		grandtotal+=parseInt(el.value*1);
    	});
    	$("[name='total']").val(grandtotal);
      $("[name='totalkasir']").val(grandtotal);
    }
}
