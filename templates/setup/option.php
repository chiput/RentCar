<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Options',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Setup',
    'submain_location' => 'Opsi'
  ]); 

function formHelper($name,$label,$accounts,$value){
    $opt='';
    foreach ($accounts as $account) {
        $opt.='<option '.($account->id==$value?'selected="selected"':''). 
                'value="'.$account->id.'">
                '.$account->code.' | '.$account->name.'</option>';
    }
    return ' <div class="form-group">
                <label class="col-md-12"> <span class="help"> '.$label.'</span></label>
                <div class="col-md-12">
            <select class="form-control select2" name="name['.$name.']">'.$opt.'</select>
                </div>
            </div>';
}
    
?>

<?php if ($this->getSessionFlash('success')): ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('success'); ?>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">

            <h3 class="box-title m-b-0">Opsi </h3>
            <p class="text-muted m-b-30">Profil</p>

            <form class="form-horizontal"  method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="help"> Nama Properti </span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" value="<?php echo @$options["profile_name"]->value ?>" name="name[profile_name]">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="help"> Alamat </span></label>
                                    <div class="col-md-12">
                                        <textarea name="name[profile_address]" class="form-control"><?php echo @$options["profile_address"]->value ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="help"> Kota </span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" value="<?php echo @$options["profile_city"]->value ?>" name="name[profile_city]">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="help"> Telp</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" value="<?php echo @$options["profile_phone"]->value ?>" name="name[profile_phone]">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="help"> Fax </span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" value="<?php echo @$options["profile_fax"]->value ?>" name="name[profile_fax]">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="help"> Website</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" value="<?php echo @$options["profile_website"]->value ?>" name="name[profile_website]">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="help"> Email</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" value="<?php echo @$options["profile_email"]->value ?>" name="name[profile_email]">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="help"> Logo</span></label>
                                    <div class="col-md-12">
                                        <img src="<?=$this->baseUrl()?>img/<?=@$options["profile_logo"]->value?>" width="256" >
                                        <input type="file" class="form-control" name="logofile" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="help"> Key</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" value="<?php echo @$options["key"]->value ?>" name="name[key]">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group m-b-0">
                                    <label class="col-md-12"> <span class="help"> &nbsp;</span></label>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
