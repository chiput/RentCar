
if(document.getElementById("kas-form-input") != null){
	var format = new curFormatter();

	var newRow = function(){
		var copy=$("#copy").clone();
		$(copy).removeClass('hidden');
		$(copy).removeAttr('id');
		$("#tabledetail tbody").append(copy);
		numberFormat();
		totaling();
	}

	var deleteRow = function(ele){
		$(ele).parent().parent().remove();
		totaling();
	}

	var calTotal = function(inputs){
		var debet = 0;
		var kredit = 0;
		[].forEach.call(inputs,function(input){
			var n = input.value.split('.');
			n = n.join('');
			if(input.name=="debet[]") debet+=parseFloat(n);
			if(input.name=="kredit[]") kredit+=parseFloat(n); 
			// input.value = numeral(n).format('0,0');
		});
		var total = debet-kredit;
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
			format.input('[name="nominal[]"]');
		});

		function totaling(){
			var total=0;
			$("[name='nominal[]']").each(function(index, el) {
				var n = el.value.split('.');
				n = n.join('');
				total+=parseInt(n*1);
			});
			
			$("[name='subtotal']").val(format.format(total));

		}
		var seltype=function(e){
			var opt=$(e).find('option[value="'+e.value+'"]').get(0);
			var deb=$(e).parent().next().get(0);
			var kre=$(e).parent().next().next().get(0);

			deb.innerHTML='<input type="hidden" name="accdebet_id[]" value="'+opt.dataset.debId+'" />'
				+opt.dataset.debCode+' || '+opt.dataset.debName;

			kre.innerHTML='<input type="hidden" name="acckredit_id[]" value="'+opt.dataset.kreId+'" />'
				+opt.dataset.kreCode+' || '+opt.dataset.kreName;


		};
	window.onload = (function(){
			
		// alert();
		numberFormat();
		totaling();

	});

}