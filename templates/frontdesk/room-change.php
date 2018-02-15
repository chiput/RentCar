<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Pindah Kamar',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Frontdesk',
    'submain_location' => 'Pindah Kamar'
  ]);

//print_r($reservations);
?>

<?php if ($this->getSessionFlash('success')): ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('success'); ?>
</div>
<?php endif; ?>
<?php if ($this->getSessionFlash('error')): ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $this->getSessionFlash('error'); ?>
        </div>
<?php endif;

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
            <h3 class="box-title m-b-0">Pindah Kamar</h3>
            <p class="text-muted m-b-30">Data Pindah Kamar</p>
            <p>
                <a href="<?php echo $this->pathFor('frontdesk-roomchange-form'); ?>" class="btn btn-primary">Tambah Pindah Kamar</a>
            </p>
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>No Reservasi</th>
                        <th>Nama Tamu</th>
                        <th>Tanggal</th>
                        <th>Kamar Lama</th>
                        <th>Harga</th>
                        <th>Kamar Baru</th>
                        <th>Harga</th>
                        <th>Keterangan</th>
                        <th>User</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($roomChanges as $item){ 
                        $room=[];
                        foreach ($item->details as $detail) {
                            $room[]=(object)[
                                "checkin_code"=>$detail->checkin_code,
                                "rooms_id"=>$detail->rooms_id,
                                "rooms_number"=>@$detail->room->number,
                                "price"=>$detail->price,
                                "guest_name"=>$detail->reservation->guest->name,
                                "change_code"=>$detail->change_code,
                            ];
                        }
                        //print_r($room);
                    ?>
                    <tr>
                        <td class="text-nowrap">
                            <!-- <a href="<?=$this->pathFor('accounting-headers-update',["id"=>$header->id])?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>  -->
                            <a href="<?=$this->pathFor('frontdesk-roomchange-delete',["id"=>$item->id])?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>
                        </td>
                        <td><?=@$room[0]->checkin_code?></td>
                        <td><?=@$room[0]->guest_name?></td>
                        <td><?=convert_date(@$item->date)?></td>
                        <td><?=(@$room[0]->change_code==1?@$room[0]->rooms_number:@$room[1]->rooms_number)?></td>
                        <td><?=(@$room[0]->change_code==1?@$this->convert($room[1]->price):@$this->convert($room[1]->price))?></td>
                        <td><?=(@$room[0]->change_code==2?@$room[0]->rooms_number:@$room[1]->rooms_number)?></td>
                        <td><?=(@$room[0]->change_code==1?@$this->convert($room[1]->price):@$this->convert($room[1]->price))?></td>
                        <td><?=@$item->remark?></td>
                        <td><?=@$item->user->name?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

        </div>
    </div>
</div>