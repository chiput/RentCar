<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Store Laporan Penjualan',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Store',
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
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Harga Total</th>
                        <th>User</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1;$total=0;$diskon=0;
                    foreach ($datas as $data):  ?>
                    <?php $total += ($data->total*$data->store->harga);$diskon += $data->diskon;?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $data->barang->nama?></td>
                        <td><?= $data->total?></td>
                        <td><?php echo 'Rp. '.$this->convert($data->store->harga)?></td>
                        <td><?php echo 'Rp. '.$this->convert($data->total*$data->store->harga)?></td>
                        <td><?= $data->user->name?></td>
                    </tr>
                    <?php $i++;endforeach; ?>
                <tbody>
            </table>
            <b>Total Diskon: <?php echo 'Rp. '.$this->convert($diskon); ?></b><br/>
            <b>Total Penjualan: <?php echo 'Rp. '.$this->convert($total); ?></b><br/>
            <b>Total: <?php echo 'Rp. '.$this->convert($total-$diskon); ?></b>
            <div class="row" style="margin-top: 5px; margin-left: 3px;">
                <div class="col-md-1">
                    <div class="form-group">
                        <a href=" <?php echo $this->pathFor('store-laporan-penjualan-print',['date' => $tanggal])?>" class="btn btn-default btn-rounded waves-effect waves-light"><span class="btn-label"><i class="fa fa-print"></i></span>Print</a> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>