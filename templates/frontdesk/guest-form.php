<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Pelanggan',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Frontdesk',
    'submain_location' => 'Pelanggan'
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
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Form Pelanggan</h3>
            <p class="text-muted m-b-30"></p>
            <?php
                function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
            ?>

            <form class="form-horizontal" action="<?php echo $this->pathFor('frontdesk-guest-save'); ?>" method="post">
            <input type="hidden" class="form-control" value="<?php echo @$guest->id ?>" name="id">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Nama Pelanggan</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$guest->name ?>" name="name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Alamat</span></label>
                        <div class="col-md-12">
                            <textarea name="address" class="form-control" rows="3"><?php echo @$guest->address ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Negara</span></label>
                        <div class="col-md-12">
                            <select name="country_id" class="form-control select2">
                            <?php foreach ($countries as $country): ?>
                                <option value="<?php echo $country->id; ?>" <?php if (isset($guest) && $guest->country_id == $country->id) { echo "selected"; } ?>><?php echo $country->nama; ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Provinsi / State</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$guest->state ?>" name="state">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Kota</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$guest->city ?>" name="city">
                        </div>
                    </div>

                    
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Kode Pos</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$guest->zipcode ?>" name="zipcode">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Telepon</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$guest->phone ?>" name="phone">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Fax</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$guest->fax ?>" name="fax">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Email</span></label>
                        <div class="col-md-12">
                            <input type="email" class="form-control" value="<?php echo @$guest->email ?>" name="email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Perusahaan</span></label>
                        <div class="col-md-12">
                            <select name="company_id" class="form-control select2">
                                <option> -- Pilih Perusahaan -- </option>
                            <?php foreach ($companies as $company): ?>
                                <option <?=($company->id==@$guest->company_id?'selected="selected"':'')?> value="<?php echo $company->id; ?>"><?php echo $company->name; ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    

               
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Jenis Kelamin</span></label>
                        <div class="col-md-12">
                            <label><input type="radio" name="sex" value="1" <?php if (!isset($guest) || $guest->sex == 1) { echo 'checked'; } ?> /> Laki-laki</label>
                            <label><input type="radio" name="sex" value="2" <?php if (isset($guest) && $guest->sex == 0) { echo 'checked'; } ?> /> Perempuan</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Tanggal Lahir</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control mydatepicker" data-date-format="dd-mm-yyyy" value="<?php echo convert_date(@$guest->date_of_birth) ?>" name="date_of_birth">
                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Jenis Identitas</span></label>
                        <div class="col-md-12">
                            <select name="idtype_id" class="form-control select2">
                            <?php foreach ($idtypes as $idtype): ?>
                                <option value="<?php echo $idtype->id; ?>"><?php echo $idtype->name; ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Tanggal Berlaku</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control mydatepicker" data-date-format="dd-mm-yyyy" value="<?php echo convert_date(@$guest->date_of_validation) ?>" name="date_of_validation">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Nomor Identitas</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$guest->idcode ?>" name="idcode">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox checkbox-danger" style="margin-left: 8px; float: left;">
                            <input id="blacklist" type="checkbox" value="1" <?=@$guest->is_blacklist==1?'checked="checked"':''?> name="is_blacklist">
                            <label for="blacklist"> Black List </label>
                        </div>
                    </div>

                    <div class="form-group hidden">
                        <label class="col-md-12"> <span class="help"> Active</span></label>
                        <div class="col-md-12">
                            <label><input type="radio" name="is_active" value="1" <?php if (!isset($guest) || $guest->is_active == 1) { echo 'checked'; } ?> /> Aktif</label>
                            <label><input type="radio" name="is_active" value="0" <?php if (isset($guest) && $guest->is_active == 0) { echo 'checked'; } ?> /> Tidak Aktif</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
                    <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('frontdesk-guest')?>">Batal</a>
            </div>
            
            

            </form>
        </div>
    </div>
</div>
