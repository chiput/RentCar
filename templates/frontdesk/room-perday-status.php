<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Status Mobil',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Frontdesk',
    'submain_location' => 'Status Mobil'
  ]);

//print_r($reservations);
//$arrStatus=["Out Of Service","Dirty"];
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Status Mobil</h3>
            <p class="text-muted m-b-30">Data Status Mobil</p>
            <?php
                function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
            ?>
            <form class="form-horizontal" method="POST">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-md-3 control-label"> <span class="help"> Tanggal</span></label>
                            <div class="col-md-9">
                                <input type="text" data-date-format="dd-mm-yyyy" class="form-control mydatepicker" value="<?php echo @$date ?>" name="date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"> <span class="help"> Tipe Mobil</span></label>
                            <div class="col-md-9">
                                <select class="form-control" name="room_type_id">
                                    <option value="">-Pilih Tipe-</option>
                                <?php foreach ($room_types as $key => $type) { ?>
                                    <option value="<?=$type->id?>" <?=($type->id==$room_type_id?'selected="selected"':'')?>><?=$type->name?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <button class="form-control btn btn-info">Filter</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="white-box">
            <div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Mobil</th>
                            <th>Status</th>
                            <!-- <th>Ikon</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($rooms as $room){ ?>
                            <tr>
                                <td><?=$room->number?></td>
                                <td>
                                    <?=$room->roomStatus->type->desc?>
                                </td>
                                <!-- <td width="20">
                                    <?php if (@$room->roomStatus->type->icon != ''): ?>
                                        <img src="data:image/png;base64,<?=$room->roomStatus->type->icon?>" alt="<?=$room->roomStatus->type->code?>" title="<?=$room->roomStatus->type->code?>" />
                                    <?php endif; ?>
                                </td> -->
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

