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
<?php endif; ?>

<div class="row" id="roomChange">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Form Pindah Kamar</h3>
            <p class="text-muted m-b-30"></p>

            <form class="form-horizontal" action="<?=$this->pathFor("frontdesk-roomchange-save")?>" method="POST">
                <input type="hidden" name="id" value="<?=@$roomChange->id?>">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Tanggal</span></label>
                            <div class="col-md-3">
                                <input type="text" data-date-format="dd-mm-yyyy" class="form-control mydatepicker" value="<?php echo date("d-m-Y") ?>" name="date">
                            </div>
                            <div class="col-md-1">
                                <a href="javascript:void(0)" onclick="reload(this)" class="btn btn-success">Refresh</a>
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="col-md-6">

                        <div class="form-group">
                            <h3 class="box-title m-b-0">Kamar dipakai </h3>
                            <table class="table">
                                <thead> 
                                    <tr>
                                        <th>ID Reservasi</th>
                                        <th>Tanggal Check In</th>
                                        <th>Nama</th>
                                        <th>No Kamar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="room in rooms_booked">
                                        <td><span><input type="radio" name="reservations_detail_rooms_id" value="{{room.rooms_id}}" onclick="getAvail(this)" />{{room.nobukti}}</span></td>
                                        <td>{{room.checkin_at_date}} {{room.checkin_at_time}}</td>
                                        <td>{{room.name}}</td>
                                        <td>{{room.number}}</td>    
                                    </tr>
                                </tbody>
                            </table>
                            <input type="hidden" name="reservations_detail_id" class="form-control" value="{{reservations_detail_id}}" /> 
                            <div class="alert alert-info" style="display: none;" id="alertResv"> Memuat </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <h3 class="box-title m-b-0">Kamar tersedia </h3>
                            <div class="col-md-10" style="margin-left: 283px;">
                            <label>Search :</label>
                            <input type="text" id="search" onkeyup="myFunction()" placeholder=" Cari berdasarkan no.kamar . . .">
                            </div>
                            <table class="table" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Nama Mobil</th>
                                        <th>Tipe</th>    
                                        <th>Harga</th>   
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="room in rooms_avail">
                                        <td><span>
                                        <input type="radio" name="selAvail" value="{{room.id}}" onclick="setRoom(this)"/>{{room.number}}</span></td>
                                        <td>{{room.type_name}}</td>
                                        <td>{{room.pricetampil}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="alert alert-info" style="display: none;" id="alertRoom"> Memuat </div>
                        </div>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Harga Baru</span></label>
                            <div class="col-md-3">
                                <input type="text" name="price" class="form-control" value="{{selAvail.price}}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Keterangan</span></label>
                            <div class="col-md-6">
                                <textarea  class="form-control" name="remark"><?php echo @$roomChange->remark ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-1">
                                <button class="btn btn-success">Proses</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<style type="text/css">
    #search {
      background-repeat: no-repeat;
      width: 50%;
      height: 30px;
      border: 1px solid #ddd;
      margin-bottom: 10px;
    }
    #myTable {
      border-collapse: collapse;
      width: 100%;
      border: 1px solid #ddd;
      /*font-size: 18px;*/
    }

    #myTable th, #myTable td {
      text-align: left;
      padding: 12px;
    }

    #myTable tr {
      border-bottom: 1px solid #ddd;
    }

    #myTable tr.header, #myTable tr:hover {
      background-color: #f1f1f1;
    }
</style>
<script type="text/javascript">
    var room_url='<?=$this->pathFor('frontdesk-reservation'); ?>rooms/'

    function myFunction() {
      var input, filter, table, tr, td, i;
      input = document.getElementById("search");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }       
      }
    }
</script>