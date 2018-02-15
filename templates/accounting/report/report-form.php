<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Tambah Data Header Account',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Akunting',
    'submain_location' => 'Tambah Data Header Account'
  ]); 
?>

<div class="error">
    <?php print_r(@$errors) ?>
</div>

<div class="row">
    <div class="col-sm-12">
      <div class="white-box">

        <ul class="nav customtab nav-tabs" role="tablist">
            <li role="presentation" class="">
                <a href="#account" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false">
                    <span class=""> Account</span>
                </a>
            </li>
            <li role="presentation" class="">
                <a href="#profile1" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">
                    <span class=""> Profile</span>
                </a>
            </li>
        </ul>

        <div class="tab-content">
              <div role="tabpanel" class="tab-pane fade" id="home1">
                <div class="col-md-6">
                  <h3>Best Clean Tab ever</h3>
                  <h4>you can use it with the small code</h4>
                </div>
                <div class="col-md-5 pull-right">
                  <p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a.</p>
                </div>
                <div class="clearfix"></div>
              </div>
              <div role="tabpanel" class="tab-pane fade" id="profile1">
                <div class="col-md-6">
                  <h3>Lets check profile</h3>
                  <h4>you can use it with the small code</h4>
                </div>
                <div class="col-md-5 pull-right">
                  <p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a.</p>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>

        <h3 class="box-title m-b-0">Form Accounts</h3>
        <p class="text-muted m-b-20 font-13"> </p>
        <form class="form-horizontal" action="<?php echo $this->pathFor('accounting-headers-save') ?>" method="POST">
        <input type="hidden" class="form-control" value="<?=@$header->id?>" name="id">
        <div class="form-group">
            <label class="col-md-12"> <span class="help"> Group</span></label>
            <div class="col-md-12">
              <select class="form-control" name="accgroups_id">
                <?php foreach($groups as $group){ ?>
                    <option <?=$group->id==@$header->accgroups_id?'selected="selected"':''?> 
                        value="<?=$group->id?>"> <?=$group->name?>    
                    </option>
                <?php }?>
              </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-12"> <span class="help"> Kode</span></label>
            <div class="col-md-12">
              <input type="text" class="form-control" value="<?=@$header->code?>" name="code">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-12"> <span class="help"> Nama</span></label>
            <div class="col-md-12">
              <input type="text" class="form-control" value="<?=@$header->name?>" name="name">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-12"> <span class="help"> Keterangan</span></label>
            <div class="col-md-12">
              <input type="text" class="form-control" value="<?=@$header->remark?>" name="remark">
            </div>
        </div>
        
        <div class="form-group m-b-0">
            <div class="col-md-12">
                <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Simpan</button>
                <a class="btn btn-danger waves-effect waves-light m-t-10" href="javascript:window.history.back();">Batal</a>
            </div>
        </div>
            
        </form>
      </div>
    </div>
</div>
