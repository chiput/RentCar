<?php 
  $this->layout('layouts/printbillspa', [
    // app profile
    'company' => $options,
    'title' => "Cetak Faktur",
  ]); 
?>

<div class="col-sm-6">
  <div class="white-box">
  <?php foreach ($spakasir as $spakasir): ?>
    <h3 class="box-title" style="text-align: center;">FAKTUR SPA</h3>
    <table width="100%">
      <thead>
        <tr>
          <td width="50%">No. Bukti : <?php echo @$spakasir->nobukti; ?></td>
        </tr>
        <tr>
          <td width="50%">Nama Pelanggan : <?php echo @$spakasir->namapelanggan; ?> </td>
        </tr>
        <tr>
          <td width="50%">Kasir : <?php echo $spakasir->user->name ?></td>
        </tr>
      </thead>
    </table>
    <hr>
    <div class="table-responsive">
      <table class="report">
        <thead>
          <tr>
            <th style="border-bottom: none;">Date & Time</th>
            <th colspan ="2" style="border-bottom: none;">Pax</th>
            <th colspan ="2" style="border-bottom: none;">Room No</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php $x = explode(" ",$spakasir->tanggal); echo $newDate = date("d-m-Y", strtotime($x[0]));?></td>
            <td colspan="2"><?php echo $spakasir->pax; ?></td>
            <td colspan="2"><?php foreach ($spakasir->number($spakasir->checkinid) as $key) {
                    echo $key->number;
                  }
            ?></td>
          </tr>
            <?php endforeach; ?>
        </tbody>
        <thead>
            <tr>
            <!-- <th>Qty</th> -->
            <th style="width: 300px;">Description</th>
            <th>Terapis</th>
            <th style="border-top: 1px solid #ddd">Price</th>
            <th style="border-top: 1px solid #ddd">Diskon</th>
            <th style="border-top: 1px solid #ddd">Amount</th>
          </tr>
        </thead>
         <tbody>
         <?php
         $total = 0;
        foreach ($spakasirdetail as $spakasirdetail): ?>
          <tr rowspan="8">
            <!-- <td style="border-bottom: none;"><?php echo $spakasirdetail->kuantitas; ?></td> -->
            <?php if(is_numeric($spakasirdetail->layananid)){ ?>
            <td style="border-bottom: none; width: 300px;"><?php echo $spakasirdetail->layanan->nama_layanan; ?></td>
            <td style="border-bottom: none;"><?php echo $spakasirdetail->terapis->nama; ?></td>
            <td style="border-bottom: none;">Rp. <?php echo number_format($spakasirdetail->layanan->hargajual); ?></td>
            <td style="border-bottom: none;"><?php echo $spakasirdetail->layanan->diskon; ?>%</td>
            <td style="border-bottom: none;">Rp. <?php echo number_format($spakasirdetail->harga); 
              $total = $total + $spakasirdetail->harga;
              ?></td>
              <?php } else { ?>
              <td style="border-bottom: none;"><?php echo $spakasirdetail->layananid; ?></td>
              <td style="border-bottom: none;">Rp. <?php echo number_format($spakasirdetail->harga); ?></td>
              <td style="border-bottom: none;">Rp. <?php echo number_format($spakasirdetail->kuantitas*$spakasirdetail->harga); ?></td>
            <?php $total = $total + $spakasirdetail->kuantitas*$spakasirdetail->harga;} ?>
          </tr>
            <?php endforeach; ?>
        </tbody>
        <thead>
          <tr>
            <th colspan="5" style="border-top: 1px solid #ddd; border-bottom: none;"></th>
          </tr>
        </thead>
        <thead>
            <tr>
            <th style="border-top: none; border-bottom: none; text-align: center;">Guest Signature</th>
            <th colspan="3" style="text-align: right; border-top: none; border-bottom: none;">Total</th>
            <th colspan="3" style="text-align: right; border-top: none;">Rp. <?php echo number_format($total); ?></th>
          </tr>
        </thead>
        <thead>
          <tr>
            <th colspan="4" style="border-top: none; border-bottom: none;"></th>
          </tr>
        </thead>
        <thead>
            <tr>
            <th colspan="4" style="text-align: right; border-bottom: none;">Disc</th>
            <th colspan="3" style="text-align: right;">
              <?php if($spakasir->diskon != 0){ ?>
               Rp. <?php echo number_format($spakasir->diskon)?>
              <?php } else { ?>
                -
              <?php } ?>
            </th>
          </tr>
        </thead>
        <!-- <thead>
            <tr>
            <th colspan="2" style="text-align: right; border-bottom: none;">Service</th>
            <th colspan="2" style="text-align: right;">n/a</th>
          </tr>
        </thead> -->
        <thead>
          <tr>
            <th colspan="4" style="border-top: none; border-bottom: none;"></th>
          </tr>
        </thead>
        <thead>
            <tr>
            <th style="border-bottom: 1px solid #ddd; text-align: center;">( <?php echo @$spakasir->namapelanggan; ?> )</th>
            <th colspan="3" style="text-align: right; border-bottom: none;">Grand Total</th>
            <th colspan="3" style="text-align: right;">Rp. <?php echo number_format($total-$spakasir->diskon); ?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>