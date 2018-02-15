<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Arrival Guest',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Frontdesk',
    'submain_location' => 'Guest'
  ]);

?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Arival Guest</h3>
            <p class="text-muted m-b-30">Data Arival Guest</p>
            <?php
                function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
            ?>
             <form class="form-horizontal" method="POST">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-md-3 control-label"> <span class="help"> Tanggal</span></label>
                            <div class="col-md-9">
                                <input type="text" data-date-format="dd-mm-yyyy" class="form-control mydatepicker" value="<?php echo convert_date(@$tanggal) ?>" name="date">
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
                        <th>No. Kamar</th>
                        <th>Jenis Kamar</th>
                        <th>Gedung</th>
                        <th>Remarks</th>
                        <th>Nama</th>
                        <th>Negara</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1;
                    foreach ($arrivals as $guest):  ?>
                   <tr>
                        <td><?php echo $guest->number; ?></td>
                        <td><?php echo $guest->type; ?></td>
                        <td><?php echo $guest->building; ?></td>
                        <td><?php echo $guest->remarks; ?></td>
                        <td><?=$guest->name?></td>
                        <td><?= $guest->country?></td>
                        <td><?php if($guest->checkin_at != NULL){ 
                                    echo '<span class="label label-info label-rounded">CHECKIN</span>';
                                  } else {
                                    echo '<span class="label label-success label-rounded">RESERVASI</span>';
                                  }?></td>
                    </tr>
                    <?php $i++;endforeach; ?>
                <tbody>
            </table>
            <div class="row" style="margin-top: 5px; margin-left: 3px;">
                <div class="col-md-1">
                    <div class="form-group">
                        <a href=" <?php echo $this->pathFor('report-arrival-departure',['id' => 1,'date' => $tanggal])?>" class="btn btn-default btn-rounded waves-effect waves-light"><span class="btn-label"><i class="fa fa-print"></i></span>Print</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>