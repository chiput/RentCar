<?php 
  $this->layout('layouts/printbillwh', [
    // app profile
    'company' => $options,
    'title' => "Cetak Bill",
  ]); 
?>

<div class="col-sm-6">
  <div class="white-box">
    <h3 class="box-title" style="text-align: center;">WHITE HOUSE</h3>
    <table width="100%">
      <thead>
        <tr>
          <td width="50%">Kasir :</td>
        </tr>
        <tr>
          <td width="50%">No. Bukti : </td>
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
         <?php 
            foreach ($reskasirwh as $reskasirwh): ?>
          <tr>
            <td><?php echo $reskasirwh->meja; ?></td>
            <td><?php $x = explode(" ",$reskasirwh->tanggal); echo $newDate = date("d-m-Y", strtotime($x[0]));?></td>
            <td><?php echo $reskasirwh->waiter->nama; ?></td>
            <td><?php foreach ($reskasirwh->number($reskasirwh->checkinid) as $key) {
                    echo $key->number;
                  }
            ?></td>
          </tr>
            <?php endforeach; ?>
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
        foreach ($Reskasirdetailwhitehouse as $reskasirwh): 
          $total = $total + $reskasirwh->kuantitas*$reskasirwh->costmenu?>
          <tr rowspan="8">
            <td style="border-bottom: none;"><?php echo $reskasirwh->kuantitas; ?></td>
            <td style="border-bottom: none;"><?php echo $reskasirwh->namamenu; ?></td>
            <td style="border-bottom: none;">Rp. <?php echo $this->convert($reskasirwh->costmenu); ?></td>
            <td style="border-bottom: none;">Rp. <?php echo $this->convert($reskasirwh->kuantitas*$reskasirwh->costmenu); ?></td>
          </tr>
            <?php endforeach; ?>
        </tbody>
        <thead>
            <tr>
            <th style="border-top: 1px solid #ddd; border-bottom: none; text-align: center;">Guest Signature</th>
            <th style="text-align: right; border-top: 1px solid #ddd;">Total</th>
            <th colspan="2" style="text-align: right; border-top: 1px solid #ddd;">Rp. <?php echo $this->convert($total); ?></th>
          </tr>
        </thead>
        <thead>
            <tr>
            <th colspan="2" style="text-align: right; border-bottom: none;">Disc</th>
            <th colspan="2" style="text-align: right;">n/a</th>
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
            <th colspan="2" style="text-align: right;">Rp. <?php echo $this->convert($total); ?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>