<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Tambah Mobil',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Setup',
    'submain_location' => 'Tambah Mobil'
  ]);

    $currencies = [
        1 => 'Rupiah',
        2 => 'Euro',
        3 => 'US Dollar'
    ];

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
<div class="row">
    <div class="col-sm-6">
        <div class="white-box">
            <h3 class="box-title m-b-0">Form Mobil </h3>
            <p class="text-muted m-b-30"></p>
            <form class="form-horizontal" action="<?php echo $this->pathFor('setup-room-save'); ?>" method="post">
            <input type="hidden" class="form-control" value="<?php echo @$room->id ?>" name="id">

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Nama Mobil</span></label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" value="<?php echo @$room->number ?>" name="number">
                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Atas Nama</span></label>
                        <div class="col-md-12">
                            <textarea class="form-control" name="note" rows="1"><?php echo @$room->note ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Plat Nomor </span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$room->level?>" name="level">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Jenis Mobil</span></label>
                        <div class="col-md-12">
                            <select class="form-control" name="room_type_id">
                                <?php foreach ($roomtypes as $roomtype): ?>
                                <option value="<?php echo $roomtype->id; ?>" <?php if (isset($room) && $room->room_type_id == $roomtype->id) { echo "selected"; } ?>><?php echo $roomtype->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group hidden">
                        <label class="col-md-12"> <span class="help"> Dewasa</span></label>
                        <div class="col-md-12">
                            <input type="number" class="form-control" value="<?php echo @$room->adults | 0 ?>" name="adults">
                        </div>
                    </div>

                    <div class="form-group hidden">
                        <label class="col-md-12"> <span class="help">Anak-anak</span></label>
                        <div class="col-md-12">
                            <input type="number" class="form-control" value="<?php echo @$room->children | 0 ?>" name="children">
                        </div>
                    </div>

                    <div class="form-group hidden">
                        <label class="col-md-12"> <span class="help">Gedung</span></label>
                        <div class="col-md-12">
                            <select class="form-control select2" name="buildings_id">
                                <?php foreach ($buildings as $building): ?>
                                <option value="<?php echo $building->id; ?>" <?php if (isset($room) && $room->buildings_id == $building->id) { echo "selected"; } ?>><?php echo $building->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group hidden">
                        <label class="col-md-12"> <span class="help"> Jenis Tempat Tidur</span></label>
                        <div class="col-md-12">
                            <select class="form-control" name="bed_type_id">
                                <?php foreach ($bedtypes as $bedtype): ?>
                                <option value="<?php echo $bedtype->id; ?>" <?php if (isset($room) && $room->bed_type_id == $bedtype->id) { echo "selected"; } ?>><?php echo $bedtype->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group hidden">
                        <label class="col-md-12"> <span class="help">Mata Uang</span></label>
                        <div class="col-md-12">
                            <select class="form-control" name="currency">
                                <?php foreach ($currencies as $key => $currency): ?>
                                <option value="<?php echo $key; ?>" <?php if (isset($room) && $room->currency == $key) { echo "selected"; } ?>><?php echo $currency; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 hidden">
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Deskripsi Kamar</span></label>
                        <div class="col-md-12">
                            <?php foreach ($room_descriptions as $room_description): ?>
                            <div class="">
                                <label>
                                    <input name="room_descriptions[]" value="<?php echo $room_description->id ?>" type="checkbox" 
                                    <?php 
                                        foreach($relDescription as $des) {
                                            if ($room_description->id == $des->room_description_id) {
                                                echo 'checked="checked"';
                                                break;
                                            }
                                        }
                                    ?>
                                    />
                                    <?php echo $room_description->name ?>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Fasilitas Kamar</span></label>
                        <div class="col-md-12">
                            <?php foreach ($roomfacilities as $facility): ?>
                            <div class="">
                                <label>
                                    <input name="room_facilities[]" value="<?php echo $facility->id ?>" type="checkbox" 
                                    <?php 
                                        foreach($relFacility as $fac) {
                                            if ($facility->id == $fac->room_facility_id) {
                                                echo 'checked="checked"';
                                                break;
                                            }
                                        }
                                    ?>
                                    />
                                    <?php echo $facility->name ?>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="form-group hidden">
                        <label class="col-md-12"> <span class="help"> Active</span></label>
                        <div class="col-md-12">
                            <label><input type="radio" name="is_active" value="1" <?php if (!isset($bed_type) || $bed_type->is_active == 1) { echo 'checked'; } ?> /> Aktif</label>
                            <label><input type="radio" name="is_active" value="0" <?php if (isset($bed_type) && $bed_type->is_active == 0) { echo 'checked'; } ?> /> Tidak Aktif</label>
                        </div>
                    </div>
     
                </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Simpan</button>
                            <a class="btn btn-danger waves-effect waves-light m-t-10" href="javascript:window.history.back();">Batal</a>
                        </div>

            </div>
            </form>
        </div>
    </div>
</div>
