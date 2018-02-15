<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Tambah Barang',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Store',
    'submain_location' => 'Barang'
  ]);

?>

<?php if (@$errors!=""): ?>
<div class="row">
    <div class="alert alert-danger alert-dismissable col-sm-4">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php foreach($errors as $error){
            echo $error."<br>";
        } ?>
    </div>
</div>
<?php endif; ?>
<div class="row">
    <div class="col-sm-6">
        <div class="white-box">
            <h3 class="box-title m-b-0">Form Barang Store</h3>
            <p class="text-muted m-b-30"></p>
            <a href="<?php echo $this->pathFor('log-activity', ['table' => 'storebarang','id' => @$barangnya->id ])?>" onclick="window.open(this.href, 'mywin',
'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;">Log Activity</a>
            <form class="form-horizontal" action="<?php echo $this->pathFor('store-barang-save'); ?>" method="post">
            <input type="hidden" class="form-control" value="<?php echo @$barangnya->id ?>" name="id">
            <div class="row">
                <div class="col-md-12">
                     <input type="number" class="form-control hidden" value="<?php echo @$barangnya->id ?>" name="id">
                     <div class="form-group">
                        <label class="col-md-12"> <span class="help">Barang</span></label>
                        <div class="col-md-8">
                            <select  class="form-control select2" name="barang" id='menuid'>
                            <option>-Pilih Barang-</option>
                                <?php foreach($barangs as $barang) { ?>
                                    <option value="<?=$barang->barangidnya?>" <?php if($barang->barangidnya == @$barangnya->barang_id){ echo 'selected';}?>><?=$barang->kode?> - <?=$barang->nama?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Harga</span></label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="harga" value="<?php echo @$barangnya->harga ?>" name="harga">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
                    <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('store-barang')?>">Batal</a>
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