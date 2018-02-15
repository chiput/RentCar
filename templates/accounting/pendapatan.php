<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Laba Rugi - Pendapatan',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Accounting',
    'submain_location' => 'Laba Rugi - Pendapatan'
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

<?php if ($this->getSessionFlash('success')): ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('success'); ?>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Laba Rugi</h3>
            <p class="text-muted m-b-30">Pendapatan</p>
            <ul class="nav customtab nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#co" aria-controls="home1" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs">Checkout</span></a></li>
              <li role="presentation" class=""><a href="#ri" aria-controls="home2" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span><span class="hidden-xs">Restorante Italia</span></a></li>
              <li role="presentation" class=""><a href="#wh" aria-controls="home3" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">White Horse</span></a></li>
              <li role="presentation" class=""><a href="#spa" aria-controls="home4" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-setting"></i></span> <span class="hidden-xs">Spa</span></a></li>
              <li role="presentation" class=""><a href="#tlpn" aria-controls="home5" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Telepon</span></a></li>
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="co">
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
                                <th>No. Bukti</th>
                                <th>Room</th>
                                <th>Restorante Italia</th>
                                <th>White Horse</th>
                                <th>Spa</th>
                                <th>Telepon</th>
                                <th>Biaya Tambahan</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>                           
                    </table>
                    <div class="row" style="margin-top: 5px; margin-left: 3px;">
                        <div class="col-md-1">
                            <div class="form-group">
                                <a href=" <?php echo $this->pathFor('terapis-report-print-kinerja',['start' => $d_start,'end' => $d_end])?>" class="btn btn-default btn-rounded waves-effect waves-light"><span class="btn-label"><i class="fa fa-print"></i></span>Print</a>
                            </div>
                        </div>
                    </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="ri">
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
                                <th>No. Bukti</th>
                                <th>Room</th>
                                <th>Restorante Italia</th>
                                <th>White Horse</th>
                                <th>Spa</th>
                                <th>Telepon</th>
                                <th>Biaya Tamabahan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>                            
                    </table>
                    <div class="row" style="margin-top: 5px; margin-left: 3px;">
                        <div class="col-md-1">
                            <div class="form-group">
                                <a href=" <?php echo $this->pathFor('terapis-report-print-kinerja',['start' => $d_start,'end' => $d_end])?>" class="btn btn-default btn-rounded waves-effect waves-light"><span class="btn-label"><i class="fa fa-print"></i></span>Print</a>
                            </div>
                        </div>
                    </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="wh">
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
                                <th>No. Bukti</th>
                                <th>Room</th>
                                <th>Restorante Italia</th>
                                <th>White Horse</th>
                                <th>Spa</th>
                                <th>Telepon</th>
                                <th>Biaya Tamabahan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>                           
                    </table>
                    <div class="row" style="margin-top: 5px; margin-left: 3px;">
                        <div class="col-md-1">
                            <div class="form-group">
                                <a href=" <?php echo $this->pathFor('terapis-report-print-kinerja',['start' => $d_start,'end' => $d_end])?>" class="btn btn-default btn-rounded waves-effect waves-light"><span class="btn-label"><i class="fa fa-print"></i></span>Print</a>
                            </div>
                        </div>
                    </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="spa">
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
                                <th>No. Bukti</th>
                                <th>Room</th>
                                <th>Restorante Italia</th>
                                <th>White Horse</th>
                                <th>Spa</th>
                                <th>Telepon</th>
                                <th>Biaya Tamabahan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>                            
                    </table>
                    <div class="row" style="margin-top: 5px; margin-left: 3px;">
                        <div class="col-md-1">
                            <div class="form-group">
                                <a href=" <?php echo $this->pathFor('terapis-report-print-kinerja',['start' => $d_start,'end' => $d_end])?>" class="btn btn-default btn-rounded waves-effect waves-light"><span class="btn-label"><i class="fa fa-print"></i></span>Print</a>
                            </div>
                        </div>
                    </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="tlpn">
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
                                <th>No. Bukti</th>
                                <th>Room</th>
                                <th>Restorante Italia</th>
                                <th>White Horse</th>
                                <th>Spa</th>
                                <th>Telepon</th>
                                <th>Biaya Tamabahan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>                            
                    </table>
                    <div class="row" style="margin-top: 5px; margin-left: 3px;">
                        <div class="col-md-1">
                            <div class="form-group">
                                <a href=" <?php echo $this->pathFor('terapis-report-print-kinerja',['start' => $d_start,'end' => $d_end])?>" class="btn btn-default btn-rounded waves-effect waves-light"><span class="btn-label"><i class="fa fa-print"></i></span>Print</a>
                            </div>
                        </div>
                    </div>
              </div>
            </div>
        </div>
    </div>
</div>

