<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar Billing Telepon',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Management',
    'submain_location' => 'Billing Telepon'
  ]); 
?>

<?php if ($this->getSessionFlash('success')): ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('success'); ?>
</div>
<?php endif; ?>


<?php



 ?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Billing Telepon</h3>
            <p class="text-muted m-b-30">Data Billing Telepon</p>
                        
            <table id="billing" class="table table-striped myDataTable">
              <thead>
                    <tr>
                        <th>No</th>
                        <th>Room Id</th>
                        <th>Biaya</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Nomor Telepon</th>
                        <th>Durasi</th>
                    </tr>
                </thead>
                <tbody id="billing-body">
                    <?php $i=1;foreach ($bill as $bill) { ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?php echo $bill->roomid; ?></td>
                                <td><?php echo $bill->biaya; ?></td>
                                <td><?php echo $bill->tanggal; ?></td>
                                <td><?php echo $bill->jam; ?></td>
                                <td><?php echo $bill->notelp; ?></td>
                                <td><?php echo $bill->durasi; ?></td>
                            </tr> 
                    <?php $i++; } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
// $(function(){

//     var search = $('#search-billing');
//     var refresh = $('#refresh-billing');

//     var table = $('#billing').DataTable({
//         "ajax":'<?php echo $this->pathFor('telp-billing'); ?>',
//         "paging": true,
//         "lengthChange": false,
//         "ordering": true,
//         "info": true,
//         "autoWidth": true
//     });

//     table.destroy();

//     refresh.on('click',function(){
//         table.ajax.reload();
//     });

//     setInterval(function(){
//         table.ajax.reload();
//     },900000);

//     search.keyup(function() {
//         table.search($(this).val()).draw();
//     });

// });

$(document).ready(function(){

  $.get('<?php echo $this->pathFor('telp-billing'); ?>', function(data) {
    console.log('sukses');
  });

});

function load(){
  $.get('<?php echo $this->pathFor('telp-billing'); ?>', function(data) {
    console.log('sukses');
  })};

$(function(){
  setInterval("load()",900000);
});
</script>
