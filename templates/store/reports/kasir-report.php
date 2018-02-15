<?php
  
    $this->layout('layouts/printbillstore', [
      // app profile
      'company' => $options,
      'title' => "Cetak Bill",
    ]); 
?>

<div class="col-sm-6">
  <div class="white-box">
    <?php foreach ($storekasir as $storekasir): ?>
    <h3 class="box-title" style="text-align: center;">Kasir Store</h3>
    <table width="100%">
      <thead> 
        <tr>
          <td width="50%">Kasir : Store</td>
        </tr>
        <tr>
          <td width="50%">No. Bukti : <?php echo @$storekasir->nobukti; ?></td>
        </tr>
        <tr>
          <td>Date & TIme: <?php $x = explode(" ",$storekasir->tanggal); echo $newDate = date("d-m-Y", strtotime($x[0]));?></td>
        </tr>
      </thead>
    </table>
    <hr>
    <div class="table-responsive">
      <table class="report">
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
        foreach ($storekasirdetail as $storekasirdet): ?>
          <tr rowspan="8">
            <td style="border-bottom: none;"><?php echo $storekasirdet->kuantitas; ?></td>
              <td style="border-bottom: none;"><?php echo $storekasirdet->barang->nama; ?></td>
              <td style="border-bottom: none;">Rp. <?php echo $this->convert($storekasirdet->store->harga); ?></td>
              <td style="border-bottom: none;">Rp. <?php echo $this->convert($storekasirdet->harga); 
              $total = $total + $storekasirdet->harga;
              ?></td>
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
              <?php if($storekasir->diskon != 0){ ?>
                Rp. <?php echo $this->convert($storekasir->diskon)?>
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
            <th colspan="2" style="text-align: right;">Rp. <?php echo $this->convert($total-$storekasir->diskon); ?></th>
          </tr>
        </thead>
      </table>
    </div>
    <?php endforeach; ?>
  </div>
</div>