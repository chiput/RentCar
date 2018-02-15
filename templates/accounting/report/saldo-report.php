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
  //   'submain_location' => 'Laporan Saldo'
  // ]); 

  //print_r($saldoawal);
?>
<?php 
    $this->layout('layouts/print', [
      // app profile
      'company' => $options,
      'title' => "Laporan Saldo",
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
            <h3>LAPORAN SALDO</h3>
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
                            <th>No. Account</th>
                            <th>Nama</th>
                            <th>Debet</th>
                            <th>Kredit</th>
                            <!-- <th>Saldo</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total=0;
                        $debets=0;
                        $kredits=0;
                        foreach($accounts as $account){ 

                            $debet=@$jurnaldetails[$account->id]->t_debet;//+@$saldoawal[$account->id]->debet;
                            $debets=$debets+$debet;
                            $kredit=@$jurnaldetails[$account->id]->t_kredit;//+@$saldoawal[$account->id]->kredit;
                            $saldo=($account->type=="Debet"?$debet-$kredit:$kredit-$debet);
                            $kredits=$kredits+$kredit;
                            $total+=$saldo;
                            ?>
                        <tr>
                            <td><?=$account->code?></td>
                            <td><?=$account->name?></td>
                            <td><?php 
                            if($account->type == "Debet"){
                              $debet = $debet - $kredit;
                              echo $this->convert($debet,0);
                            } else {
                              echo 0;
                            }
                            ?></td>
                            <td><?php
                            if($account->type == "Kredit"){
                              $kredit = $kredit - $debet;
                              echo $this->convert($kredit,0);
                            } else {
                              echo 0;
                            }
                            ?></td>
                           <!--  <td><?=$this->convert($total,0);?></td> -->
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">Balance</td>
                            <td><?=$this->convert($debets); ?></td>
                            <td><?=$this->convert($kredits); ?></td>
                        </tr>
                       <!--  <tr>
                            <td colspan="4">Balance</td>
                            <td><?=$total?></td>
                        </tr> -->
                </tfoot>
            </table>
        </div>
    </div>
</div>