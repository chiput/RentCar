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
        <h3 class="box-title m-b-0">Laporan Riwayat Tamu</h3>
        <p class="text-muted m-b-30"></p>
        <table class="table table-striped myDataTable">
            <thead>
                <tr>
                    <th>

                    </th>
                    <th>Nama</th>
                    <th>Negara</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Black List</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($guests as $guest): ?>
                <tr>
                    <td>
                        <a href="<?=$this->pathFor('frontdesk-report-guest-history-display',['id'=>$guest->id])?>"  target="_blank" data-toggle="tooltip" class="btnDetail" data-original-title="Cetak"><i class="fa fa-print"></i> Cetak</a>
                    </td>
                    <td><?php echo $guest->name; ?></td>
                    <td><?php echo $guest->country->nama; ?></td>
                    <td><?php echo $guest->email; ?></td>
                    <td><?=$guest->phone?></td>
                    <td><?php echo ($guest->is_blacklist==1?"Black List":"") ?></td>
                </tr>
            <?php endforeach; ?>
            <tbody>
        </table>
        
      </div>
    </div>
</div>
