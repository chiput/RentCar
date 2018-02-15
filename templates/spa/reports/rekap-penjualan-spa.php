<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Spa Rekap Penjualan',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Spa',
    'submain_location' => 'Report'
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
            <h3 class="box-title m-b-0">Laporan Rekap Penjualan SPA</h3>
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
                        <th>No. Bukti</th>
                        <th>No. Kamar</th>
                        <th>Cash</th>
                        <th>Sign</th>
                        <th>Credit Card</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; $totalpenjualan=0;
                    foreach ($layanan as $layanan):  ?>
                    <?php $totalpenjualan += ($layanan->tunai + $layanan->totalkamar + $layanan->kartubayar); ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $layanan->nobukti?></td>
                        <td><?php 
                        if(isset($layanan->checkinid)){ 
                            if($layanan->checkinid=='-'){ 
                                echo '-';
                            } else { 
                                echo $layanan->reservationdetail->room->number;
                            }
                        } else { 
                            echo '-'; 
                        }?></td>
                        <td><?php if($layanan->tunai > 0){ echo 'Rp. '.$this->convert($layanan->tunai); } else { echo '-'; }?></td>
                        <td><?php if($layanan->totalkamar > 0){ echo 'Rp. '.$this->convert($layanan->totalkamar);} else { echo '-'; }?></td>
                        <td><?php if($layanan->kartubayar > 0){ echo 'Rp. '.$this->convert($layanan->kartubayar);} else { echo '-';}?></td>
                        <td>-</td>
                    </tr>
                    <?php $i++;endforeach; ?>
                <tbody>
            </table>
            <b>Total Penjualan: <?php echo 'Rp. '.$this->convert($totalpenjualan); ?></b>
            <form class="form-horizontal" method="POST" action="<?= $this->pathFor('spa-report-rekap-penjualan-print'); ?>">
                <input style="display: none;" type="text" data-date-format="dd-mm-yyyy" class="form-control mydatepicker" value="<?php echo @$tanggal ?>" name="date">
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <button class="btn btn-default btn-rounded waves-effect waves-light"><span class="btn-label"><i class="fa fa-print"></i></span>Print</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>