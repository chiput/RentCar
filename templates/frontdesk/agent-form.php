<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Sopir',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Frontdesk',
    'submain_location' => 'Sopir'
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
            <h3 class="box-title m-b-0">Form Sopir</h3>
            <p class="text-muted m-b-30"></p>
            <form class="form-horizontal" action="<?php echo $this->pathFor('frontdesk-agent-save'); ?>" method="post">
            <input type="hidden" class="form-control" value="<?php echo @$agent->id ?>" name="id">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Kode</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$agent->code ?>" name="code">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Nama</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$agent->name ?>" name="name">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <div class="col-md-12">
                        <div class="checkbox checkbox-success">

                            <?php if (!isset($agent->is_active)): ?>
                                <input id="is_active" name="is_active" type="checkbox" checked="checked" />
                                <label for="is_active"> Aktif</label>
                              <?php else: ?>
                                <input id="active" type="checkbox" value="1" <?=@$agent->is_active==1?'checked="checked"':''?> name="is_active">
                                <label for="active"> Aktif </label>
                            <?php endif; ?>
                            
                        </div>
                        </div>
                    </div>
                </div>    
                            <div class="form-group m-b-0">
            <div class="col-md-12">
                    <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
                    <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('frontdesk-agent')?>">Batal</a>
                </div>
            </div>
            
            

            </form>
        </div>
    </div>
</div>
