<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Tarif Telepon',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Management',
    'submain_location' => 'Tarif Telepon'
  ]); 
?>

<?php if ($this->getSessionFlash('success')): ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('success'); ?>
</div>
<?php endif; ?>


<?php



 ?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Tarif Telepon</h3>
            <p class="text-muted m-b-30">Data Tarif Telepon</p>
            <p class="text-muted m-b-20">
                <a href="<?php echo $this->pathFor('telpbiaya-new'); ?>" class="btn btn-primary" style="margin-bottom: 10px;">Tambah Biaya Telepon</a> 
                <button id="setup-fol" class="btn btn-primary" alt="default" data-toggle="modal" data-target="#responsive-modal" class="model_img img-responsive" style="float: right;">Setup Folder</button>
            </p>
            <table class="table table-striped myDataTable" id='myTable'>
              <thead>
                    <tr>
                        <th style="width: 15%;"></th>
                        <th style="width: 15%;">Nomer Depan</th>
                        <th style="width: 15%;">Durasi</th>
                        <th style="width: 15%;">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $i=1;foreach ($biayas as $biaya ) { ?>
                            <tr>
                                <td> 
                                    <a href="<?php echo $this->pathFor('telpbiaya-edit', ['id' => $biaya->id]); ?>" data-toggle="tooltip"   data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                                    <a href="<?php echo $this->pathFor('telpbiaya-delete', ['id' => $biaya->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                                </td>
                               <td><?php echo $biaya->nodepan; ?></td>
                               <td><?php echo $this->convert($biaya->durasi); ?></td>
                               <td><?php echo $this->convert($biaya->harga); ?></td>
                            </tr> 
                    <?php $i++; } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
    <!-- /.modal -->
    <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">Setup Folder dat</h4>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="recipient-name" class="control-label">Folder dat:</label>
                <input type="text" class="form-control" id="datfol">
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="submit" id="simpan-setupfol" class="btn btn-success waves-effect waves-light">Simpan</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Button trigger modal -->
<script type="text/javascript">
    $(function(){

    var editSetupFol = $('#setup-fol');
    var saveSetupFol = $('#simpan-setupfol');

    editSetupFol.on('click',function(){
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->pathFor('telp-setup'); ?>',
            success: function(data){
                $("#responsive-modal").modal("show");
                    $("#datfol").val(data);
            },
            error: function(){
                alert("Gagal Maning")
            }
        });
    });

    saveSetupFol.on('click',function(){
        var datfol = $('#datfol')

        var datanya = {
            datfol: datfol.val()
        }


        if (datfol.val() != "") {
            $.ajax({
                type: 'POST',
                url: "<?php echo $this->pathFor('telp-setup'); ?>",
                data: datanya,
                success: function(data){
                    $('#responsive-modal').modal('hide');
                    console.log(data);
                },
                error: function(error){
                    console.log('Eror');
                }
            });
        }else{
            console.log("Oops!","Folder dat harus diisi","error");
        }
    });

});
</script>



