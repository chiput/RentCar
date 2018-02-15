if(document.getElementById("gudangForm")!=null){
function ajaxgudang_get_name(id,link) {
       // alert(id);
        $.ajax({
            type: "POST",
            url: link,
            data: "id=" + id+'&pram='+'code'+'&get='+'name',
            async: false,
            success: function (data) {
                console.log(data);
               $('#departemen').val(data);
        },error:function(data){
            console.log(data);
        }
        });
        }


function ajaxgudang_get_id(id,link) {
       // alert(id);
        $.ajax({
            type: "POST",
            url: link,
            data: "id=" + id+'&pram='+'code'+'&get='+'id',
            async: false,
            success: function (data) {
                console.log(data);
               $('#id_dapertemen').val(data);
        },error:function(data){
            console.log(data);
        }
        });
        }

}

