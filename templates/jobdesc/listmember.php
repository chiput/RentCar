<?php 
  function TanggalIndo($date){
    $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
   
    $tahun = substr($date, 0, 4);
    $bulan = substr($date, 5, 2);
    $tgl   = substr($date, 8, 2);
   
    $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;   
    return($result);
  }

  foreach ($activities as $act): ?>
  <div class="phenom mod-other-type">
    <?php foreach ($act->details as $user): ?>
      <div class="phenom-creator">
        <div class="member js-show-mem-menu">
          <span class="member-initials"><?php $initial = substr($user->name, 0, 1); echo $initial[0];?></span>
        </div>
      </div>
    <div class="phenom-desc">

      <span class="inline-member js-show-mem-menu">
        <span class="u-font-weight-bold"><?= $user->name; ?></span>
      </span> 
      <?= $act->ket; ?> 
      <?php foreach($act->cards as $cardnya):?>
        on card <b>"<?= $cardnya->cardname; ?>"</b>
      <?php endforeach; ?>
    </div>

    <?php endforeach; ?>
    <p class="phenom-meta quiet"><?php $date= explode(' ', $act->created_at); echo $date[1].', '.TanggalIndo($date[0]);?></p>
  </div>
<?php endforeach; ?>