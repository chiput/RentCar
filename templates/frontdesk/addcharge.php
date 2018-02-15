<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Biaya Tambahan',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Frontdesk',
    'submain_location' => 'Biaya Tambahan'
  ]);

    $activeStatus = [
        'Tidak Aktif',
        'Aktif'
    ];

?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Biaya Tambahan </h3>
            <p class="text-muted m-b-30">Data Biaya Tambahan</p>
            <?php
            function convert_date($date){
                $exp = explode('-', $date);
                if (count($exp)==3) {
                    $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                }
                return $date;
            }
            ?>
            <p>
                <a href="<?php echo $this->pathFor('frontdesk-addcharge-new'); ?>" class="btn btn-primary">Tambah Biaya Tambahan</a>
            </p>
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th>

                        </th>
                        <th>Tanggal</th>
                        <th>No.Bukti</th>
                        <th>Nomor Kamar</th>
                        <th>Item</th>
                        <th>Keterangan</th>
                        <th>User</th>
                        <th>User Edit</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($addcharges as $addcharge): ?>
                    <tr>
                        <td>
                            <a href="<?php echo $this->pathFor('frontdesk-addcharge-update', ['id' => $addcharge->id]); ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                            <a href="<?php echo $this->pathFor('frontdesk-addcharge-delete', ['id' => $addcharge->id]); ?>" data-toggle="tooltip" data-original-title="Delete"> <i class="fa fa-close text-danger"></i> </a>
                        </td>
                        <td><?php echo convert_date($addcharge->tanggal); ?></td>
                        <td><?php echo $addcharge->nobukti; ?></td>
                        <td><?php echo @$addcharge->reservation_detail->room->number; ?> | 
                            <?php echo @$addcharge->reservation_detail->reservation->guest->name; ?>
                        </td>
                        <td>
                            <table class="detail">
                                <thead>
                                    <tr>
                                        <th width="200">Item</th>
                                        <th>Harga & Qty</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                        <?php foreach($addcharge->detail as $item){ ?>
                                <tr>
                                    <td><?=@$item->addchargetype->code?> / <?=@$item->addchargetype->name?></td>
                                    <td><?=$this->convert($item->sell)?> @(<?=$item->qty?>)</td>
                                    <td><?=$this->convert($item->sell*$item->qty)?></td>
                                </tr>
                        <?php } ?>
                                </tbody>
                            </table>
                        </td>
                        <td><?php echo $addcharge->remark; ?></td>
                        <td><?=@$addcharge->user->name?></td>
                        <td><?=@$addcharge->user_edit->name?></td>
                        <!-- <td><?php //echo $this->convert($addcharge->ntotal); ?></td> -->
                    </tr>
                <?php endforeach; ?>
                <tbody>
            </table>
        </div>
    </div>
</div>

<style type="text/css">
    .detail tr{
        background-color: transparent!important;
    }
</style>