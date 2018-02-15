<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Harga Periodik',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Setup',
    'submain_location' => 'Harga Periodik'
  ]); 
?>

<?php if ($this->getSessionFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $this->getSessionFlash('success'); ?>
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
            <h3 class="box-title m-b-0">Harga Periodik </h3>
            <p class="text-muted m-b-30">Data Harga Periodik</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('setup-periodic-rate-new'); ?>" class="btn btn-primary">Tambah Harga Periodik</a></p>
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th>

                        </th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Jenis Kamar</th>
                        <th>Jenis T. Tidur</th>
                        <th>Keterangan</th>
                        <th>Kenaikan</th>   
                        <th>Diskon</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($rates as $rate): ?>
                    <tr>
                        <td>
                            <a href="<?php echo $this->pathFor('setup-periodic-rate-update', ['id' => $rate->id]); ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                            <a href="<?php echo $this->pathFor('setup-periodic-rate-delete', ['id' => $rate->id]); ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>
                        </td>
                        <td><?php echo $rate->name; ?></td>
                        <td><?php echo convert_date($rate->start_date)." / ".convert_date($rate->end_date); ?></td>
                        <td><?php echo @$rate->roomType->name; ?></td>
                        <td><?php echo @$rate->bedType->name; ?></td>
                        <td><?php echo $rate->remark; ?></td>
                        <td><?=$this->convert($rate->markup).($rate->markup_percent=="1"?"%":""); ?></td>
                        <td><?=$this->convert($rate->disc).($rate->disc_percent=="1"?"%":""); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tbody>
            </table>
        </div>
    </div>
</div>