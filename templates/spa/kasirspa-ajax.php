<?php 
$i = 0;
foreach ($spakasir as $spakasir){ ?>
    <tr>
        <td><a href="javascript:void(0)" data-toggle="tooltip" onclick="del(this)" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i></a></td>
        <!-- <td> -->
            <input type="hidden" class="form-control" value="<?= $spakasir->id?>" name="iddetail[]" id="iddetail_<?= $i; ?>">
            <?php if (is_numeric($spakasir->layananid)){ ?>
                <input onkeyup="totalharg(<?= $i;?>);GetTotalLayanan();" onclick="totalharg(<?= $i;?>);GetTotalLayanan();" class="form-control hidden" type="number" name="qty[]" id="qty_<?= $i; ?>" value="<?= $spakasir->kuantitas?>" style="width:80px;">
            <?php } else { ?>
                <input onkeyup="tambahharga(<?= $i;?>);GetTotalLayanan();" onclick="tambahharga(<?= $i;?>);GetTotalLayanan();" class="form-control hidden" type="number" name="qty[]" id="qty_<?= $i; ?>" value="<?= $spakasir->kuantitas?>" style="width:80px;">
            <?php } ?>
        <!-- </td> -->
        <?php if (is_numeric($spakasir->layananid)){ ?>
        <td colspan="3"><?= $spakasir->layanan->nama_layanan?></td>
        <td colspan="2"><?= $spakasir->terapis->nama?></td>
        <td><?= $this->convert($spakasir->layanan->hargajual)?></td>
        <td><?= $spakasir->layanan->diskon?>%</td>
        <?php } else { ?>
        <td colspan="2"><?= $spakasir->layananid?></td>
        <td>
        <input id='tmbharga_<?= $i; ?>' value="<?php echo $spakasir->harga?>" name='hargatot[]' onkeyup='tambahharga(<?= $i; ?>);GetTotalLayanan();' onclick='tambahharga(<?= $i; ?>);GetTotalLayanan();' class='form-control' type='text' style='width:100%;'/></td>
        <?php } ?>
        <td>
            <input id="harga_<?= $i; ?>" class="hidden" value="<?= $spakasir->layanan->hargajual?>" name="harga[]">
            <input class="hidden" id="ids_<?= $i; ?>" value="<?= $spakasir->layananid;?>" name="ids[]">
            <input class="hidden" id="terapis_<?= $i; ?>" value="<?= $spakasir->terapisid;?>" name="terapis[]">
            <?php if (is_numeric($spakasir->layananid)){ ?>
            <input class="form-control" id="total_<?= $i; ?>" value="<?= $this->convert($spakasir->harga)?>" name="hargatot[]" readonly="">
            <?php } else { ?>
            <input class="form-control" id="total_<?= $i; ?>" value="<?php echo $this->convert($spakasir->harga*$spakasir->kuantitas)?>" name="hargatot[]" readonly="">
            <?php } ?>
            <input type="hidden" class="form-control" value="0" name="id[]" id="id_<?= $i; ?>">
        </td>
    </tr>
<?php $i++;} ?>
<script type="text/javascript">
    $("document").ready(function(){
        var format = new curFormatter();

        var rowCount = $('#tbllayanan tr').length-2;
        $('#jumrow').val(rowCount);

        var finaltotal=0;
        var tot;
        for (x = 0; x < rowCount; x++) { 
            tot = $('#total_'+x).val();
            finaltotal=finaltotal+CekNanNParseInt(format.unformat(tot));
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

        diskonpersen = diskon / format.unformat(finaltotal) * 100;
        totalnya = format.unformat(total) - diskon;
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

        kts=CekNanNParseInt($('#qty_'+id).val('1'));
        tot=CekNanNParseInt(format.unformat($('#tmbharga_'+id).val()));
        total=format.format(kts*format.unformat(tot));
        document.getElementById('total_'+id).value = total;
    }
    function totalharg(id){
        var format = new curFormatter();

        kts=CekNanNParseInt($('#qty_'+id).val('1'));
        tot=CekNanNParseInt(format.unformat($('#harga_'+id).val()));
        total=format.format(kts*format.unformat(tot));
        console.log(total);
        document.getElementById('total_'+id).value = total;
        // $('#total_'+id).val(total);
    }
</script>