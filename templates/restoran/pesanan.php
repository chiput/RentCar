<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Data Daftar Pesanan',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Restoran',
    'submain_location' => 'Pesanan'
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
            <h3 class="box-title m-b-0">Menu Pesanan</h3>
            <p class="text-muted m-b-5">Daftar Data Pesanan</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('pesanan-add',['idmeja'=>'0']); ?>" class="btn btn-primary">Tambah Pesanan</a></p><br/>
<?php //echo var_dump($respesanans)?>  
            <table class="table table-striped myDataTable">
              <thead>
                    <tr>
                       
                        <th style="width: 6%;"></th>
                        <th style="width: 8%;">Tanggal</th>
                        <th style="width: 8%;">No. Bukti</th>
                        <th style="width: 18%;">Pelanggan/No.Kamar</th>
                        <th style="width: 8%;">Meja</th>
                        <th ">Keterangan</th>
                        <th style="width: 7%;">Bayar</th>
                        
                        
                        
                    </tr>
                </thead>
    <tbody>
                        <?php 
                        $i=1;
                     foreach ($respesanans as $respesanan ) {
                           
                         ?>
                    <tr>
                        <td style="width: 10%;"> 
                             <a href="<?php  echo $this->pathFor('pesanan-edit', ['id' => $respesanan->id]); ?>" data-toggle="tooltip"   data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-5"></i></a>
                            <a href="<?php echo $this->pathFor('pesanan-delete', ['id' => $respesanan->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>


                             <a href="<?php ?><?php if (@$respesanan->cetak!=1 ){ echo $this->pathFor('kasir', ['id' => $respesanan->mejaid]);}else if(@$respesanan->cetak==2){echo $this->pathFor('restoran-cetakkasir-report-pesanan', ['idpesanan' => $respesanan->id]);}else{echo '#';} ?>" data-toggle="tooltip" data-original-title="Kasir"> <i class="fa fa-credit-card text-info m-r-10"></i> </a>

                             <?php if(@$respesanan->cetak==1 AND  $respesanan->jenispelanggan!='1' and (@$respesanan->nominalBayar>0||@$respesanan->isBAyar!='')){ ?><a href="<?=$this->pathFor('restoran-cetakkasir-report',['id'=>@$respesanan->id_kasir])?>" data-toggle="tooltip" data-original-title="Cetak"><i class="fa fa-print text-info m-r-10"></i></a>
                             <?php } ?>

                        </td>
                       
                       <td><?php echo $respesanan->tanggal; ?> </td>
                       <td><?php echo $respesanan->nobukti; ?></td>
                      
                       <td><?php if ($respesanan->jenispelanggan=='1'){echo $respesanan->roomnama;}else{echo $respesanan->pelanggannama;} //echo //$respesanan->pelangganid; ?></td>
                       <td><?php echo $respesanan->kodemeja; ?></td>
                      
                       <td><?php echo $respesanan->keterangan; ?></td>
                       <td>
                         <div class="checkbox checkbox-success">
                            <input id="active" disabled type="checkbox" value="1" <?php if (@$respesanan->cetak==1 AND(@$respesanan->isBAyar!='-' || $respesanan->jenispelanggan!='1' )){echo 'checked="checked"';}?> name="is_active">
                            <label for="active"></label>
                        </div>
                       </td>
            
                      
                      
                    </tr> 
                    

                    <?php $i++; } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>



