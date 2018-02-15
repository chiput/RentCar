<?php 
  // $this->layout('layouts/plain', [
  //   // app profile
  //   'title' => 'Laporan Buku Besar',
  //   'app_name' => $app_profile['name'],
  //   'author' => $app_profile['author'],
  //   'description' => $app_profile['description'],
  //   'developer' => $app_profile['developer'],
  //   // breadcrumb
  //   'main_location' => 'Akunting',
  //   'submain_location' => 'Laporan Buku Besar'
  // ]); 

  $totaldebet=0; 
  $totalkredit=0; 

  $subtotaldebet=0;
  $subtotalkredit=0;

  $newarr=[]; $account_ids=[];
  foreach ($details as $detail) {
      $newarr[$detail->id][]=$detail;
      $account_ids[$detail->id]=$detail->id;
  }
  $details=$newarr;
  
?>
<?php 
    $this->layout('layouts/print', [
      // app profile
      'company' => $options,
      'title' => "Laporan Buku Besar",
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
            <h3>LAPORAN BUKU BESAR</h3>
                <h4 style="margin-top: -8px;">
                    <span>Tanggal :
                        <?php echo date('d-m-Y', strtotime($range['start'])); ?>
                        s/d
                        <?php echo date('d-m-Y', strtotime($range['end'])); ?>
                    </span>
                </h4>
                <table class="table table-bordered report">
                     <thead>
                          <tr>
                              <th>Tanggal</th>
                              <th>Kode Jurnal</th>
                              <th>Keterangan</th>
                              <th>Debet</th>
                              <th>Kredit</th>
                              <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach($account_ids as $id)
                            {
                                $subtotaldebet=0;
                                $subtotalkredit=0;
                            ?>
                            <tr>
                                <td colspan="6"><strong><?=$details[$id][0]->code?> | <?=$details[$id][0]->name?></strong></td>
                            </tr>
                            <?php  
                                foreach ($details[$id] as $detail) 
                                {
                                    $subtotaldebet+=$detail->debet;
                                    $subtotalkredit+=$detail->kredit;
                                    @$saldo=($detail->type=="Debet"?$subtotaldebet-$subtotalkredit:$subtotalkredit-$subtotaldebet);
                            ?>
                            <tr>
                                <td><?=convert_date($detail->tanggal)?></td>
                                <td><?=$detail->jurnal_code?></td>
                                <td><?=$detail->keterangan?></td>
                                <td><?=$this->convert($detail->debet);?></td>
                                <td><?=$this->convert($detail->kredit);?></td>
                                <td><?=$this->convert($saldo);?></td>
                            </tr>
                            <?php             
                                }    
                            ?>
                            <tr>
                                <td colspan="3"><strong>Balance</strong></td>
                                <td><strong><?=$this->convert($subtotaldebet);?></strong></td>
                                <td><strong><?=$this->convert($subtotalkredit);?></strong></td>
                                <td><strong><?=$this->convert($saldo);?></strong></td>
                            </tr>
                            <?php 
                                    $subtotaldebet=0;
                                    $subtotalkredit=0;
                            } 
                            $totaldebet+=$subtotaldebet; 
                            $totalkredit+=$subtotalkredit; 
                            ?>
                  </tbody>
            </table>
        </div>
    </div>
</div>