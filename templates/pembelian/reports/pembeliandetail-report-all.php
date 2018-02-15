<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Detail Pembelian",
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
<h3>LAPORAN DETAIL PEMBELIAN</h3>
    <h4 style="margin-top: -8px;">
        <p>Tanggal <strong><?php echo (@$d_start) ?></strong> sampai <strong><?php echo (@$d_end) ?></strong></p>
    </h4>
<table class="report" width="780">
    <thead>
        <tr>
            <th>No.</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Satuan</th>
            <th>Kuantitas</th>
            <th>Harga</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php 

        $total_kuantitas = 0;
        $total_harga = 0;

        foreach($pembelians as $pembelian):
        ?>
        <tr>
            <td colspan="7">
                <table class="purchase">
                    <tr>
                        <td>Tanggal</td>
                        <td width="2">:</td>
                        <td width="100"><?php echo convert_date(@$pembelian->tanggal) ?></td>
                        <td>No. Bukti</td>
                        <td width="2">:</td>
                        <td width="100"><?=$pembelian->nobukti?></td>
                        <td>Supplier</td>
                        <td width="2">:</td>
                        <td width="100"><?=$pembelian->supplier->nama?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php 
            $no = 0;
            $sum_kuantitas = 0;
            $sub = 0;
            foreach ($pembelian->details as $no => $detail):
                $total = $detail->kuantitas*$detail->harga;
        ?>
        <tr>
            <td><?=$no+1?></td>
            <td><?=$detail->good->kode?></td>
            <td><?=$detail->good->nama?></td>
            <td><?=$detail->unit->nama?></td>
            <td align="center"><?=$detail->kuantitas?></td>
            <td><?=$this->convert($detail->harga)?></td>
            <td align="right"><?=$this->convert($total)?></td>
        </tr>
        <?php 
                $sum_kuantitas += $detail->kuantitas;
                $sub += $total;
            endforeach;

            $diskon = $sub - $pembelian->diskon;
            $ppn = ($diskon*($pembelian->ppn/100));
            $ppn_hasil = $diskon + $ppn;
            $subtotal = $ppn_hasil + $pembelian->ongkos;
        ?>
        <tr>
            <td colspan="6"><strong>Diskon</strong></td>
            <td align="right"><?=$this->convert($pembelian->diskon)?></td>
        </tr>
        <tr>
            <td colspan="6"><strong>PPN</strong></td>
            <td align="right"><?=$this->convert($ppn)?></td>
        </tr>
        <tr>
            <td colspan="6"><strong>Ongkos Kirim</strong></td>
            <td align="right"><?=$this->convert($pembelian->ongkos)?></td>
        </tr>
        <tr>
            <td colspan="4"><strong>Subtotal</strong></td>
            <td align="center"><strong><?=$this->convert($sum_kuantitas)?></strong></td>
            <td></td>
            <td align="right"><strong><?=$this->convert($subtotal)?></strong></td>
        </tr>
        <?php
        $total_kuantitas += $sum_kuantitas;
        $total_harga += $subtotal;
        endforeach; 
        ?>
        <tr>
            <td colspan="4"><strong>Total</strong></td>
            <td align="center"><strong><?=$this->convert($total_kuantitas)?></strong></td>
            <td></td>
            <td align="right"><strong><?=$this->convert($total_harga)?></strong></td>
        </tr>
    </tbody>
</table>
<style type="text/css">
    .purchase td {
        border: none!important;
    }
</style>
<br/>
