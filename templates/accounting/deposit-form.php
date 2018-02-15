<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Laporan Deposit',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Accounting',
    'submain_location' => 'Laporan'
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
            <h3 class="box-title m-b-0">Laporan Deposit</h3>
            <p class="text-muted m-b-30"></p>
             <form class="form-horizontal" method="POST">
                <div class="row">
                 <label class="col-md-12"> 
                    <span class="help"> Tanggal Laporan </span>
                </label>
                    <div class="col-md-4">
                        <div class="input-daterange input-group" id="date-range" data-date-format="dd-mm-yyyy">
                            <input  type="text" class="form-control" name="start" value="<?=$d_start?>" >
                            <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                            <input type="text" class="form-control" name="end" value="<?=$d_end?>">
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
                        <th>No. Reservation</th>
                        <th>Nominal</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1;
                    foreach ($deposits as $depo):  
                        if(isset($depo->reservation->nobukti)){?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $depo->nobukti?></td>
                                <td><?= $depo->reservation->nobukti?></td>
                                <td><?php echo 'Rp.'.$this->convert($depo->nominal);?></td>
                                <td><?= $depo->keterangan?></td>
                            </tr>
                    <?php } 
                    $i++;endforeach; ?>
                <tbody>
            </table>
        </div>
    </div>
</div>