<?php 
$i = 0;
foreach ($storekasir as $kasirdetail){ 
    ?>
    <tr>
        <td><a href="javascript:void(0)" data-toggle="tooltip" onclick="del(this)" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i></a></td>
        <td>
            
            <input type="hidden" class="form-control" value="<?= $kasirdetail->id?>" name="iddetail[]" id="iddetail_<?= $i; ?>">
            <input onkeyup="hartot(<?= $i;?>);GetTotalMenu();" onclick="hartot(<?= $i;?>);GetTotalMenu();" class="form-control" type="number" name="qty[]" id="qty_<?= $i; ?>" value="<?= $kasirdetail->kuantitas?>" style="width:80px;">
        </td>
        
        <td colspan="2"><?= $kasirdetail->barang->nama;?></td>
        <td>
        <?= $kasirdetail->harga;?>
        </td>
        <td>
            <input id="harga_<?= $i; ?>" class="hidden" value="<?= $kasirdetail->barang->hargastok?>" name="harga[]">
            <input class="hidden" id="ids_<?= $i; ?>" value="<?= $kasirdetail->barang_id;?>" name="ids[]">
            <input class="form-control" id="total_<?= $i; ?>" value="<?= $kasirdetail->harga?>" name="hargatot[]" readonly="">
            <input type="hidden" class="form-control" value="0" name="id[]" id="id_<?= $i; ?>">
        </td>
    </tr>
<?php $i++;} ?>
<script type="text/javascript">
    $("document").ready(function(){
        var format = new curFormatter();
        
        var rowCount = $('#tblmenu tr').length-2;
        $('#jumrow').val(rowCount);

        var finaltotal=0;
        for (x = 0; x < rowCount; x++) { 
            //alert($('#total_'+x).val());
            finaltotal=finaltotal+CekNanNParseInt($('#total_'+x).val());
        }
         
        $('#totalharga').val(finaltotal);
        diskon=CekNanNParseInt($('#diskon').val());
        total = finaltotal;
        var number_string = total.toString(),
            sisa    = number_string.length % 3,
            rupiah  = number_string.substr(0, sisa),
            ribuan  = number_string.substr(sisa).match(/\d{3}/g);
                
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        $('#totalharganya').val(finaltotal);
        document.getElementById("totalharga").innerHTML='Rp. '+rupiah;

        if(diskon > 0 ){
            diskonpersen = diskon / finaltotal * 100;
            totalnya = total - diskon;
            var number_string = totalnya.toString(),
                sisa    = number_string.length % 3,
                rupiah  = number_string.substr(0, sisa),
                ribuan  = number_string.substr(sisa).match(/\d{3}/g);
                    
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            document.getElementById('totaldiskon').value = rupiah;
            document.getElementById('diskon').value = diskonpersen;
        }
    });
    function tambahharga(id){
        kts=CekNanNParseInt($('#qty_'+id).val());
        tot=CekNanNParseInt($('#tmbharga_'+id).val());
        total=kts*tot;
        document.getElementById('total_'+id).value = total;
   }
   function hartot(id){
        kts=CekNanNParseInt($('#qty_'+id).val());
        tot=CekNanNParseInt($('#harga_'+id).val());
        total=kts*tot;
        console.log(total);
        document.getElementById('total_'+id).value = total;
        // $('#total_'+id).val(total);
      }
</script>