<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Ulang Tahun Tamu Hari Ini',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Management',
    'submain_location' => 'Ulang Tahun Tamu Hari Ini'
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
            <h3 class="box-title m-b-0">Ulang Tahun Pelanggan </h3>
            <p class="text-muted m-b-30">Data Ulang Tahun Pelanggan</p>
            <form class="form-horizontal" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label"> <span class="help"> Tanggal</span></label>
                            <div class="col-md-9">
                                <div class="input-daterange input-group" id="date-range" data-date-format="dd-mm-yyyy">
                                    <input  type="text" class="form-control" name="start" data-date-format="dd-mm-yyyy" value="<?=$d_start?>" >
                                    <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                                    <input type="text" class="form-control" name="end" data-date-format="dd-mm-yyyy" value="<?=$d_end?>">
                                </div>
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
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                <h3 class="box-title">Daftar Pelanggan</h3>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Negara</th>
                                <th>Email</th>
                                <th>Birthday</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            foreach ($datas as $data) { ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $data->name; ?></td>
                                    <td><?= $data->country->nama; ?></td>
                                    <td><?= $data->email; ?></td>
                                    <td><?= date('d F Y',strtotime($data->date_of_birth))?></td>
                                </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</div>