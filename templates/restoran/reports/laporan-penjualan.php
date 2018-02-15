<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Restoran Laporan Penjualan',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Restorant',
    'submain_location' => 'Laporan Penjualan'
  ]);
  function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Laporan Penjualan</h3>
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
			                  foreach($Menu_kategoris as $Menu_kategori){
			                    if(@$kategori==$Menu_kategori->id){
			                        $selected="selected='selected'";
			                    }else{
			                           $selected="";
			                    }

			                    ?>

			                  <option value="<?=$Menu_kategori->id;?>" <?=$selected;?> ><?=$Menu_kategori->nama;?></option>
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
                        <th>Nama Menu</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Harga Total</th>
                        <th>User</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1;$total=0;$diskon=0;
                    foreach ($menus as $menu):  ?>
                    <?php $total += ($menu->total*$menu->hargajual);$diskon += $menu->diskon;?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $menu->nama?></td>
                        <td><?= $menu->total?></td>
                        <td><?= 'Rp. '.$this->convert($menu->hargajual)?></td>
                        <td><?php echo 'Rp. '.$this->convert($menu->total*$menu->hargajual,0)?></td>
                        <td><?= $menu->user->name?></td>
                    </tr>
                    <?php endforeach; ?>

                    <!-- Perulangan menu tambahan-->
                    <?php foreach ($services as $menu):  ?>
                    <?php if(!is_numeric($menu->menuid)){
                        $hargasatuan = $menu->harga/$menu->totalqty;
                        $total += $menu->harga;
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $menu->menuid?></td>
                        <td><?= $menu->totalqty?></td>
                        <td><?= 'Rp. '.$this->convert($hargasatuan)?></td>
                        <td><?php echo 'Rp. '.$this->convert($menu->harga)?></td>
                        <td><?= $menu->user->name?></td>
                    </tr>
                    <?php } $i++;endforeach; ?>
                    <!-- end perulangan menu tambahan -->
                <tbody>
            </table>
            <b>Total Diskon: <?php echo 'Rp. '.$this->convert($diskon); ?></b><br/>
            <b>Total Penjualan: <?php echo 'Rp. '.$this->convert($total); ?></b><br/>
            <b>Total: <?php echo 'Rp. '.$this->convert($total-$diskon); ?></b>
            <div class="row" style="margin-top: 5px; margin-left: 3px;">
                <div class="col-md-1">
                    <div class="form-group">
                    <?php if(isset($resto)){
                    if($resto=='wh'){ ?>
                    <a href=" <?php echo $this->pathFor('laporan-penjualan-report-print-wh',['id' => $kategori, 'date' => $tanggal])?>" class="btn btn-default btn-rounded waves-effect waves-light"><span class="btn-label"><i class="fa fa-print"></i></span>Print</a>
                    <?php } if($resto=='ri'){ ?>
                    <a href=" <?php echo $this->pathFor('laporan-penjualan-report-print-ri',['id' => $kategori, 'date' => $tanggal])?>" class="btn btn-default btn-rounded waves-effect waves-light"><span class="btn-label"><i class="fa fa-print"></i></span>Print</a>
                    <?php } } else { ?>
                    <a href=" <?php echo $this->pathFor('laporan-penjualan-report-print',['id' => $kategori, 'date' => $tanggal])?>" class="btn btn-default btn-rounded waves-effect waves-light"><span class="btn-label"><i class="fa fa-print"></i></span>Print</a>
                    <?php } ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>