if(document.getElementById("currency-app")!=null){
  

  var currencyVue=new Vue({
    el: '#currency-app',
    data: {
      currencies: window.currencies,
      edit:[]
    },
    methods:{
      addItem:function(){
        this.edit={};
      },
      editItem:function(e){
        //console.log(e.target.dataset.index);
        this.edit=this.currencies[e.target.dataset.index];
        console.log(this.edit);
      }
    }    
  });

  
}