if(document.getElementById("purchase-app") != null) {

	if(document.getElementById("diskon") == null) {
		$("#diskon").val(0);
	}

	if(document.getElementById("ppn") == null) {
		$("#ppn").val(0);
	}

	if(document.getElementById("ongkos_kirim") == null) {
		$("#ongkos_kirim").val(0);
	}

	if(document.getElementById("tempo") == null) {
		$("#tempo").val(0);
	}

	if(document.getElementById("duedate") == null) {
		$("#duedate").val(getNowDate(0));
	}
    
	$('#tunai').change(function() {
	    $('#tempo').attr('disabled', this.checked);
	    $('#duedate').attr('disabled', this.checked);
	});

	function getNowDate(val) {
		var today = new Date(); 
			today.setDate(today.getDate() + parseInt(val));
		var dd = today.getDate(); 
		var mm = today.getMonth()+1;//January is 0! 
		var yyyy = today.getFullYear(); 
		if(dd<10){dd='0'+dd} 
		if(mm<10){mm='0'+mm} 	
		now =  dd+'-'+mm+'-'+yyyy;
		return now;
	}

	function getNowDue(date_format) {
		var due = new Date(date_format);
		var today = new Date();

		var seconds = Math.floor((due - (today))/1000);
		var minutes = Math.floor(seconds/60);
		var hours = Math.floor(minutes/60);
		var days = Math.floor(hours/24);

		return days+1;
	}


	$(document).ready(function() {	  

		    $('#tempo').change(function() {
				tempo = getNowDate($('#tempo').val());
			    $("#duedate").val(tempo);
			});

			$('#duedate').change(function() {
				now_due = getNowDue($('#duedate').val());
			    $("#tempo").val(now_due);
			});

			if (document.getElementById("tunai").checked) {
				document.getElementById('tempo').disabled = true;
				document.getElementById('duedate').disabled = true;
			}

			if ($('.sub').length > 0) {
				  //do something
				  $(".sub").change(
			        function() {
			        	var format = new curFormatter();
			        	format.input("[name ='harga[]']");

			      		var parent=$(this).closest('.item_barang');
			        	parent.find(".total").val();
			          	var qty = parent.find(".qty").val();
			          	var price = format.unformat(parent.find(".price").val());
			          	var total = (qty * price);
			          	    total = Math.round(total);
			          	parent.find(".total").val(format.format(total));

			          	var sum = 0;
					    $(".total").each(function(){
					        sum += +(format.unformat($(this).val()));
					        // 
					    });

					    sum = format.format(sum);

					    var total_harga = 0;
					    var total_ppn = 0;
					    var ppn = 0;
					    var ongkir = 0;

					    $("#total").val(sum);

					    $("#subtotal").val(sum);
					    $("#total_harga").val(sum);


					    function calculate_purchase() {
					    	total_harga = format.unformat(sum) - parseInt(format.unformat($("#diskon").val()));
					    	total_harga = format.format(total_harga);
					    	$("#subtotal").val(total_harga);
					    	$("#total_harga").val(total_harga);
					    	$("#ppn_hasil").val(0);

					    	ppn = parseInt(format.unformat($("#subtotal").val())) * (parseInt($("#ppn").val()) / 100);
				    		$("#ppn_hasil").val(format.format(ppn));
				    		total_ppn = parseInt(format.unformat($("#subtotal").val())) + parseInt(format.unformat($("#ppn_hasil").val()));
				    		$("#total_harga").val(format.format(total_ppn));

				    		ongkir = total_ppn + parseInt(format.unformat($("#ongkos_kirim").val()));	
				    		$("#total_harga").val(format.format(ongkir));
					    }

					    calculate_purchase();

					    $("#diskon").change(function() {
					    	calculate_purchase();
					    });

				    	$("#ppn").change(function() {
				    		calculate_purchase();
				    	});

				    	$("#ongkos_kirim").change(function() {
				    		calculate_purchase();
				    	});
					    	
			        });
				}
	});

	function getSupplier(ele) {
		
		var data = JSON.parse(ele.dataset.supplierJson);

		$('[name="supplier_id"]').val(data.id);
		$('[name="supplier_name"]').val(data.nama);
	}

	function getPurchase(ele) {
		
		var data = JSON.parse(ele.dataset.purchaseJson);
		var department = JSON.parse(ele.dataset.departmentJson);
		var detail = JSON.parse(ele.dataset.podetailJson);
		var goods = JSON.parse(document.getElementById('listGoods').value);
		var units = JSON.parse(document.getElementById('listUnits').value);
		var orderdetails = JSON.parse(document.getElementById('listOrderDetails').value);
		var terimadetails = JSON.parse(document.getElementById('listTerimaDetails').value);

		var content = '';

		$('[name="permintaan_id"]').val(data.id);
		$('[name="permintaan_name"]').val(data.nobukti);
		$('[name="department_id"]').val(department.id);
		$('[name="department_name"]').val(department.name);

		function getBarang(id) {
			var value = '';
			$.each(goods, function(index, good) {
				if(id == good.id) {
					value = good.nama;
				}
			});

			return value;
		}

		function getCodeBarang(id) {
			var value = '';
			$.each(goods, function(index, good) {
				if(id == good.id) {
					value = good.kode;
				}
			});

			return value;
		}

		function getUnit(id) {
			var value = '';
			$.each(units, function(index, unit) {
				if(id == unit.id) {
					value = unit.nama;
				}
			});

			return value;
		}

		function getOrder(id,minta) {
			var value = 0;
			$.each(orderdetails, function(index, orderdetail) {
				if(id == orderdetail.barang_id && minta == orderdetail.permintaan_id) {
					value += +orderdetail.kuantitas;
				}
			});

			return value;
		}

		function getTerima(id,minta) {
			var value = 0;
			$.each(terimadetails, function(index, terimadetail) {
				if(id == terimadetail.barang_id && minta == terimadetail.permintaan_id) {
					value += +terimadetail.kuantitas;
				}
			});

			return value;
		}

		$.each(detail, function(index, item) {

			   content += '<tr class="item_barang">';
			   content += '<td>'+'<input type="hidden" name="barang_id[]" value="'+item.barang_id+'"/>'+getCodeBarang(item.barang_id)+'</td>';
			   content += '<td>'+getBarang(item.barang_id)+'</td>';
			   content += '<td>'+'<input type="hidden" name="satuan_id[]" value="'+item.satuan_id+'"/>'+getUnit(item.satuan_id)+'</td>';
			   content += '<td>'+item.kuantitas+'</td>';
			   content += '<td>'+getOrder(item.barang_id,item.gudminta_id)+'</td>';
			   content += '<td>'+getTerima(item.barang_id,item.gudminta_id)+'</td>';
			   content += '<td>'+'<input type="number" name="kuantitas[]" value="" class="form-control qty sub"/>'+'</td>';
			   content += '<td>'+'<input type="text" name="harga[]" value="" class="form-control price sub"/>'+'</td>';
			   content += '<td>'+'<input type="text" class="total form-control" disabled="disabled">'+'</td>';
			   content += '</tr>';
		});

		$("#tablePurchase").find('tbody').empty().append(content);

		var format = new curFormatter();
        	format.input("[name ='harga[]']");

	   	$(".sub").change(
        function() {
        	var format = new curFormatter();
        	// format.input("[name ='harga[]']");

      		var parent=$(this).closest('.item_barang');
        	parent.find(".total").val();
          	var qty = parent.find('.qty').val();
          	var price = format.unformat(parent.find('.price').val());
          	var total = (qty * price);
          	    total = Math.round(total);
          	parent.find(".total").val(format.format(total));

          	var sum = 0;
		    $(".total").each(function(){
		        sum += +(format.unformat($(this).val()));
		        // sum = format.unformat(sum);
		    });

		    sum = format.format(sum);
		    var total_harga = 0;
		    var total_ppn = 0;
		    var ppn = 0;
		    var ongkir = 0;

		    $("#total").val(sum);

		    $("#subtotal").val(sum);
		    $("#total_harga").val(sum);

		    function calculate_purchase() {
		    	total_harga = format.unformat(sum) - parseInt(format.unformat($("#diskon").val()));
		    	total_harga = format.format(total_harga);
		    	$("#subtotal").val(total_harga);
		    	$("#total_harga").val(total_harga);
		    	$("#ppn_hasil").val(0);

		    	ppn = parseInt(format.unformat($("#subtotal").val())) * (parseInt($("#ppn").val()) / 100);
	    		$("#ppn_hasil").val(format.format(ppn));
	    		total_ppn = parseInt(format.unformat($("#subtotal").val())) + parseInt(format.unformat($("#ppn_hasil").val()));
	    		$("#total_harga").val(format.format(total_ppn));

	    		ongkir = total_ppn + parseInt(format.unformat($("#ongkos_kirim").val()));	
	    		$("#total_harga").val(format.format(ongkir));
		    }


		    $("#diskon").change(function() {
		    	calculate_purchase();
		    });

	    	$("#ppn").change(function() {
	    		calculate_purchase();
	    	});

	    	$("#ongkos_kirim").change(function() {
	    		calculate_purchase();
	    	});
		    	
        });

	}

}