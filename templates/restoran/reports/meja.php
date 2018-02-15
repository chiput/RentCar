<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Meja',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Laporan',
    'submain_location' => 'Meja'
  ]); 
?>
<?php
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
            <h3 class="box-title m-b-0">Meja</h3>
            <p class="text-muted m-b-30">Daftar Meja</p>
                <form class="form" method="POST">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-daterange input-group" id="date-range" data-date-format="dd-mm-yyyy">
                                <input  type="text" class="form-control" name="start" value="<?=$d_start?>" >
                                <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                                <input type="text" class="form-control" name="end" value="<?=$d_end?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="form-control btn btn-info">Filter</button>
                        </div>
                    </div>
                </form>
                <br/><br/>
                <table class="table table-striped myDataTable table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. Meja</th>
                            <th>Kuantitas</th>
                            <th>Pax</th>
                            <th>Penjualan</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $no=1; foreach ($kinerja as  $waiter): ?>
                        <tr id="trow-<?php echo $waiter->id; ?>">
                            <td><?php echo $no; ?>.</td>
                            <td><?php echo $waiter->meja; ?></td>
                            <td><?php echo $waiter->kuantitas; ?></td>
                            <td><?php echo $waiter->pax; ?></td>
                            <td><?php echo $waiter->total; ?></td>
                        </tr>
                    <?php $no++; endforeach; ?>
                    </tbody>                           
                </table>

                <div class="row" style="margin-top: 5px; margin-left: 3px;">
                    <div class="col-md-1">
                        <div class="form-group">
                            <a href=" <?php echo $this->pathFor('meja-report-print',['start' => $d_start,'end' => $d_end])?>" class="btn btn-default btn-rounded waves-effect waves-light"><span class="btn-label"><i class="fa fa-print"></i></span>Print</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

