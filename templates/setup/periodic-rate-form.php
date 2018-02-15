<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Setup Harga Periodik',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Setup',
    'submain_location' => 'Form Setup Harga Periodik'
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

<?php endif; 
function convert_date($date){
            $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
            return $date;
        } 
?>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box" id="setup-periodic-rate">
            <h3 class="box-title m-b-0">Form Harga Periodik </h3>
            <p class="text-muted m-b-30"></p>
            <form class="form-horizontal" action="<?php echo $this->pathFor('setup-periodic-rate-save'); ?>" method="post">
            <input type="hidden" class="form-control" value="<?php echo @$rate->id ?>" name="id">

            <div class="col-md-6">

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Nama </span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$rate->name ?>" name="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Rentang Waktu </span></label>
                        <div class="col-md-12">
                            <div class="input-daterange input-group" id="date-range" data-date-format="dd-mm-yyyy">
                                <input type="text" class="form-control" name="start_date" value="<?=@$rate->start_date == '' ? date('d-m-Y') : convert_date(@$rate->start_date)?>" />
                                <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                                <input type="text" class="form-control" name="end_date" value="<?=@$rate->end_date == '' ? date('d-m-Y') : convert_date(@$rate->end_date)?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Kenaikan </span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" id="markup" name="markup" value="<?=@$rate->markup | 0?>" />
                            <div class="checkbox checkbox-success">
                                <input id="markup_percent" name="markup_percent" type="checkbox" value="1"
                                <?=(@$rate->markup_percent==1?'checked="checked"':"")?>
                                >
                                <label for="markup_percent">Dalam persen</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Diskon </span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" id="disc" name="disc" value="<?=@$rate->disc | 0?>" />
                            <div class="checkbox checkbox-success">
                                <input id="disc_percent" name="disc_percent" type="checkbox" value="1"
                                <?=(@$rate->disc_percent==1?'checked="checked"':"")?>
                                >
                                <label for="disc_percent">Dalam persen</label>
                            </div>
                        </div>
                    </div>

            </div>
            <div class="col-md-6">

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Tipe Kamar </span></label>
                        <div class="col-md-12">
                            <select class="form-control" name="room_types_id" v-on:change="roomFilter" v-model="roomType"> 
                                <option value=""></option>
                                <?php foreach($roomtypes as $roomtype){ ?>    
                                    <option value="<?=$roomtype->id?>" <?=($roomtype->id==@$rate->room_types_id?'selected="selected"':'')?>>
                                        <?=$roomtype->name?>
                                    </option>
                                <?php }?>    
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Jenis T. Tidur </span></label>
                        <div class="col-md-12">
                            <select class="form-control" name="bed_types_id" v-on:change="roomFilter" v-model="bedType">
                                <option value=""></option>
                                <?php foreach($bedtypes as $bedtype){ ?>    
                                    <option value="<?=$bedtype->id?>" <?=($bedtype->id==@$rate->bed_types_id?'selected="selected"':'')?>>
                                        <?=$bedtype->name?>
                                    </option>
                                <?php }?>    
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Keterangan </span></label>
                        <div class="col-md-12">
                            <textarea class="form-control" rows="3" name="remark"><?=@$rate->remark?></textarea>
                        </div>
                    </div>

            </div>
            <div class="col-md-12">

                    <div class="form-group">
                        <input type="hidden" id="roomlist" value='<?=json_encode($rooms)?>' />
                        <input type="hidden" id="sellist" value='<?=json_encode(@$rate->details)?>' />
                        <label class="col-md-12"> <span class="help"> Daftar Kamar </span></label>
                        <div style="float: left; margin-left: 8px;">
                        <a class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#roomModal" v-on:click="addRoom">
                        <i></i>Tambah Kamar</a>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Tipe Kamar</th>
                                    <th>Jenis T. Tidur</th>                   
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="roomId in selectedRooms">
                                    <td>
                                        <input type="hidden" name="rooms_id[]" value="{{rooms[roomId].id}}">
                                        {{rooms[roomId].number}}
                                    </td>
                                    <td>
                                        {{rooms[roomId].bed_type.name}}
                                    </td>
                                    <td>
                                        {{rooms[roomId].room_type.name}}
                                    </td>
                                    <td>
                                        <a class="btn btn-danger" href="javascript:void(0)" v-on:click="deleteRoom" data-room-id="{{roomId}}"><i class="fa fa-times" v-on:click="deleteRoom" data-room-id="{{roomId}}"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div id="roomModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="myModalLabel">Daftar Kamar</h4>
                              </div>
                              <div class="modal-body">
                              <!-- <input type="text" name="search" value="" v-on:keyup="search"/> -->
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nomor</th>
                                            <th>Tipe Kamar</th>
                                            <th>Jenis T. Tidur</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="room in rooms" >
                                            <td>
                                                <div class="checkbox checkbox-success">
                                                    <input type="checkbox" value="{{room.id}}" name="room_{{room.id}}" id="room_{{room.id}}" v-model="selectedRooms" v-on:click="checking" />
                                                    <label for="room_{{room.id}}">{{room.number}}</label>
                                                </div>         
                                            </td>
                                            <td>
                                                {{room.bed_type.name}}
                                            </td>
                                            <td>
                                                {{room.room_type.name}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>
        </div>

            <div class="form-group m-b-0">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
                    <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?php echo $this->pathFor('setup-periodic-rate'); ?>">Batal</a>
                </div>
            </div>      

            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var format = new curFormatter();
        format.input('#markup');
        format.input('#disc');
    });
</script>