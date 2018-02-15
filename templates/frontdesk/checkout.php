<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Pengembalian - Frontdesk',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Frontdesk',
    'submain_location' => 'Pengembalian'
  ]);

    $activeStatus = [
        'Tidak Aktif',
        'Aktif'
    ];

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
            <h3 class="box-title m-b-0">Pengembalian</h3>
            <p class="text-muted m-b-30">Data Pengembalian</p>
            <p>
                <a href="<?php echo $this->pathFor('frondesk-checkout-add'); ?>" class="btn btn-primary">Tambah Pengembalian</a>
            </p>
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th>
                        </th>
                        <th>Waktu</th>
                        <th>No Pengembalian</th>
                        <th>Pelanggan</th>
                        <th>No Telp</th>
                        <th>User</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($checkouts as $checkout): ?>
                    <tr>
                        <td>
                            <a href="<?php echo $this->pathFor('frondesk-checkout-report-single', ['id' => $checkout->id]); ?>">Report <a class="m-r-10"></a></a>
                            <a href="<?php echo $this->pathFor('frontdesk-checkout-delete', ['id' => $checkout->id]); ?>" data-toggle="tooltip" data-original-title="Hapus" class="delBtn"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                        </td>
                         <td><?php echo convert_date(substr(@$checkout->details->first()->checkout_time,0,10))." ".substr(@$checkout->details->first()->checkout_time,10,18) ?></td>
                        <td><?php echo $checkout->checkout_code ?></td>
                        <td><?php echo @$checkout->guest->name; ?></td>
                        <td><?php echo @$checkout->guest->phone; ?></td>
                        <td><?=@$checkout->user->name?></td>
                    </tr>
                <?php endforeach; ?>
                <tbody>
            </table>
        </div>
    </div>
</div>
