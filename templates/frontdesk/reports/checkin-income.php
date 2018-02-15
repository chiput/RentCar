<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Pendapatan Check In",
  ]); 
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3>LAPORAN PENDAPATAN CHECK IN</h3>
                <h4 style="margin-top: -8px;">
                    <span>Tanggal:
                        <?php echo date('d/m/Y', strtotime($range['start'])); ?>
                        s/d
                        <?php echo date('d/m/Y', strtotime($range['end'])); ?>
                    </span>
                </h4>
            <?php
                function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
            ?>
            <table class="table table-bordered report">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tamu</th>
                        <th>User</th>
                        <th>No. Kamar</th>
                        <th>B</th>
                        <th>Kamar</th>
                        <th>B.Tambahan</th>
                        <th>Diskon</th>
                        <th>Deposit</th>
                        <th>Service</th>
                        <th>PPN</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
            <?php
                $no = 1;
                foreach ($dates as $date):
                    if ( (isset($deposits[$date]) && !empty($deposits[$date]))):
            ?>
            <tbody class="block-date">
                <tr class="date-container">
                    <td colspan="12">
                        <h4>Tanggal: <?php echo date('d/m/Y', strtotime($date)); ?></h4>
                    </td>
                </tr>
                <?php if (isset($deposits[$date]) && !empty($deposits[$date])): ?>
                <?php foreach ($deposits[$date] as $deposit): ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $deposit->guest_name; ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Deposit</td>
                    <td></td>
                    <td></td>
                    <td><?php echo $this->convert($deposit->nominal) ?></td>
                    <td></td>
                    <td></td>
                    <td><?php echo $this->convert($deposit->nominal) ?></td>
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