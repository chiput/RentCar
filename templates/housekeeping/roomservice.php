<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Room Service',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    //'main_location' => 'Akunting',
    //'submain_location' => 'Tambah Data Header Account'
  ]);
?>
<?php if ($this->getSessionFlash('success')): ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('success'); ?>
</div>
<?php endif; ?>
<?php
                function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
            ?>
<div class="white-box">
  <h3 class="box-title m-b-0">Jadwal Room Service</h3>
  <p class="text-muted m-b-30">Data Jadwal Room Service</p>
  <form class="form" method="POST" >
      <div class="row">
          <div class="col-md-2">
             <a href="<?php echo $this->pathFor('houskeeping-roomservice-form'); ?>" class="btn btn-primary">Tambah Room Service</a>
             </div>
              <div class="col-md-4">
                      <div class="input-daterange input-group" id="date-range" data-date-format="dd-mm-yyyy">
                              <input  type="text" class="form-control" name="start" value="<?="01".date("-m-Y")?>" />
                          <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                              <input type="text" class="form-control" name="end"
                              value="<?=date("t-m-Y")?>" />
                      </div>
                    </div>
                
                <div class="col-md-2">
                  <button class="form-control btn btn-info">Filter</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="white-box">
            <table class="table table-striped myDataTable table-hover">
  <thead>
    <tr>
      <th></th>
      <th>Tanggal</th>
      <th>Nama Karyawan</th>
      <th>User</th>
      <th>User Edit</th>
    </tr>
  </thead>
<tbody>
<?php foreach ($menus as $menu): ?>
  <tr>
    <td>
        <a href="<?php echo $this->pathFor('houskeeping-roomservice-edit', ['id' => $menu->id]); ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
        <a href="<?php echo $this->pathFor('houskeeping-roomservice-delete', ['id' => $menu->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
        <a href="<?php echo $this->pathFor('housekeeping-report-roomserviceschedule1', ['id' => $menu->id]); ?>" data-toggle="tooltip" data-original-title="Cetak"> <i class="glyphicon glyphicon-print text-inverse"></i> </a>
    </td>
    <td><?php echo convert_date(@$menu->tanggal); ?></td>
    <td><?php echo @$menu->karyawanid; ?></td>
    <td><?=@$menu->user->name?></td>
    <td><?=@$menu->user_edit->name?></td>
  </tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
