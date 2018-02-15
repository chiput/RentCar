<?php 
    $this->layout('layouts/print', [
        // app profile
        'company' => $options,
        'title' => "Laporan Kasir",
    ]); 
    function convert_date($date){
        $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
        return $date;
    }
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3>LAPORAN KASIR</h3>
                <h4 style="margin-top: -8px;">
                    <span>Tanggal:
                        <?php echo date('d-m-Y', strtotime($range['start'])); ?>
                        s/d
                        <?php echo date('d-m-Y', strtotime($range['end'])); ?>
                    </span>
                </h4>
            <table class="table table-bordered report">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>No Bukti</th>
                        <th>Nama Mobil</th>
                        <th>Total</th>
                        <th>Diskon</th>
                        <th>Deposit</th>
                        <th>Tunai</th>
                        <th>Kartu</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $no=1; $total=0; $discount=0; $nominal=0; $cash=0; $creditcard_amount=0;
                foreach($dates as $key => $date){ 
                    foreach($date as $row){ ?>
                    <tr>
                        <td><?=$no++?></td>
                        <td><?=convert_date($key)?></td>
                        <td><?=(@$row->nobukti==""?@$row->checkout_code:"")?></td>
                        <td><?php
                            if(@$row->details!=null){
                                foreach ($row->details as $detail) {
                                    echo @$detail->reservationDetails->room->number;
                                }
                            }
                        ?></td>
                        <td><?=$this->convert(@$row->total)?></td>
                        <td><?=$this->convert(@$row->discount)?></td>
                        <td><?=$this->convert(@$row->nominal)?></td>
                        <td><?=$this->convert(@$row->cash)?></td>
                        <td><?=$this->convert(@$row->creditcard_amount)?></td>
                    </tr>
                    <?php 
                    $total+=@$row->total; $discount+=@$row->discount; $nominal+=@$nominal; $cash+=@$row->cash; $creditcard_amount+=@$row->creditcard_amount;
                    } ?>
                <?php } ?>  
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4"></td>
                        <td><strong><?=$this->convert($total)?></strong></td>
                        <td><strong><?=$this->convert($discount)?></strong></td>
                        <td><strong><?=$this->convert($nominal)?></strong></td>
                        <td><strong><?=$this->convert($cash)?></strong></td>
                        <td><strong><?=$this->convert($creditcard_amount)?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>