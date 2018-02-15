<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Cetak Barcode Barang',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    
  ]); 
  //echo($purReq->details);
?>


<?php if (@$errors!=""): ?>
<div class="row">
    <div class="alert alert-danger alert-dismissable col-sm-12">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php foreach($errors as $error){
            echo $error."<br>";
        } ?>
    </div>
</div>
<?php endif; ?>

<div class="row" id="logistic-barcode-app">
    <div class="col-sm-12">
      <div class="white-box">
        <h3 class="box-title m-b-0">Form Cetak Barcode Barang</h3>
        <p class="text-muted m-b-20 font-13"> </p>
        <form class="form-horizontal" target="_blank" method="POST">
        <div class="col-sm-12">

            <table class="table" id="tabledetail">
                <thead>
                    <tr>
                        <th></th>
                        <th>Kode</th>
                        <th>Nama</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#goods-modal" data-original-title="Tambah"> <i class="fa fa-plus-circle"></i> </a>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Tipe Barcode : </span></label>
                    <div class="col-md-6">
                        <select name="type" class="form-control select2">
                        <?php foreach($types as $type=>$code){ ?>
                            <option value="<?=$code?>"><?=$type?></option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success waves-effect waves-light">Generate</button>
                    </div>
                </div>                
            </div>

            
        </div>
        
        
                    
        <div class="form-group m-b-0">
            
        </div>
            
        </form>
      </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;" id="goods-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="">Daftar Barang</h4>
            </div>
            <div class="modal-body">
                <table class="table myDataTable">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($goods as $good){ ?>
                        <tr>
                            <td><a href="javascript:void(0)" data-id="<?=$good->id?>" data-nama="<?=$good->nama?>" data-kode="<?=$good->kode?>" data-dismiss="modal"><?=$good->kode?></a></td>
                            <td><?=$good->nama?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
            </div> -->
        </div>
    </div>
    <!-- /.modal-content -->
</div>
    <!-- /.modal-dialog -->
<script type="text/javascript">
 

</script>