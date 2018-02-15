<?php
  $this->layout('layouts/printkwitansi', [
    // app profile
    'company' => $options,
    'title' => "Bukti Pembayaran",
  ]);

  function convert_date($date){
            $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
            return $date;
        } 
?>

    <h2 class="box-title" style="text-align: center;">.: Bukti Transaksi Reservasi :.</h2>
    <table class="report">
        <thead>
          <tr>
            <th style="border-bottom: none;" width="150">No. Bukti</th>
            <th style="border-bottom: none;">: <?=@$resbooking->nobukti?></th>
          </tr>
        </thead>
        <thead>
          <tr>
            <th style="border-bottom: 1px solid #ddd;">Tanggal Reservasi</th>
            <th style="border-bottom: 1px solid #ddd;">: <?php echo date('d-m-Y', strtotime(@$resbooking->tanggal)) ; ?></th>
          </tr>
        </thead>
      </table>

      <table class="report">
        <thead>
          <tr>
            <th style="border-bottom: none;" width="50"></th>
            <th style="border-bottom: none;" width="150">Atas nama</th>
            <th style="border-bottom: 1px solid #ddd;">: 
              <?php if ($resbooking->pelanggan_id != 0) {
                 echo $resbooking->pelanggan->nama;
                } else {
                  echo $resbooking->reservationdetail->reservation->guest->name;
                } 
              ?>          
            </th>

          </tr>
        </thead>
        <thead>
          <tr>
            <th style="border-bottom: none;"></th>
            <th style="border-bottom: none;">Check In</th>
            <th style="border-bottom: 1px solid #ddd;">: 
              <?php
              echo convert_date(@$resbooking->checkin)." "."||"." ".@$resbooking->jam
              ?>
            </th>
          </tr>
        </thead>
        <thead>
          <tr>
            <th style="border-bottom: none;"></th>
            <th style="border-bottom: none;">Meja</th>
            <th style="border-bottom: 1px solid #ddd;">: 
              <b><?=@$resbooking->meja->kode_meja?></b>
               Kategori
              <b><?=@$resbooking->meja->tipe_meja?></b>
            </th>
          </tr>
        </thead>
        <thead>
          <tr>
            <th style="border-bottom: none;"></th>
            <th style="border-bottom: none;">Untuk Pembayaran</th>
            <th style="border-bottom: 1px solid #ddd;">:
              Bukti reservasi untuk check in tanggal <b> <?php echo convert_date(@$resbooking->checkin) ?> </b> jam <b> <?php echo @$resbooking->jam ?> </b>
            </th>
          </tr>
        </thead>
        
      </table>

      <table class="report">
          <thead>
            <tr>
            <th style="border-bottom: none;" width="450"></th>
            <th style="text-align: center; border-bottom: none;"></th>
            <th style="border-bottom: none;" width="1000"></th>
            <th style="border-bottom: 1px solid #ddd; text-align: center;"><?=@$options["profile_city"]?>, <?php echo date('d-m-Y')?></th>
          </tr>
        </thead>
        <thead>
            <tr>
            <th style="border-bottom: none;" width="215"></th>
            <th style="text-align: center; border-top: none #ddd; border-bottom: none;" width="500">(Guest Signature)</th>
            <th  style="border-bottom: none;" width="100"></th>
            <th style="text-align: center; border-top: none #ddd; border-bottom: none;" width="500" height="150">(Admin)</th>
            </tr>
        </thead>
        <thead>
            <tr>
            <th style="border-bottom: none;" width="215"></th>
            <th style="text-align: center; border-top: none #ddd; border-bottom: 1px solid;" width="500">
              <?php if ($resbooking->pelanggan_id != 0) {
                 echo $resbooking->pelanggan->nama;
                } else {
                  echo $resbooking->reservationdetail->reservation->guest->name;
                } 
              ?>        
            </th>
            <th  style="border-bottom: none;" width="100"></th>
            <th style="text-align: center; border-top: none #ddd; border-bottom: 1px solid;" width="500">
                <?=@$resbooking->user->name?>
            </th>
            </tr>
        </thead>
      </table>
 
