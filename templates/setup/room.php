<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Mobil',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Setup',
    'submain_location' => 'Daftar Mobil'
  ]); 

    $activeStatus = [
        'Tidak Aktif',
        'Aktif'
    ];
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
            <h3 class="box-title m-b-0">Mobil </h3>
            <p class="text-muted m-b-30">Data Mobil</p>
            <p class="text-muted m-b-20">
                <a href="<?php echo $this->pathFor('setup-room-new'); ?>" class="btn btn-primary">Tambah Mobil</a>
            </p>
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>Plat Nomor</th>
                        <th>Nama Mobil</th>
                        <th>Jenis Mobil</th>
                        <th>Atas Nama</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($rooms as $room): ?>
                    <tr>
                        <td width="100">
                            <a href="<?php echo $this->pathFor('setup-room-update', ['id' => $room->id]); ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-5"></i></a>
                            <a href="<?php echo $this->pathFor('setup-room-delete', ['id' => $room->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-5"></i> </a>
                            <a href="<?php echo $this->pathFor('setup-room-rate', ['room_id' => $room->id]); ?>" data-toggle="tooltip" data-original-title="Harga Mobil"> <i class="fa fa-money m-r-5"></i> </a>
                            <a hidden href="#" onClick="setAgentLink(<?=$room->id?>)" data-toggle="tooltip" data-original-title="Harga Sopir"> <i class="fa fa-user"></i> </a>
                        </td>
                        <td><?php echo $room->level; ?></td>
                        <td><?php echo $room->number; ?></td>
                        <td><?php echo @$room->roomType->name; ?></td>
                        <!-- <td><?php echo $room->currency; ?></td> -->
                        <td><?php echo $room->note; ?></td>
                    </tr>
                <?php endforeach; ?>
                <tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-agent">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pilih Sopir</h4>
            </div>
        <div class="modal-body">
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>Kode</th>
                        <th>Nama</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($agents as $agent) :
                        $link = $this->pathFor('frontdesk-agentrate-form', ['agent_id' => $agent->id, 'room_id' => 'x']);
                    ?>
                    <tr>
                        <td>
                            <a href="<?php echo $link; ?>" class="btn btn-info waves-effect agent-btn">Pilih</a>
                        </td>
                        <td>
                            <?php echo $agent->code ?>
                        </td>
                        <td>
                            <?php echo $agent->name ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <tbody>
            </table>
        </div>
        <div class="modal-footer">
            <!-- <a  class="btn btn-primary" href="<?php echo $this->pathFor('frontdesk-reservation-add'); ?>" target="_blank" >Tambah</a> -->
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    var setAgentLink = function(roomId){
        var links = document.querySelectorAll('.agent-btn');
        [].forEach.call(links,function(link){
            var aHref = link.href.split("/");
            aHref.pop()
            link.href = aHref.join("/")+"/"+roomId;
        });
        $('#modal-agent').modal();
    };
</script>