if (document.getElementById('neraca-app') != null) {

    window.onload = (function(){
        // alert();

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
            document.getElementsByClassName("total")[0].innerHTML = '<h2 class="text-'+(total>=0?'success':'danger')+'">'+numeral(total).format('0,0')+'</h2>';
            document.getElementsByClassName("total")[1].innerHTML = document.getElementsByClassName("total")[0].innerHTML;
        }

        var inputs = document.querySelectorAll('[name="debet[]"], [name="kredit[]"]');
        calTotal(inputs);
        [].forEach.call(inputs,function(input){
            input.addEventListener('keyup',function(e){
                calTotal(inputs);
            });
        });

        document.getElementsByTagName('form')[0].addEventListener('submit',function(e){
            var inputs = document.querySelectorAll('[name="debet[]"], [name="kredit[]"]');
            [].forEach.call(inputs,function(input){
                var n = input.value.split('.');
                n = n.join('');
                input.value = n;
            });
        });

    });

}