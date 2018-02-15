<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Harga Mobil',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Setup',
    'submain_location' => 'Harga Mobil'
  ]); 

    $activeStatus = [
        'Tidak Aktif',
        'Aktif'
    ];
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Setup </h3>
            <p class="text-muted m-b-10">Harga Mobil </br></br> No. Mobil &nbsp;&nbsp;&nbsp;: <?=@$room->level?></br> Jenis Mobil : <?=@$room->roomType->name?></p>
            <form method="post" action="<?php echo $this->pathFor('setup-room-rate-save', ['room_id' => $room->id]); ?>" id="roomrates">
                <input type="hidden" name="room_id" value="<?php echo $room->id ?>"/>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Tarif</th>
                            <th>Mobil</th>
                            <th>Bahan Bakar</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($room_rates->count() == 0): ?>
                        <input type="hidden" name="action" value="insert" />
                        <?php foreach ($daynames as $dayname): ?>
                        <tr class="<?=$dayname->dayname?> dayname">
                            <td>
                                <?php echo $dayname->dayname; ?>
                                <input type="hidden" name="dayname_id[]" value="<?php echo $dayname->id ?>"/>
                            </td>
                            <td>
                                <input type="text" id="a" class="form-control text-right room-price identitas_<?= $dayname->id?>" name="room_price[<?php echo $dayname->id ?>]" />
                            </td>
                            <td>
                                <input type="text" id="b" class="form-control text-right room-only identitasro_<?= $dayname->id?>" name="room_only_price[<?php echo $dayname->id ?>]" onkeyup="subjumlah(<?= $dayname->id?>,this.value)"/> <!--  -->
                            </td>
                            <td>
                                <input type="text" id="c" class="form-control text-right breakfast-price identitasbf_<?= $dayname->id?>" name="breakfast_price[<?php echo $dayname->id ?>]" onkeyup="subjumlah(<?= $dayname->id?>,this.value)"/> <!--  -->
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <input type="hidden" name="action" value="update" />
                        <?php foreach ($daynames as $key => $dayname): ?>
                        <tr class="<?=$dayname->dayname?> dayname">
                            <td>
                                <?php echo $dayname->dayname; ?>
                                <input type="hidden" name="id[]" value="<?php echo $room_rates[$key]->id ?>"/>
                            </td>
                            <td>
                                <input type="text" id="d" class="form-control text-right room-price identitas_<?= $dayname->id?>" name="room_price[<?php echo $room_rates[$key]->id ?>]" value="<?php echo $room_rates[$key]->room_price ?>" />
                            </td>
                            <td>
                                <input type="text" id="e" class="form-control text-right room-only identitasro_<?= $dayname->id?>" name="room_only_price[<?php echo $room_rates[$key]->id ?>]" value="<?php echo $room_rates[$key]->room_only_price ?>" onkeyup="subjumlah(<?= $dayname->id?>,this.value)"/> <!--  -->
                            </td>
                            <td>
                                <input type="text" id="f" class="form-control text-right breakfast-price identitasbf_<?= $dayname->id?>" name="breakfast_price[<?php echo $room_rates[$key]->id ?>]" value="<?php echo $room_rates[$key]->breakfast_price ?>" onkeyup="subjumlah(<?= $dayname->id?>,this.value)"/> <!--  -->
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <tbody>
                </table>

                <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Simpan</button>
                <a class="btn btn-danger waves-effect waves-light m-t-10" href="javascript:window.history.back();">Batal</a>
                
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var format = new curFormatter();
        format.input('#a');
        format.input('#b');
        format.input('#c');
        format.input('#d');
        format.input('#e');
        format.input('#f');
    });


    function subjumlah(id,value){
        var format = new curFormatter();
        room_only = $('.identitasro_'+id).val();
        room_only = CekNanNParseInt(format.unformat(room_only));
        breakfast_price = $('.identitasbf_'+id).val();
        breakfast_price = CekNanNParseInt(format.unformat(breakfast_price));

        sum = room_only + breakfast_price;

        $('.identitas_'+id).val(format.format(sum));
    }

    function CekNanNParseInt(value){
        var value;
        if(isNaN(parseInt(value))){
            value=0;
        }else{
            value=parseInt(value);
        }
        return value;
      }
</script>