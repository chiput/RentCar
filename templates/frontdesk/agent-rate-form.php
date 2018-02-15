<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Harga Sopin',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Frontdesk',
    'submain_location' => 'Harga Sopir'
  ]);

?>
<?php if (@$errors!=""): ?>
<div class="row">
    <div class="alert alert-danger alert-dismissable col-sm-6">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php foreach($errors as $error){
            echo $error."<br>";
        } ?>
    </div>
</div>
<?php endif; ?>
<div class="row" id="agent-rate-app">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Frontdesk </h3>
            <p class="text-muted m-b-30">Sopir: <?=@$agent->name?> <br/> Kamar: <?=@$room->number?></p>
            <form class="form-horizontal" action="<?php echo $this->pathFor('frontdesk-agentrate-save'); ?>" method="post">
            <input type="hidden" class="form-control" value="<?php echo @$rate->id ?>" name="id">
            <input type="hidden" class="form-control" value="<?php echo @$agent->id ?>" name="agents_id">
            <input type="hidden" class="form-control" value="<?php echo @$room->id ?>" name="room_id">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Harga</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" id="room_price" value="<?php echo @$rate->room_price | 0 ?>" name="room_price" id="price" readonly="readonly" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Harga Sopir</span></label>
                        <div class="col-md-12">
                            <input type="text" step="0.01" class="form-control" id="room_only_price" value="<?php echo @$rate->room_only_price | 0 ?>" id="room" name="room_only_price" onkeyup="totaling()">
                        </div>
                    </div>

                    <div class="form-group hidden">
                        <label class="col-md-12"> <span class="help"> Harga Breakfast</span></label>
                        <div class="col-md-12">
                            <input type="text" step="0.01" class="form-control" id="breakfast_price" value="<?php echo @$rate->breakfast_price | 0?>" id="breakfast" name="breakfast_price" onkeyup="totaling()">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success waves-effect waves-light m-r-10"><?=@$rate->id == ''?'Simpan':'Update'?></button>
                    <?php if(@$rate->id != ""){ ?>
                    <a class="btn btn-warning waves-effect waves-light m-r-10" href="<?php echo $this->pathFor('frontdesk-agentrate-delete', ['id' => $rate->id]); ?>">Hapus</a>
                    <?php } ?>
                    <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('setup-room')?>">Batal</a>
                </div>
            </div>
            
            

            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var format = new curFormatter();
        format.input('#room_only_price');
        format.input('#breakfast_price');
        format.input('#room_price');
    });

    function totaling(){
        var format = new curFormatter();

        room_only = $('#room_only_price').val();
        room_only = CekNanNParseInt(format.unformat(room_only));
        breakfast_price = $('#breakfast_price').val();
        breakfast_price = CekNanNParseInt(format.unformat(breakfast_price));

        sum = room_only + breakfast_price;
        console.log(sum);
        $('#room_price').val(format.format(sum));
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