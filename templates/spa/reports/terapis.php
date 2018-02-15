<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Terapis',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Laporan',
    'submain_location' => 'Terapis'
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
            <h3 class="box-title m-b-0">Laporan Terapis</h3>
            <p class="text-muted m-b-30"></p>
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#nocheckout" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs">Data Kinerja Terapis</span></a></li>
              <li role="presentation" class=""><a href="#checkedout" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Data Terapis</span></a></li>
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="nocheckout">
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
                                <th>Nama Terapis</th>
                                <th>Kuantitas</th>
                                <th>Penjualan</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; foreach ($kinerjaterapis as  $kinerja): ?>
                            <tr id="trow-<?php echo $kinerja->id; ?>">
                                <td><?php echo $no; ?>.</td>
                                <td><?php echo @$kinerja->terapis->nama; ?></td>
                                <td><?php echo $kinerja->kuantitas; ?></td>
                                <td><?php echo $this->convert($kinerja->harga); ?></td>
                            </tr>
                        <?php $no++; endforeach; ?>
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
                <div role="tabpanel" class="tab-pane" id="checkedout">
                    <table class="table table-striped myDataTable table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; foreach ($terapis as  $terapis): ?>
                            <tr id="trow-<?php echo $terapis->id; ?>">
                                <td><?php echo $no; ?>.</td>
                                <td><?php echo $terapis->nama; ?></td>
                                <td><?php echo $terapis->alamat; ?></td>
                                <td><?php echo $terapis->telepon; ?></td>
                            </tr>
                        <?php $no++; endforeach; ?>
                        </tbody>                           
                    </table>

                    <div class="row" style="margin-top: 5px; margin-left: 3px;">
                        <div class="col-md-1">
                            <div class="form-group">
                                <a href=" <?php echo $this->pathFor('terapis-report-print')?>" class="btn btn-default btn-rounded waves-effect waves-light"><span class="btn-label"><i class="fa fa-print"></i></span>Print</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

