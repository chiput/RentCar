<?php
  if($resto=='ri'){
    $this->layout('layouts/printbill', [
      // app profile
      'company' => $options,
      'title' => "Cetak Bill",
    ]); 
  } else {
    $this->layout('layouts/printbillwh', [
      // app profile
      'company' => $options,
      'title' => "Cetak Bill",
    ]); 
  }
?>

<div class="col-sm-6">
  <div class="white-box">
    <?php foreach ($reskasirku as $reskasirku): ?>
    <h3 class="box-title" style="text-align: center;"><?php if($reskasirku->resto==1){ echo 'RESTORANTE ITALIA';}else { echo 'WHITE HORSE'; }?></h3>
    <table width="100%">
      <thead> 
        <tr>
          <td width="50%">Kasir : <?php if($reskasirku->resto==1){ echo $reskasirku->user->name.' - Restorante Italia';}else { echo $reskasirku->user->name.' - White Horse'; }?></td>
        </tr>
        <tr>
          <td width="50%">No. Bukti : <?php echo @$reskasirku->nobukti; ?></td>
        </tr>
      </thead>
    </table>
    <hr>
    <div class="table-responsive">
      <table class="report">
        <thead>
          <tr>
            <th style="border-bottom: none;">Table</th>
            <th style="border-bottom: none;">Date & Time</th>
            <th style="border-bottom: none;">Waiter</th>
            <th style="border-bottom: none;">Room No</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo $reskasirku->meja; ?></td>
            <td><?php $x = explode(" ",$reskasirku->tanggal); echo $newDate = date("d-m-Y", strtotime($x[0]));?></td>
            <td><?php echo $reskasirku->waiter->nama; ?></td>
            <td><?php foreach ($reskasirku->number($reskasirku->checkinid) as $key) {
                    echo $key->number;
                  }
            ?></td>
          </tr>
        </tbody>
        <thead>
            <tr>
            <th>Qty</th>
            <th>Description</th>
            <th>Price</th>
            <th>Amount</th>
          </tr>
        </thead>
         <tbody>
         <?php
         $total = 0;
        foreach ($Reskasirkudetail as $reskasirkudet): ?>
          <tr rowspan="8">
            <td style="border-bottom: none;"><?php echo $reskasirkudet->kuantitas; ?></td>
            <?php if(is_numeric($reskasirkudet->menuid)){ ?>
              <td style="border-bottom: none;"><?php echo $reskasirkudet->menu->nama; ?></td>
              <td style="border-bottom: none;">Rp. <?php echo $this->convert($reskasirkudet->menu->hargajual); ?></td>
              <td style="border-bottom: none;">Rp. <?php echo $this->convert($reskasirkudet->harga); 
              $total = $total + $reskasirkudet->harga;
              ?></td>
            <?php } else { ?>
              <td style="border-bottom: none;"><?php echo $reskasirkudet->menuid; ?></td>
              <td style="border-bottom: none;">Rp. <?php echo $this->convert($reskasirkudet->harga/$reskasirkudet->kuantitas); ?></td>
              <td style="border-bottom: none;">Rp. <?php echo $this->convert($reskasirkudet->harga); ?></td>
            <?php $total = $total + $reskasirkudet->kuantitas*$reskasirkudet->harga;} ?>
          </tr>
            <?php endforeach; ?>
        </tbody>
        <thead>
            <tr>
            <th style="border-top: 1px solid #ddd; border-bottom: none; text-align: center;">Guest Signature</th>
            <th style="text-align: right; border-top: 1px solid #ddd; border-bottom: none;">Total</th>
            <th colspan="2" style="text-align: right; border-top: 1px solid #ddd;">Rp. <?php echo $this->convert($total); ?></th>
          </tr>
        </thead>
        <thead>
            <tr>
            <th colspan="2" style="text-align: right; border-bottom: none;">Disc</th>
            <th colspan="2" style="text-align: right;">
              <?php if($reskasirku->diskon != 0){ ?>
                Rp. <?php echo $this->convert($reskasirku->diskon)?>
              <?php } else { ?>
                n/a
              <?php } ?>
            </th>
          </tr>
        </thead>
        <thead>
            <tr>
            <th colspan="2" style="text-align: right; border-bottom: none;">Service</th>
            <th colspan="2" style="text-align: right;">n/a</th>
          </tr>
        </thead>
        <thead>
            <tr>
            <th style="text-align: right; border-bottom: 1px solid #ddd;"></th>
            <th style="text-align: right; border-bottom: none;">Grand Total</th>
            <th colspan="2" style="text-align: right;">Rp. <?php echo $this->convert($total-$reskasirku->diskon); ?></th>
          </tr>
        </thead>
      </table>
    </div>
    <?php endforeach; ?>
  </div>
</div>