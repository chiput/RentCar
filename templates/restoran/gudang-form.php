<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Tambah Gudang Restoran',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Restoran',
    'submain_location' => 'Gudang Restoran'
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
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Form Data Gudang Restoran</h3>
            <p class="text-muted m-b-30">Menambah Data  Gudang Restoran</p>

            <form class="form-horizontal" action="<?php echo $this->pathFor('gudang-save'); ?>" method="post" id='gudangForm'>
            <input type="hidden" class="form-control" value="<?php echo @$gudang->id ?>" name="id">
            <div class="row">
                <div class="col-md-12">


                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Gudang</span></label>
                        <div class="col-md-4">
                            <select name="gudang" class="form-control" onchange="ajaxgudang_get_id(this.value,'<?=$this->pathFor('gudang-ajax')?>');ajaxgudang_get_name(this.value,'<?=$this->pathFor('gudang-ajax')?>');">

                                <option value="">-Pilih-</option>
                                
                                <?php foreach ($dropgudangs as $dropgudang) {
                                if ($dropgudang->id==@$gudang->idgudang){
                                    $select="selected";
                                }else{
                                    $select=''; }?>
                                 <option <?=$select;?> value="<?=$dropgudang->id; ?>!<?=$dropgudang->department_id ; ?>" ><?=$dropgudang->nama; ?></option>   
                                }
                                
                                <?php
                                } ?>
                                
                                

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Departemen</span></label>
                        <div class="col-md-4">
                    
                           <input type="text"  readonly="true"  class="form-control" value="<?=@$gudang->nama_departments; ?>" id="departemen" name="departemen">
                           <input type="hidden" class="form-control" value="<?php echo @$gudang->id_dapertemen ?>" id="id_dapertemen" name="id_dapertemen">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
                    <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('gudang')?>">Batal</a>
                </div>
            </div>
            
            

            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function ajaxgudang_get_name(id,link) {
       // alert(id);
        $.ajax({
            type: "POST",
            url: link,
            data: "id=" + id+'&pram='+'code'+'&get='+'name',
            async: false,
            success: function (data) {
                console.log(data);
               $('#departemen').val(data);
        },error:function(data){
            console.log(data);
        }
        });
        }


function ajaxgudang_get_id(id,link) {
       // alert(id);
        $.ajax({
            type: "POST",
            url: link,
            data: "id=" + id+'&pram='+'code'+'&get='+'id',
            async: false,
            success: function (data) {
                console.log(data);
               $('#id_dapertemen').val(data);
        },error:function(data){
            console.log(data);
        }
        });
        }
</script>