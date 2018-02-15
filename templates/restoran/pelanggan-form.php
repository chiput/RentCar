<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Tambah Pelanggan',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Restoran',
    'submain_location' => 'Pelanggan'
  ]);

?>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
         <?php if ($this->getSessionFlash('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $this->getSessionFlash('success'); ?>
        </div>
        <?php endif; ?>

         <?php if ($this->getSessionFlash('error_messages')): ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <ul>
              <?php
                foreach($this->getSessionFlash('error_messages') as $key => $error) {
                ?>
                <li><?php echo $error; ?></li>
                <?php
                }
              ?>
              </ul>
            
        </div>
        <?php endif; ?>    
            <h3 class="box-title m-b-0">Form Pelanggan </h3>
            <p class="text-muted m-b-30"></p>
            <form class="form-horizontal" action="<?php echo $this->pathFor('pelanggan-save'); ?>" method="post">
            <input type="hidden" class="form-control" value="<?php echo @$pelanggan->id ?>" name="id">

                <div class="col-md-6">

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Kode Pelanggan</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$pelanggan->kode_pelanggan;?>" name="kode_pelanggan">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Nama Pelanggan</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php  echo @$pelanggan->nama;?>" name="nama_pelanggan">
                        </div>
                    </div>

                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help">Telpon</span></label>
                        <div class="col-md-12">
                            <input type="text" onchange="IsNumber(this.value,this.id)" class="form-control" value="<?php echo @$pelanggan->telepon;?>" name="telpon">
                        </div>
                    </div>

                </div>

                    <div class="form-group m-b-0">
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
                          <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('pelanggan')?>">Batal</a>
                        </div>
                    </div>    
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){


      $('#myTable').DataTable();
      $(document).ready(function() {
        var table = $('#example').DataTable({
          "columnDefs": [
          { "visible": false, "targets": 2 }
          ],
          "order": [[ 2, 'asc' ]],
          "displayLength": 25,
          "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;

            api.column(2, {page:'current'} ).data().each( function ( group, i ) {
              if ( last !== group ) {
                $(rows).eq( i ).before(
                  '<tr class="group"><td colspan="5">'+group+'</td></tr>'
                  );

                last = group;
              }
            } );
          }
        } );

    // Order by the grouping
    $('#example tbody').on( 'click', 'tr.group', function () {
      var currentOrder = table.order()[0];
      if ( currentOrder[0] === 2 && currentOrder[1] === 'asc' ) {
        table.order( [ 2, 'desc' ] ).draw();
      }
      else {
        table.order( [ 2, 'asc' ] ).draw();
      }
    } );
  } );



    });



  </script>
<script>

</script>
