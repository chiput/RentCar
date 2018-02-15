<?php 
$i = 0;
foreach ($reskasirku as $reskasir){ 
    ?>
    <tr>
        <td><a href="javascript:void(0)" data-toggle="tooltip" onclick="del(this)" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i></a></td>
        <td>
            
            <input type="hidden" class="form-control" value="<?= $reskasir->id?>" name="iddetail[]" id="iddetail_<?= $i; ?>">
            <?php if (is_numeric($reskasir->menuid)){ ?>
                <input onkeyup="hartot(<?= $i;?>);GetTotalMenu();" onclick="hartot(<?= $i;?>);GetTotalMenu();" class="form-control" type="number" name="qty[]" id="qty_<?= $i; ?>" value="<?= $reskasir->kuantitas?>" style="width:80px;">
            <?php } else { ?>
                <input onkeyup="tambahharga(<?= $i;?>);GetTotalMenu();" onclick="tambahharga(<?= $i;?>);GetTotalMenu();" class="form-control" type="number" name="qty[]" id="qty_<?= $i; ?>" value="<?= $reskasir->kuantitas?>" style="width:80px;">
            <?php } ?>
        </td>
        <?php if (is_numeric($reskasir->menuid)){ ?>
        <td colspan="2"><?= $reskasir->menu->nama?></td>  
        <td><?= $this->convert($reskasir->menu->hargajual)?><input id="harga_<?= $i; ?>" class="hidden" value="<?= $reskasir->menu->hargajual?>" name="harga[]"></td>
        <?php } else { ?>
        <td colspan="2"><?= $reskasir->menuid?></td>
        <td>
        <input id='tmbharga_<?= $i; ?>' value="<?php echo $this->convert($reskasir->harga/$reskasir->kuantitas)?>" onkeyup='tambahharga(<?= $i; ?>);GetTotalMenu();' onclick='tambahharga(<?= $i; ?>);GetTotalMenu();' class='form-control' type='text' style='width:100%;'/></td>
        <?php } ?>
        <td>
            <input class="hidden" id="ids_<?= $i; ?>" value="<?= $reskasir->menuid;?>" name="ids[]">
            <input class="form-control" id="total_<?= $i; ?>" value="<?= $this->convert($reskasir->harga)?>" name="hargatot[]" readonly="">
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
        var tot;
        var disc;
        for (x = 0; x < rowCount; x++) { 
            tot = $('#total_'+x).val();
            finaltotal=finaltotal+CekNanNParseInt(format.unformat(tot));
        }
        
        $('#totalharga').val(format.format(finaltotal));
        disc = $('#diskon').val();
        diskon=CekNanNParseInt(format.unformat(disc));
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


        diskonpersen = format.unformat(diskon) / format.unformat(finaltotal) * 100;
        totalnya = format.unformat(total) - format.unformat(diskon);
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
    });
    function tambahharga(id){
        var format = new curFormatter();
        kts=CekNanNParseInt($('#qty_'+id).val());
        tot=CekNanNParseInt(format.unformat($('#tmbharga_'+id).val()));
        total=format.format(kts*format.unformat(tot));
        document.getElementById('total_'+id).value = total;
        $('#tmbharga_'+id).val(format.format(tot));
   }
   function hartot(id){
        // var format = new curFormatter();
        // kts=CekNanNParseInt($('#qty_'+id).val());
        // tot=CekNanNParseInt(format.unformat($('#harga_'+id).val()));
        // total=format.format(kts*format.unformat(tot));
        // console.log(total);
        // document.getElementById('total_'+id).value = total;
        // $('#harga_'+id).val(format.format(tot));
        // // $('#total_'+id).val(total);
        var format = new curFormatter();
        var kts=($('#qty_'+id).val());
        var tot=($('#harga_'+id).val());

        console.log(tot);
        total=format.format(kts*format.unformat(tot));
        document.getElementById('total_'+id).value = total;
        $('#harga_'+id).val(format.format(tot));
      }
</script>