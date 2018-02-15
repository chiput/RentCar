<?php 
  // $this->layout('layouts/plain', [
  //   // app profile
  //   'title' => 'Laporan Saldo',
  //   'app_name' => $app_profile['name'],
  //   'author' => $app_profile['author'],
  //   'description' => $app_profile['description'],
  //   'developer' => $app_profile['developer'],
  //   // breadcrumb
  //   'main_location' => 'Akunting',
  //   'submain_location' => 'Laporan Jurnal'
  // ]); 

  $totaldebet=0; 
  $totalkredit=0; 
?>
<?php 
    $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Laporan Jurnal",
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
            <h3>LAPORAN JURNAL UMUM</h3>
                <h4 style="margin-top: -8px;">
                    <span>Tanggal:
                        <?php echo date('d-m-Y', strtotime($range['start'])); ?>
                        s/d
                        <?php echo date('d-m-Y', strtotime($range['end'])); ?>
                    </span>
                </h4>    
                <?php foreach ($jurnals as $jurnal) { ?>
                <table style="padding-top: 20px">
                    <tbody>
                        <tr>
                            <td>
                                <label class="col-md-6"> 
                                    <span class="help"> No. Jurnal : <?=$jurnal->code?> (<?=$jurnal->code?>)</span>
                                </label>
                            </td>
                            <td style="padding-left: 60px">
                                <label class="col-md-6"> 
                                    <span class="help"> Tanggal : <?=convert_date($jurnal->tanggal)?></span>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label class="col-md-6"> 
                                    <span class="help"> User : <?=@$jurnal->user->name?></span>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label class="col-md-6"> 
                                    <span class="help"> Keterangan : <?=$jurnal->keterangan?></span>
                                </label>            
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered report" style="padding-bottom: 80px; width: 100%">
                        <thead>
                            <tr>
                                <th>No. Akun</th>
                                <th>Nama</th>
                                <th>Debet</th>
                                <th>Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $subtotaldebet=0;
                            $subtotalkredit=0;
                            foreach($jurnal->detail as $detail){ 
                                $subtotaldebet+=$detail->debet;
                                $subtotalkredit+=$detail->kredit;
                                ?>
                            <tr>
                                <td width="150"><?=@$detail->account->code?></td>
                                <td><?=@$detail->account->name?></td>
                                <td width="150"><?=$this->convert(@$detail->debet)?></td>
                                <td width="150"><?=$this->convert(@$detail->kredit)?></td>
                            </tr>
                            <?php } 
                            $totaldebet+=$subtotaldebet; 
                            $totalkredit+=$subtotalkredit; 
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">Balance</td>
                                <td><?=$this->convert($subtotaldebet)?></td>
                                <td><?=$this->convert($subtotalkredit)?></td>
                            </tr>
                    </tfoot>
                </table>
            <?php } ?>
        </div>
    </div>
</div>