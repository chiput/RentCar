<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Profile User',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'User',
    'submain_location' => 'Profile User'
  ]); 
?>

<div class="row">
    <?php if ($this->getSessionFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $this->getSessionFlash('success'); ?>
    </div>
    <?php endif; ?>

     <?php if ($this->getSessionFlash('error_messages')): ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
         <ul>
          <?php
            foreach($this->getSessionFlash('error_messages') as $key => $error) {
            ?>
            <li><?php echo $error; ?></li>
            <?php
            }
          ?>
          </ul>
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
</div>
<div class="row">
    <div class="col-sm-12">
      <div class="white-box">
        
        <h3 class="box-title m-b-0">Form User</h3>
        <p class="text-muted m-b-30 font-13"> </p>
        <form class="form-horizontal" action="<?php echo $this->pathFor('setup-user-save-profile'); ?>" method="post">

        <div class="form-group">
            <label class="col-md-12"> <span class="help"> Username</span></label>
            <div class="col-md-3">
                <input type="text" class="form-control" value="<?php echo @$user->code ?>" name="code">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-12"> <span class="help"> Nama</span></label>
            <div class="col-md-3">
                <input type="text" class="form-control" value="<?php echo @$user->name ?>" name="name">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-12"> <span class="help"> Email</span></label>
            <div class="col-md-3">
                <input type="text" class="form-control" value="<?php echo @$user->email ?>" name="email">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-12"> <span class="help"> Password</span></label>
            <div class="col-md-3">
                <input type="password" class="form-control" value="<?php //echo @$user->password ?>" name="password" placeholder="<?=(@$user->password==""?"Password wajib diisi":"Kosongkan jika tidak ingin mengubah password")?>">
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
