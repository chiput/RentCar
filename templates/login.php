<?php 
  $this->layout('layouts/login', [
    'title' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'] 
  ]); 
?>

<div class="login-box">

    <div class="white-box">
      <center><img src="<?=$this->baseUrl()?>img/hp-dashboard-bg.png" alt="<?=$app_profile['name']?>" width="70"></center>
      <form class="form-horizontal form-material" id="loginform" action=""  method="post">
        <h3 class="box-title m-b-20"><center>Log in ke <?=$app_profile['name']?></center></h3>

        <div class="message">
		    <?php echo $loginError; ?>
        <?php //print_r($app_profile);?>
		</div>
        <div class="form-group ">
          <div class="col-xs-12">
          	<input type="username" class="form-control" name="name" placeholder="Username" />
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-12">
          	<input type="password" class="form-control" name="password" placeholder="Password" />
          </div>
        </div>
        <div class="form-group hidden">
          <div class="col-md-12">
            <div class="checkbox checkbox-primary pull-left p-t-0">
              <input id="checkbox-signup" type="checkbox">
              <label for="checkbox-signup"> Remember me </label>
            </div>
            <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot pwd?</a> </div>
        </div>
        <div class="form-group text-center m-t-20">
          <div class="col-xs-12">
            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
          </div>
        </div>
      </form>
    </div>
  </div>