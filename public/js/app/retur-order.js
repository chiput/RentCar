if(document.getElementById("retur-order-app") != null) {

	$(".total").change(
    function() {
    	var format = new curFormatter();
      	var sum = 0;
	    $(".total").each(function(){
	        sum += +$(this).val();
	    });

	    $("#total").val(format.format(sum));

    });

	function getReceive(ele) {
		
		var data = JSON.parse(ele.dataset.receiveJson);
		var detail = JSON.parse(ele.dataset.redetailJson);
		var prices = JSON.parse(document.getElementById('listPurchases').value);
		var goods = JSON.parse(document.getElementById('listGoods').value);
		var units = JSON.parse(document.getElementById('listUnits').value);

		var content = '';

		$('[name="terima_id"]').val(data.id);
		$('[name="terima_name"]').val(data.nobukti);

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

		function getPrice(id) {
			var value = 0;
			$.each(prices, function(index, price) {
				if(id == price.barang_id) {
					value = price.harga;
				}
			});

			return value;
		}

		if (document.getElementById('listReturs').value != '') {
			var returs = JSON.parse(document.getElementById('listReturs').value);

			function getRetur(id) {
				var value = 0;
				$.each(returs, function(index, retur) {
					if(id == retur.barang_id) {
						value = retur.kuantitas;
					}
				});

				return value;
			}

		} else {
			
			function getRetur(id) {
				var value = 0;
				return value;
			}

		}

		

		$.each(detail, function(index, item) {

			   content += '<tr class="item_barang">';
			   content += '<td>'+'<input type="hidden" name="barang_id[]" value="'+item.barang_id+'"/>'+getCodeBarang(item.barang_id)+'</td>';
			   content += '<td>'+getBarang(item.barang_id)+'</td>';
			   content += '<td>'+'<input type="hidden" name="satuan_id[]" value="'+item.satuan_id+'"/>'+getUnit(item.satuan_id)+'</td>';
			   content += '<td>'+item.kuantitas+'</td>';
			   content += '<td>'+getRetur(item.barang_id)+'</td>';
			   content += '<td>'+'<input type="number" name="kuantitas[]" value="0" max="'+item.kuantitas+'"  min="0" step="0.001" class="form-control total" /><input type="hidden" name="harga[]" value="'+getPrice(item.barang_id)+'" class="form-control"/>'+'</td>';
			   content += '</tr>';
		});

		$("#tabledetail").find('tbody').empty().append(content);

	   	$(".total").change(
        function() {
        	var format = new curFormatter();
          	var sum = 0;
		    $(".total").each(function(){
		        sum += +$(this).val();
		    });

		    $("#total").val(format.format(sum));

        });

	}

}