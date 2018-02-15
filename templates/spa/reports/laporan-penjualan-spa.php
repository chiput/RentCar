<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Spa Laporan Penjualan',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Spa',
    'submain_location' => 'Report'
  ]);

?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Laporan Penjualan SPA </h3>
            <p class="text-muted m-b-30"></p>
             <form class="form-horizontal" method="POST">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-md-3 control-label"> <span class="help"> Tanggal</span></label>
                            <div class="col-md-9">
                                <input type="text" data-date-format="dd-mm-yyyy" class="form-control mydatepicker" value="<?php echo @$tanggal ?>" name="date">
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
			            <label class="col-md-3 control-label"> <span class="help"> Kategori</span></label>
			            <div class="col-md-9">
			              <select  class="form-control" name='kategoriid'  id='kategoriid'>
			                  <option value="0">Pilih Kategori</option>
			                  <?php
			                  foreach($layanan_kategori as $layanan_kategori){
			                    if(@$kategori==$layanan_kategori->id){
			                        $selected="selected='selected'";
			                    }else{
			                           $selected="";
			                    }

			                    ?>

			                  <option value="<?=$layanan_kategori->id;?>" <?=$selected;?> ><?=$layanan_kategori->nama;?></option>
			                  <?php } ?>
			              </select>


			            </div>
			        </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <button class="form-control btn btn-info">Filter</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="white-box">
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Layanan</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Diskon</th>
                        <th>Harga Total</th>
                        <th>User</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1;$total=0;$discon=0;
                    foreach ($layanan as $layanan):  ?>
                    <?php $total += ($layanan->total*$layanan->hargajual);$discon += $layanan->total*($layanan->hargajual*$layanan->diskon/100);?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $layanan->nama_layanan?></td>
                        <td><?= $layanan->total?></td>
                        <td><?php echo $this->convert($layanan->hargajual)?></td>
                        <td><?= $this->convert($layanan->total*($layanan->hargajual*$layanan->diskon/100))?></td>
                        <td><?php echo $this->convert($layanan->total*($layanan->hargajual-($layanan->hargajual*$layanan->diskon/100)))?></td>
                        <td><?= $layanan->user->name?></td>
                    </tr>
                    <?php $i++;endforeach; ?>
                <tbody>
            </table>
            <b>Total Diskon: <?php echo 'Rp. '.$this->convert($discon); ?></b><br/>
            <b>Total Penjualan: <?php echo 'Rp. '.$this->convert($total); ?></b><br/>
            <b>Total: <?php echo 'Rp. '.$this->convert($total-$discon); ?></b>
            <div class="row" style="margin-top: 5px; margin-left: 3px;">
                <div class="col-md-1">
                    <div class="form-group">
                        <a href=" <?php echo $this->pathFor('laporan-penjualan-spa-report-print',['id' => $kategori, 'date' => $tanggal])?>" class="btn btn-default btn-rounded waves-effect waves-light"><span class="btn-label"><i class="fa fa-print"></i></span>Print</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>