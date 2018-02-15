var curFormatter = function(){

    this.format = function(val){
        var conversion = numeral(val).format('0,0');
        return conversion;
    };

    this.unformat = function(val){
        var reverse = numeral().unformat(val);
        return reverse;

    };

    this.input = function(ele){

        var parent = this;

        if(typeof ele == "object")
        {
            
            ele.value = parent.format(ele.value);
            ele.addEventListener('keyup',function(){
                var plain = parent.unformat(ele.value);
                ele.value = parent.format(plain);
            });
        }
        if(typeof ele == "string")
        {
            var inputs = document.querySelectorAll(ele);
            [].forEach.call(inputs,function(input){
				parent.input(input);
            });    
        }
        

        
    };

}