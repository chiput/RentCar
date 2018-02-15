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

    <h2 class="box-title" style="text-align: center;">.: Bukti Pembayaran :.</h2>
    <table class="report">
        <thead>
          <tr>
            <th style="border-bottom: none;" width="110">No. Receive</th>
            <th style="border-bottom: none;">: <?=@$deposit->nobukti?></th>
          </tr>
        </thead>
        <thead>
          <tr>
            <th style="border-bottom: 1px solid #ddd;">Tanggal Deposit</th>
            <th style="border-bottom: 1px solid #ddd;">: <?php echo date('d-m-Y', strtotime(@$deposit->tanggal)) ; ?></th>
          </tr>
        </thead>
      </table>

      <table class="report">
        <thead>
          <tr>
            <th style="border-bottom: none;" width="50"></th>
            <th style="border-bottom: none;" width="150">Telah di terima dari</th>
            <th style="border-bottom: 1px solid #ddd;">: <?=$reservation->guest->name?></th>

          </tr>
        </thead>
        <thead>
          <tr>
            <th style="border-bottom: none;"></th>
            <th style="border-bottom: none;">Nominal Uang</th>
            <th style="border-bottom: 1px solid #ddd;">: Rp. <?=number_format(@$deposit->nominal,0,',','.')?></th>
          </tr>
        </thead>
        <thead>
          <tr>
            <th style="border-bottom: none;"></th>
            <th style="border-bottom: none;">Untuk Pembayaran</th>
            <th style="border-bottom: 1px solid #ddd;">: Deposit <b><?=@$options["profile_name"]?></b> tanggal checkin <b><?=convert_date(substr($reservation->checkin,0,10))." ".substr($reservation->checkin,10,18)?></b> sampai <b><?=convert_date(substr($reservation->checkout,0,10))." ".substr($reservation->checkout,10,18)?> </b> room <b> <?php foreach($rooms as $room){echo $room->number.", ";}?> </b> </th>
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
            <th style="text-align: center; border-top: none #ddd; border-bottom: none;" width="500" height="150">(Front Office)</th>
            </tr>
        </thead>
        <thead>
            <tr>
            <th style="border-bottom: none;" width="215"></th>
            <th style="text-align: center; border-top: none #ddd; border-bottom: 1px solid;" width="500"><?=$reservation->guest->name?></th>
            <th  style="border-bottom: none;" width="100"></th>
            <th style="text-align: center; border-top: none #ddd; border-bottom: 1px solid;" width="500"><?=@$deposit->user->name?></th>
            </tr>
        </thead>
      </table>
 
