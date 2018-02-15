<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Status Kamar',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Housekeeping',
    'submain_location' => 'Status Kamar'
  ]);

    function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                } 

//print_r($reservations);
//$arrStatus=["Out Of Service","Dirty"];
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Status Kamar</h3>
            <p class="text-muted m-b-30">Data Status Kamar</p>
            <form class="form-horizontal" method="POST">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-md-3 control-label"> <span class="help"> Tanggal</span></label>
                            <div class="col-md-9">
                                <input type="text" data-date-format="dd-mm-yyyy" class="form-control mydatepicker" value="<?php echo @$date ?>" name="date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"> <span class="help"> Tipe Kamar</span></label>
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

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-md-3 control-label"> <span class="help"> Jenis T. Tidur</span></label>
                            <div class="col-md-9">
                                <select class="form-control" name="bed_type_id">
                                    <option value="">-Pilih Tipe-</option>
                                <?php foreach ($bed_types as $key => $type) { ?>
                                    <option value="<?=$type->id?>" <?=($type->id==$bed_type_id?'selected="selected"':'')?>><?=$type->name?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"> <span class="help"> Gedung</span></label>
                            <div class="col-md-9">
                                <select class="form-control" name="building_id">
                                    <option value="">-Pilih Gedung-</option>
                                <?php foreach ($buildings as $building) { ?>
                                    <option value="<?=$building->id?>" <?=($building->id==$building_id?'selected="selected"':'')?>><?=$building->name?></option>
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
           <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#manual" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"><strong>Set Manual</strong></span></a></li>
              <li role="presentation" class=""><a href="#automatic" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs"><strong>Set Otomatis</strong></span></a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="manual">
                            <form class="form-horizontal" action="<?=$this->pathFor('housekeeping-room-status-save')?>" method="post">
                    <div style="width:100%; overflow:auto">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>No. Kamar</th>
                                    <th>Gedung</th>
                                    <th>Status</th>
                                    <th>Ikon</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($rooms as $room){ ?>
                                    <tr>
                                        <td align="center"><input type="checkbox" class="form-control" name="rooms_id[]" value="<?=$room->id?>" /></td>
                                        <td valign="middle">
                                            <?=$room->number?>
                                        </td>
                                        <td valign="middle">
                                            <?=$room->building->name?>
                                        </td>
                                        <td valign="middle">
                                            <?=$room->roomStatus->type->desc?>
                                        </td>
                                        <td valign="middle">
                                            <?php if (@$room->roomStatus->type->icon != ''): ?>
                                                <img src="data:image/png;base64,<?=$room->roomStatus->type->icon?>" alt="<?=$room->roomStatus->type->code?>" title="<?=$room->roomStatus->type->code?>" />
                                            <?php endif; 
                ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                            <div class="col-md-2">
                               <div class="form-group">
                                <select class="form-control" name="status_kamar">
                                    <?php foreach ($roomstatustype as $roomstatus) { ?>
                                        <option value="<?=$roomstatus->id?>"><?=$roomstatus->code?> - <?=$roomstatus->desc?></option>
                                   <?php } ?>
                                </select>
                               </div>
                            </div>
                             <div class="col-md-2">
                                <div class="form-group">
                                    <button class="form-control btn btn-warning">Set Status</button>
                                </div>
                            </div>
                        </div>
                   </form>
                </div>
                <div role="tabpanel" class="tab-pane" id="automatic">
                     <div class="row">
                             <div class="col-md-10">
                             </div> 
                             <div class="col-md-2">
                                <form class="form-horizontal" action="<?=$this->pathFor('housekeeping-room-status-process')?>" method="post">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" name="tanggal" value="<?=date('Y-m-d')?>" />
                                        <button class="form-control btn btn-warning">Proses Status Room</button>
                                    </div>
                                </form>
                            </div>
                    </div>
                    <div class="row">
                         <h3 class="box-title m-b-0">Riwayat Proses Status Kamar</h3>
                         <table class="table table-striped myDataTable table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>User</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($roomslog as $roomlog) { ?>
                                  <tr>
                                    <td><?=convert_date($roomlog->date)?></td>
                                    <td><?=$roomlog->remark?></td>
                                    <td><?=$roomlog->user->name?></td>
                                  </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

