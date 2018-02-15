<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Setup Gudang',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Setup',
    'submain_location' => 'Opsi'
  ]); 
    
?>

<?php if ($this->getSessionFlash('success')): ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('success'); ?>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-sm-6">
        <div class="white-box">

            <h3 class="box-title m-b-0">Setup </h3>
            <p class="text-muted m-b-5">Gudang</p>
                <form class="form-horizontal"  method="POST" enctype="multipart/form-data">                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-md-12"> <span class="help"> Gudang Store </span></label>
                                <div class="col-md-12">
                                    <select class="form-control select2" name="name[gud_store]">
                                        <?php foreach ($gudang as $gudang): ?>
                                            <option value="<?= $gudang->id?>" <?php if(@$setupgudang['gud_store']->value == $gudang->id){echo 'selected';}?>><?= $gudang->nama?> | <?= $gudang->department->name?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12"> <span class="help"> Gudang Restorante </span></label>
                                <div class="col-md-12">
                                    <select class="form-control select2" name="name[gud_restorente]">
                                        <?php foreach ($gudangs as $gudangs): ?>
                                            <option value="<?= $gudangs->id?>" <?php if(@$setupgudang['gud_restorente']->value == $gudangs->id){echo 'selected';}?>><?= $gudangs->nama?> | <?= $gudangs->department->name?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12"> <span class="help"> Gudang White Horse </span></label>
                                <div class="col-md-12">
                                    <select class="form-control select2" name="name[gud_whitehorse]">
                                        <?php foreach ($gudangz as $gudangz) { ?>
                                            <option value="<?= $gudangz->id?>" <?php if(@$setupgudang['gud_whitehorse']->value == $gudangz->id){echo 'selected';}?>><?= $gudangz->nama?> | <?= $gudangz->department->name?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12"> <span class="help"> Menu Restoran </span></label>
                                <div class="col-md-12">
                                    <select class="form-control select2" name="name[menu_resto]">
                                        <?php foreach ($gudangx as $gudangz) { ?>
                                            <option value="<?= $gudangz->id?>" <?php if(@$setupgudang['menu_resto']->value == $gudangz->id){echo 'selected';}?>><?= $gudangz->nama?> | <?= $gudangz->department->name?></option>
                                        <?php } ?>
                                    </select>
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
