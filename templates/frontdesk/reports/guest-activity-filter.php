<?php
    $dataLayout  = [
      // app profile
      'title' => 'Laporan Aktivitas Tamu',
      'app_name' => $app_profile['name'],
      'author' => $app_profile['author'],
      'description' => $app_profile['description'],
      'developer' => $app_profile['developer'],
      // breadcrumb
      'main_location' => 'FrontDesk',
      'submain_location' => 'Laporan Aktivitas Tamu'
  ];

  if (isset($customDataLyout)) {
      $dataLayout = array_merge($dataLayout, $customDataLyout);
  }

  $this->layout('layouts/main', $dataLayout);
?>

<div class="error">
    <?php print_r(@$errors) ?>
</div>

<div class="row">
    <div class="col-sm-12">
      <div class="white-box">

        <h3 class="box-title m-b-0">Laporan Aktivitas Tamu</h3>
        <p class="text-muted m-b-20 font-13"> </p>
        <form class="form-horizontal" action="<?php echo $submit_form ?>" method="POST" target="_blank">

            <div class="form-group">
                <label class="col-md-12">
                    <span class="help"> Tanggal Laporan </span>
                </label>
                <div class="col-md-6">
                <div class="input-daterange input-group" id="date-range" data-date-format="dd-mm-yyyy">

                        <input  type="text" class="form-control" name="start" value="<?="01".date("-m-Y")?>" />
                    <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                        <input type="text" class="form-control" name="end"
                        value="<?=date("t-m-Y")?>" />
                </div>
                </div>
            </div>

        <div class="form-group m-b-0">
            <div class="col-md-12">
                <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Tampilkan</button>
            </div>
        </div>

        </form>
      </div>
    </div>
</div>
