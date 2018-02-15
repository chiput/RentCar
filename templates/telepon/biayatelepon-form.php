<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Tambah Tarif Telepon',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Management',
    'submain_location' => 'Tarif Telepon'
  ]);

?>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
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
        <?php endif; ?>    
            <h3 class="box-title m-b-0">Form Tarif Telepon </h3>
            <p class="text-muted m-b-30"></p>
            <form class="form-horizontal" action="<?php echo $this->pathFor('telpbiaya-save'); ?>" method="post">
            <input type="hidden" class="form-control" value="<?php echo @$biaya->id ?>" name="id">


            <div class="col-md-6">

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Nomer Depan</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$biaya->nodepan;?>" name="nodepan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Durasi (detik)</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$biaya->durasi;?>" name="durasi">
                        </div>
                    </div>

            </div>
            <div class="col-md-6">

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Harga</span></label>
                        <div class="col-md-12">
                           <input type="text" class="form-control" id="harga" value="<?php echo @$biaya->harga; ?>" name="harga">
                        </div>
                    </div>

            </div>
            <div class="form-group m-b-0">
                <div class="col-md-12">

                    <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
                    <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('telpbiaya')?>">Batal</a>

                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var format = new curFormatter();
        format.input('#harga');
    });
</script>