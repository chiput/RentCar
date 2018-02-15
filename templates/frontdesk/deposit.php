<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Deposit',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Frontdesk',
    'submain_location' => 'Deposit'
  ]);


?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Frontdesk </h3>
            <p class="text-muted m-b-30">Deposit</p>
            <p>
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal" >Deposit Baru</a>
                <a href="<?=$this->pathFor('frontdesk-reservation')?>" class="btn btn-success" >Kembali</a>
            </p>
            <?php
                function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
            ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>

                        </th>
                        <th>Tanggal</th>
                        <th>No. Bukti</th>
                        <th>Nominal</th>
                        <th>Jenis</th>
                        <th>Bank</th>
                        <th>No. Kartu & Masa Berlaku</th>
                        <th>Keterangan</th>
                        <th>User</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($deposits as $deposit){ ?>
                    <tr>
                        <td>
                            <a href="<?=$this->pathFor('frontdesk-deposit-delete', ['id' => $deposit->id])?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                            <a href="<?php echo $this->pathFor('frontdesk-deposit-kwitansi', ['id' => $deposit->id], ['reservations_id' => $deposit->reservations_id] ); ?>" data-toggle="tooltip" data-original-title="Cetak"> <i class="glyphicon glyphicon-print text-inverse"></i> </a>
                        </td>
                        <td><?=convert_date($deposit->tanggal)?></td>
                        <td><?=$deposit->nobukti?></td>
                        <td><?=$this->convert($deposit->nominal)?></td>
                        <td><?=$deposit->type?></td>
                        <td><?=($deposit->type=="BANK"?$deposit->bank->name:"")?></td>
                        <td><?=($deposit->type=="KARTU KREDIT"?$deposit->creditcard." / ".convert_date($deposit->creditcarddate):"")?></td>
                        <td><?=$deposit->keterangan?></td>
                        <td><?=@$deposit->user->name?></td>
                        <td><?=convert_date(substr($deposit->created_at,0,10))." ". substr($deposit->created_at,10,18)?></td>
                    </tr>
                    <?php } ?>
                <tbody>
            </table>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <form class="form-horizontal" method="POST">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myModalLabel">Detail Deposit</h4>
      </div>
      <div class="modal-body">
            <input type="hidden" value="<?=$reservation->id?>" name="reservations_id">
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> No Bukti</span></label>
                <div class="col-md-12">
                  <input type="text" class="form-control" name="nobukti" value="<?= $NoBukti?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Tanggal</span></label>
                <div class="col-md-12">
                  <input type="text" data-date-format="dd-mm-yyyy" class="form-control mydatepicker" value="<?=convert_date(date("Y-m-d"))?>" name="tanggal">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Nominal</span></label>
                <div class="col-md-12">
                  <input type="text" class="form-control" id="nominal" value="0" name="nominal">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Keterangan</span></label>
                <div class="col-md-12">
                  <textarea  class="form-control" name="keterangan"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Metode</span></label>
                <div class="col-md-12">
                    <select class="form-control" value="<?=date("Y-m-d")?>" name="type">
                        <option value="TUNAI">TUNAI</option>
                        <!-- <option value="BANK">BANK</option>
                        <option value="KARTU KREDIT">KARTU KREDIT</option> -->
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 hidden">
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Bank</span></label>
                        <div class="col-md-12">
                            <select  class="form-control" name="banks_id">
                                <?php foreach($banks as $bank){ ?>
                                <option value="<?=$bank->id?>"><?=$bank->name?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 hidden">
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Jenis Kartu Kredit</span></label>
                        <div class="col-md-12">
                            <select name="jeniskartukredit" class="form-control">
                            <option value="0">---</option>
                            <?php foreach ($creditcards as $card) : ?>
                            <option value="<?php echo $card->id ?>" <?php if (isset($reservation) && $card->id == $reservation->creditcard_id) { echo "selected"; } ?>><?php echo $card->name ?></option>
                            <?php endforeach; ?>
                        </select>
                        </div>
                    </div>
                    <div class="form-group hidden">
                        <label class="col-md-12"> <span class="help"> No. Kartu Kredit</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?=$reservation->creditcard?>" name="creditcard">
                        </div>
                    </div>    
                    <div class="form-group hidden">
                        <label class="col-md-12"> <span class="help"> Masa Berlaku</span></label>
                        <div class="col-md-12">
                            <input type="text" data-date-format="dd-mm-yyyy" class="form-control mydatepicker"  value="<?=convert_date($reservation->creditcarddate)?>" name="creditcarddate">
                        </div>
                    </div>    
                </div>
            </div>
            
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success waves-effect">Simpan</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
  </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var format = new curFormatter();
        format.input('#nominal');
    });
</script>