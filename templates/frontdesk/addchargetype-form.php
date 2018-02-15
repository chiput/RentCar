<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Jenis Biaya',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Frontdesk',
    'submain_location' => 'Jenis Biaya'
  ]);

?>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Form Jenis Biaya Tambahan</h3>
            <p class="text-muted m-b-30"></p>
            <?php if (!is_null($errors)): ?>
            <div>
                <p>
                    Error:
                </p>
                <p>
                    <?php echo implode('<br>', $errors); ?>
                </p>
            </div>
            <?php endif; ?>
            <form class="form-horizontal" action="<?php echo $this->pathFor('frontdesk-addchargetype-save'); ?>" method="post">
            <input type="hidden" class="form-control" value="<?php echo @$type->id ?>" name="id">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Kode</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$type->code ?>" name="code">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Nama</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$type->name ?>" name="name">
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Acc. Pendapatan</span></label>
                        <div class="col-md-12">
                            <select class="form-control select2" name="accincome">
                                <?php foreach($accounts as $account){ ?>
                                    <option value="<?=$account->id?>" 
                                        <?=($account->id==@$type->accincome?'selected="selected"':'')?>>
                                        <?=$account->code?> | <?=$account->name?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Acc. Biaya</span></label>
                        <div class="col-md-12">
                            <select class="form-control select2" name="acccost">
                                <?php foreach($accounts as $account){ ?>
                                    <option value="<?=$account->id?>" 
                                        <?=($account->id==@$type->acccost?'selected="selected"':'')?>>
                                        <?=$account->code?> | <?=$account->name?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Harga Jual</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$type->sell ?>" name="sell">
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Harga Jual</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$type->sell ?>" name="sell">
                        </div>
                    </div>-->

                    <div class="form-group hidden">
                        <label class="col-md-12"> <span class="help"> Harga Beli</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$type->buy ?>" name="buy">
                        </div>
                    </div>
                <!-- </div> -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Keterangan</span></label>
                        <div class="col-md-12">
                            <textarea name="remark" rows="3" class="form-control" ><?php echo @$type->remark ?></textarea>
                        </div>
                    </div>

                    
                    <div class="form-group hidden">
                        <div class="checkbox checkbox-danger">
                            <input id="is_active" type="checkbox" value="1" <?=@$type->is_active==1?'checked="checked"':''?> name="is_active">
                            <label for="is_active"> Aktif </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox checkbox-danger">
                            <input id="is_editable" type="checkbox" value="1" <?=@$type->is_editable==1?'checked="checked"':''?> name="is_editable">
                            <label for="is_editable"> Harga bisa disesuaikan </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
                    <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('frontdesk-addchargetype')?>">Batal</a>
            </div>
            

            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var format = new curFormatter();
        format.input("[name='sell']");
        format.input("[name='buy']");
    });
</script>