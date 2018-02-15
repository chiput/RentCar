<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Tamu Inhouse',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Frontdesk',
    'submain_location' => 'Guest'
  ]);

    $activeStatus = [
        'Tidak Aktif',
        'Aktif'
    ];

?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">In House Guest</h3>
            <p class="text-muted m-b-30">Data Tamu Inhouse</p>
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-md-3 control-label"> <span class="help"> Tanggal</span></label>
                            <div class="col-md-9">
                                <input type="text" data-date-format="dd-mm-yyyy" class="form-control mydatepicker" value="<?php 
                                echo convert_date(@$date) ?>" name="date">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
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
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th>No. Kamar</th>
                        <th>Jenis Kamar</th>
                        <th>Gedung</th>
                        <th>Remarks</th>
                        <th>Nama</th>
                        <th>Negara</th>
                    </tr>
                </thead>
                <tbody>
                <?php $total = 0;
                    foreach ($guests as $guest):                 
                    if(!(date("d-m-Y",strtotime($guest->checkout))==$date)){ 
                    $total = $total + 1; ?>
                    <tr>
                        <td><?php echo $guest->number; ?></td>
                        <td><?php echo $guest->type; ?></td>
                        <td><?php echo $guest->building; ?></td>
                        <td><?php echo $guest->remarks; ?></td>
                        <td><?=$guest->name?></td>
                        <td><?= $guest->country?></td>
                    </tr>
                <?php } endforeach; ?>
                <tbody>
            </table>
            <b>Total Guest: <?= $total; ?></b>
            <form class="form-horizontal" method="POST" action="<?= $this->pathFor('frontdesk-guest-list-report'); ?>">
                <input style="display: none;" type="text" data-date-format="yyyy-mm-dd" class="form-control mydatepicker" value="<?php echo @$date ?>" name="date">

                <select style="display: none;" class="form-control" name="room_type_id">
                    <option value="">-Pilih Tipe-</option>
                <?php foreach ($room_types as $key => $type) { ?>
                    <option value="<?=$type->id?>" <?=($type->id==$room_type_id?'selected="selected"':'')?>><?=$type->name?></option>
                <?php } ?>
                </select>

                <select style="display: none;" class="form-control" name="building_id">
                    <option value="">-Pilih Gedung-</option>
                <?php foreach ($buildings as $building) { ?>
                    <option value="<?=$building->id?>" <?=($building->id==$building_id?'selected="selected"':'')?>><?=$building->name?></option>
                <?php } ?>
                </select>

                <div class="row" style="margin-top: 5px; margin-left: 3px;">
                <div class="col-md-1">
                        <div class="form-group">
                            <button class="btn btn-default btn-rounded waves-effect waves-light"><span class="btn-label"><i class="fa fa-print"></i></span>Print</button>
                        </div>
                    </div>
                    </div>
            </form>
        </div>
    </div>
</div>