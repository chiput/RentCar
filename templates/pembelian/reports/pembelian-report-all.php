<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Pembelian",
  ]); 
?>
        <?php
                function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
            ?>
<h3>LAPORAN PEMBELIAN</h3>
    <h4 style="margin-top: -8px;">
        <p>Tanggal <strong><?php echo (@$d_start) ?></strong> sampai <strong><?php echo (@$d_end) ?></strong></p>
    </h4>
<table class="report" width="780">
    <thead>
        <tr>
            <th>No.</th>
            <th>Tanggal</th>
            <th>No. Bukti</th>
            <th>Supplier</th>
            <th>Diskon</th>
            <th>PPN</th>
            <th>Ongkos Kirim</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $total_diskon = 0;
        $total_ppn = 0;
        $total_ongkos = 0;
        $total_harga = 0;
        foreach($pembelians as $no => $pembelian):
            $sum = 0;
            foreach ($pembelian->details as $detail) {
                $sum += $detail->kuantitas*$detail->harga;
            }

          $subtotal = $sum - $pembelian->diskon;
          if ($pembelian->ppn > 0) {
            $ppn_harga = ($subtotal*($pembelian->ppn/100));
          } else {
            $ppn_harga = 0;
          }
          
          $ppn_hasil = $subtotal + $ppn_harga;
          $total_hasil = $ppn_hasil + $pembelian->ongkos;

        ?>
        <tr>
            <td><?=$no+1?></td>
            <td><?php echo convert_date(@$pembelian->tanggal) ?></td>
            <td><?=$pembelian->nobukti?></td>
            <td><?=$pembelian->supplier->nama?></td>
            <td><?=$this->convert($pembelian->diskon);?></td>
            <td><?=$this->convert($ppn_harga);?></td>
            <td><?=$this->convert($pembelian->ongkos);?></td>
            <td><?=$this->convert($total_hasil);?></td>
        </tr>
        <?php 
        $total_diskon += $pembelian->diskon;
        $total_ppn += $ppn_harga;
        $total_ongkos += $pembelian->ongkos;
        $total_harga += $total_hasil;
        endforeach; ?>
        <tr>
            <td colspan="4"><strong>Total</strong></td>
            <td><?=$this->convert($total_diskon);?></td>
            <td><?=$this->convert($total_ppn);?></td>
            <td><?=$this->convert($total_ongkos);?></td>
            <td><?=$this->convert($total_harga);?></td>
        </tr>
    </tbody>
</table>
<br/>
