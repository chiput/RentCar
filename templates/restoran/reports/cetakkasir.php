<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Daftar Menu",
  ]); 
?>
<div class="row">
     <div class="col-sm-6">
              
            </div>
            <div class="col-sm-6"></div>
</div>
<table class="">
    <thead>
        <tr>
            <th >Trx id</th>
            <th >:</th>
            <th><?=$catakkasirs[0]->nobukti?></th>
            <th style="width: 20%;"></th>
            <th >Tanggal</th>
            <th >:</th>
            <th><?=$catakkasirs[0]->tanggal?></th>
            
            
        </tr>

    </thead>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">

      
           
   
<table class="table table-bordered report">
    <thead>
        <tr>
            <th style="width: 2%;">No.</th>
            <th style="width: 70%;">Nama Menu</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>SubHarga</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; foreach ($catakkasirs as  $catakkasir): ?>
        <tr id="trow-<?php echo $catakkasir->id; ?>">
            <td><?php echo $no; ?>.</td>
            <td><?php echo $catakkasir->nama; ?></td>
            <td><?php echo $catakkasir->kuantitas; ?></td>
            <td style="text-align: right;"><?php echo  number_format($catakkasir->hargamenu,2,",","."); ?></td>
            <td style="text-align: right;"><?php echo  number_format($catakkasir->hargamenu*$catakkasir->kuantitas,2,",","."); ?></td>
        </tr>
        <?php $no++;//$hargajual=$catakkasir->bayar;
         endforeach; ?>
    </tbody>
    <tfoot>
            <tr>
            <td colspan="4" style="text-align: center;">Total</td>
            
            <td style="text-align: right;"><?php echo  number_format($catakkasirs[0]->bayar-$catakkasirs[0]->kembalian,2,",","."); ?></td>
            </tr>
            <tr>
            <td colspan="4" style="text-align: center;">Bayar</td>
            
            <td style="text-align: right;"><?php echo  number_format($catakkasirs[0]->bayar,2,",","."); ?></td>
            </tr>
            <tr>
            <td colspan="4" style="text-align: center;">Kembali</td>
            
            <td style="text-align: right;"><?php echo  number_format($catakkasirs[0]->kembalian,2,",","."); ?></td>
            </tr>
    </tfoot>
</table>
<div style=" text-align: center;margin: 25px;">Terima Kasih</div>
</div>
</div>
</div>
