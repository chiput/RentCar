<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Retur Pembelian",
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
<h3>LAPORAN RETUR PEMBELIAN</h3>
    <h4 style="margin-top: -8px;">
        <p>Tanggal <strong><?php echo (@$d_start) ?></strong> sampai <strong><?php echo (@$d_end) ?></strong></p>
    </h4>
<table class="report" width="780">
    <thead>
        <tr>
            <th>No.</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Satuan </th>
            <th>Kuantitas</th>
            <th>Harga</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    $total_kuantitas = 0;
    $total = 0;
    foreach($returs as $retur): ?>
    <tr>
        <td colspan="7">
            <table class="retur">
                <tbody>
                    <tr>
                        <td>Tanggal</td>
                        <td width="2">:</td>
                        <td width="100"><?php echo convert_date(@$retur->tanggal) ?></td>
                        <td>No. Pembelian</td>
                        <td width="2">:</td>
                        <td width="100"><?=$retur->purchase->nobukti?></td>
                    </tr>
                    <tr>
                        <td>No. Bukti</td>
                        <td width="2">:</td>
                        <td width="100"><?=$retur->nobukti?></td>
                        <td>Supplier</td>
                        <td width="2">:</td>
                        <td width="100"><?=$retur->purchase->supplier->nama?></td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
        <?php 
        $no = 0;
        $jumlah = 0;
        $kuantitas = 0;
        $sub = 0;
        foreach ($retur->details as $no => $detail): 
            
            $jumlah = $detail->kuantitas * $detail->harga;
        ?>
        <tr id="trow-<?=$detail->id; ?>">
            <td><?=$no+1?>.</td>
            <td><?=$detail->good->kode?></td>
            <td><?=$detail->good->nama?></td>
            <td align="center"><?=$detail->unit->nama?></td>
            <td align="center"><?=$detail->kuantitas?></td>
            <td align="right"><?=$this->convert($detail->harga)?></td>
            <td align="right"><?=$this->convert($jumlah)?></td>
        </tr>
        <?php 
            $kuantitas += $detail->kuantitas;
            $sub += $jumlah;
        endforeach; 
        ?>
        <tr>
            <td colspan="4"><strong>Sub Total</strong></td>
            <td align="center"><strong><?=$this->convert($kuantitas)?></strong></td>
            <td></td>
            <td align="right"><strong><?=$this->convert($sub)?></strong></td>
        </tr>
        <?php
            $total_kuantitas += $kuantitas;
            $total += $sub;
            endforeach;
        ?>
        <tr>
            <td colspan="4"><strong>Total</strong></td>
            <td align="center"><strong><?=$this->convert($total_kuantitas)?></strong></td>
            <td></td>
            <td align="right"><strong><?=$this->convert($total)?></strong></td>
        </tr>
    </tbody>
</table>
<style type="text/css">
    .retur td {
        border: none!important;
    }
</style>
<br/>