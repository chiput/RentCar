<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Pendapatan Hotel",
  ]); 
//print_r($checkouts);
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3>LAPORAN PENDAPATAN HOTEL</h3>
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
                        <th>No.</th>
                        <th>Tamu</th>
                        <th>User</th>
                        <th>No. Kamar</th>
                        <th>B. Kamar</th>
                        <th>B.Tambahan</th>
                        <th>Diskon</th>
                        <!--<th>Deposit</th>-->
                        <th>Service</th>
                        <th>PPN</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
            <?php
                $no = 1;
                foreach ($dates as $date):
                    if ( (isset($deposits[$date]) && !empty($deposits[$date])) ||
                        (isset($checkouts[$date]) && !empty($checkouts[$date])) ):
            ?>
            <tbody class="block-date">
                <tr class="date-container">
                    <td colspan="12">
                        <h4>Tanggal: <?php echo date('d-m-Y', strtotime($date)); ?></h4>
                    </td>
                </tr>
                <?php if (isset($checkouts[$date]) && !empty($checkouts[$date])): ?>
                <?php foreach ($checkouts[$date] as $checkout): ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $checkout->guest_name; ?></td>
                    <td></td>
                    <td><?php echo $checkout->room_number; ?></td>
                    <td><?php echo $this->convert($checkout->room_price); ?></td>
                    <td><?php echo $this->convert($checkout->additional_charge); ?></td>
                    <td><?php echo $this->convert($checkout->discount); ?></td>
                    <!--<td></td>-->
                    <td><?php echo $this->convert($checkout->service_charge); ?></td>
                    <td><?php echo $this->convert($checkout->tax_charge); ?></td>
                    <td><?php echo  $this->convert($checkout->room_price + 
                                    $checkout->additional_charge -
                                    $checkout->discount -
                                    $checkout->tax_charge +
                                    $checkout->service_charge) 
                                    ; ?></td>
                </tr>
                <?php $no++; ?>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
            <?php
                    endif; /*
                    if (isset($deposits[$date]) && !empty($deposits[$date]) &&
                        isset($checkouts[$date]) && !empty($checkouts[$date])):*/
                endforeach;
            ?>
            </table>
        </div>
    </div>
</div>   