<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Aktivitas Tamu",
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
            <h3>LAPORAN AKTIVITAS TAMU</h3>
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
                        <th>Tamu</th>
                        <th>Kamar</th>
                        <th>Rate</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $no = 1;
                foreach($reservationdetails as $key => $detail){ ?>
                    <tr>
                        <td><?=$no++?></td>
                        <td><?=convert_date(substr($detail->reservation->checkin,0,10))?> / <?=convert_date(substr($detail->reservation->checkout,0,10))?></td>
                        <td><?=@$detail->reservation->guest->name?></td>
                        <td><?=$detail->room->number?></td>
                        <td><?=$this->convert(@$detail->price)?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>