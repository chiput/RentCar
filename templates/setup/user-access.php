<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Hak Akses',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'User',
    'submain_location' => 'Akses User '
  ]); 

  //print_r($permission);
?>



<div class="row">
    <div class="col-sm-12">
      <div class="white-box">
        <?php if($this->getSessionFlash('error_messages')!=""){ ?>
        <div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <?=$this->getSessionFlash('error_messages')?>
        </div>
        <?php }
        ?>       
        
        <h3 class="box-title m-b-0">Hak Akses</h3>
        <h4 class="m-b-0"><?=$user->code?> / <?=$user->name?></h3>
        <p class="text-muted m-b-30 font-13"> </p>
        <form class="form-horizontal" action="<?php echo $this->pathFor('setup-useraccess-save'); ?>" method="post">
        <input type="hidden" class="form-control" value="<?php echo @$user->id ?>" name="user_id">


        <table class="table">
            <tbody>
                <?php foreach ($categories as $cat){ ?>
                <tr>
                    <td colspan="3" style="font-size: 18px; font-style: bold;">
                        <span class="checkbox checkbox-success">
                            <input id="cat<?=$cat->id?>" type="checkbox" value="<?=$cat->id?>" class="cat_check">
                            <label for="cat<?=$cat->id?>"> <?=strtoupper($cat->name)?> </label>
                        </span>
                    </td>
                </tr>

                    <?php foreach ($cat->resources as $res){ ?>
                    <tr>
                        <td style="width: 40px;"></td>
                        <td colspan="2" style="font-size: 16px;">
                            <span class="checkbox checkbox-success">
                            <input id="res<?=$res->id?>" type="checkbox" value="<?=$res->id?>"  class="res_check" data-cat="cat<?=$cat->id?>">
                            <label for="res<?=$res->id?>"> <?=$res->name?> </label>
                            </span>
                        </td>
                    </tr>
    
                    <tr>
                        <td></td>
                        <td style="width: 30px;"></td>
                        <td>
                            <?php foreach ($res->actions as $act){ ?>
                                <div class="floating">
                                    <span class="checkbox checkbox-success">
                                    <input 
                                    <?=(isset($permission[$act->id])?'checked="checked"':'')?>
                                    id="act<?=$act->id?>" type="checkbox" value="<?=$act->id?>" name="act[<?=$act->id?>]"
                                      class="act_check" data-res="res<?=$res->id?>"
                                    >
                                    <label for="act<?=$act->id?>"> <?=$act->name?> </label>
                                    </span>
                                </div>
                            <?php } ?>
                        </td>                       
                    </tr>
                        
                    <?php } ?>

                <?php }?>

            </tbody>
        </table>

        <div class="form-group m-b-0">
            <div class="col-md-12">
                <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Simpan</button>
                <a class="btn btn-danger waves-effect waves-light m-t-10" href="<?php echo $this->pathFor('setup-user'); ?>">Batal</a>
            </div>
        </div>

        </form>
      </div>
    </div>
</div>
<style type="text/css">
    .checkbox label{
        text-transform: capitalize;
    }
    .floating {
        display: inline-block;
        float: left;
        margin-left: 10px;
    }
</style>
<script type="text/javascript">

var checking=function(){
    $.each($(".res_check").get(),function(index_res, res){        
        var check=true; 
        $.each($("[data-res='"+res.id+"']").get(),function(index_act, act) {
            if(!act.checked){
                check=false;
            }
        });
        res.checked=check;
    });

    $.each($(".cat_check").get(),function(index_cat, cat){        
        var check=true; 
        $.each($("[data-cat='"+cat.id+"']").get(),function(index_res, res) {
            if(!res.checked){
                check=false;
            }
        });
        cat.checked=check;
    });
};

$(document).ready(function() {
    
    checking();

    $(".act_check").click(function(event) {
        checking();
    });
    $(".res_check").click(function(event) {
        var id=this.id;
        var check=this.checked;
        $.each($("[data-res='"+id+"']").get(),function(index_act, act) {
            act.checked=check;
        });
        checking();
    });

    $(".cat_check").click(function(event) {
        var id=this.id;
        var check=this.checked;
        $.each($("[data-cat='"+id+"']").get(),function(index_res, res) {
            res.checked=check;            //$(".res_check").click();
            var check_act=this.checked;
            $.each($("[data-res='"+this.id+"']").get(),function(index_act, act) {
                act.checked=check;
            });
        });
    });
});

</script>
