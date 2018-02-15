<?php 
  $this->layout('layouts/main', [
    // app profile

    'title' => 'Data Status Meja',

    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Restoran',

    'submain_location' => 'Status Meja'

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
            <h3 class="box-title m-b-0">Status Meja</h3>

            <p class="text-muted m-b-5">Data Status Meja</p>
            <br/>
  

            <table class="table table-striped myDataTable">
              <thead>
                    <tr>
                       
                        <th style="width: 10%;"></th>

                      <!--   <th style="width: 6%;">No</th> -->
                        <th style="width: 15%;">Kode</th>
                        <th style="width: 15%;">Kapasitas</th>
                        <th>Keterangan</th>
                       
                        <th style="width: 15%;">Status Meja</th>

                        
                        
                    </tr>
                </thead>
                <tbody>

                        <?php 
                        $i=1;
                        foreach ($Resmejas as $meja ) {
                           
                         ?>
                    <tr>
                        <td> 
                             <a href="<?php if(@$meja->cetak!=null){ echo $this->pathFor('kasir',['id'=>$meja->id,'idmeja'=>$meja->id]);}else{echo $this->pathFor("pesanan-add",['idmeja'=>$meja->id]);}?>" class="btn btn-primary" >Opsi</a>
                            
                        </td>
                      <!--   -->
                       <td><?php echo $meja->kode; ?></td>
                       <td><?php echo $meja->orang; ?></td>
                       <td><?php echo $meja->keterangan; ?></td>
                     
                       <td><?php 
                       if(@$meja->aktif=='0')
                       {echo "Rusak";}
                       else if($meja->aktif=='1')
                        { if(@$meja->cetak==null||@$meja->cetak=='1') 
                            {echo "Tidak Terpesan";}
                            else
                            {echo "Terpesan";}
                        } ?></td>
                      
                    </tr> 
                    

                    <?php $i++; } ?>


                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="cetak-modal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; padding-right: 17px;" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Nota transaksi cetak atau Tidak ?</h4>
      </div>
     <!--  <div class="modal-body">
       
      </div> -->
       <div class="modal-footer">
       <!--  <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tidak</button> -->
       <a href="<?=$this->pathFor('kasir-change',['id'=>@$statuscetak])?>"> <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tidak</button></a>
        <a href="<?=$this->pathFor('restoran-cetakkasir-report',['id'=>@$statuscetak])?>"><button type="button" class="btn btn-danger waves-effect waves-light">Cetak</button></a>
      </div> 
    </div>
  </div>
</div>
<script type="text/javascript">

<?php if (@$statuscetak){ ?> 
 $(document).ready(function(){
$('#cetak-modal').modal('show');

//$('#cetak-modal').css('display', 'block');

 }); 
<?php } ?>
</script>


