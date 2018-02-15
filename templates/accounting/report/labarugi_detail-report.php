<?php 
  // $this->layout('layouts/plain', [
  //   // app profile
  //   'title' => 'Laporan Detail Laba Rugi',
  //   'app_name' => $app_profile['name'],
  //   'author' => $app_profile['author'],
  //   'description' => $app_profile['description'],
  //   'developer' => $app_profile['developer'],
  //   // breadcrumb
  //   'main_location' => 'Akunting',
  //   'submain_location' => 'Laporan Detail Laba Rugi'
  // ]); 


  $total=0;

  $newarr=[]; $header_ids=[];
  foreach ($details as $detail) {
      $newarr[$detail->group_name][$detail->accheaders_id][]=$detail;
      $header_ids[$detail->accheaders_id]=$detail->accheaders_id;
  }
  $details=$newarr;
  
?>
<?php 
    $this->layout('layouts/print', [
        // app profile
        'company' => $options,
        'title' => "Laporan Detail Laba Rugi",
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
            <h3>LAPORAN DETAIL LABA & RUGI</h3>
                <h4 style="margin-top: -8px;">
                    <span>Tanggal:
                        <?php echo date('d-m-Y', strtotime($range['start'])); ?>
                        s/d
                        <?php echo date('d-m-Y', strtotime($range['end'])); ?>
                    </span>
                </h4>    
                <table class="table table-bordered report" width="100%">
                    <thead>
                        <tr>
                            <th>Keterangan</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                        <tbody>
    <!-- //////////////// Pendapatan //////// -->
                            <tr>
                                <td colspan="2"><strong>Pendapatan</strong></td>
                            </tr>
                            <?php 
                            $t_laba=0;
                            foreach ($header_ids as $headers) 
                            {
                                if(!isset($details["PENDAPATAN"][$headers])){
                                    $details["PENDAPATAN"][$headers]=[];
                                }else{
                            ?>
                                <tr>
                                    <td colspan="2">&nbsp; &nbsp;<strong><?=@$details["PENDAPATAN"][$headers][0]->header_name?></strong></td>
                                </tr>
                                <?php
                                }         
                                foreach ($details["PENDAPATAN"][$headers] as $detail) 
                                {
                                    $saldo=($detail->type=="Kredit"?$detail->t_kredit-$detail->t_debet:$detail->t_debet-$detail->t_kredit);
                                    $t_laba+=$saldo;
                                ?>         
                                <tr>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?=$detail->name?></td>
                                    <td><?=$this->convert($saldo);?></td>
                                </tr>

                                <?php
                                }
                            }
                            ?>
    <!-- //////////////// HPP //////// -->
                            <tr>
                                <td colspan="2"><strong>HPP</strong></td>
                            </tr>
                            <?php 
                            foreach ($header_ids as $headers) 
                            {
                                if(!isset($details["HPP"][$headers])){
                                    $details["HPP"][$headers]=[];
                                }else{
                            ?>
                                <tr>
                                    <td colspan="2">&nbsp; &nbsp;<strong><?=@$details["HPP"][$headers][0]->header_name?></strong></td>
                                </tr>
                                <?php
                                }
                                foreach ($details["HPP"][$headers] as $detail) 
                                {
                                    $saldo=($detail->type=="Kredit"?$detail->t_kredit-$detail->t_debet:$detail->t_debet-$detail->t_kredit);
                                    $t_laba-=$saldo;
                                ?>     
                                <tr>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?=$detail->name?></td>
                                    <td><?=$this->convert($saldo);?></td>
                                </tr>

                                <?php
                                }
                            }
                            ?>
                            <tr>
                                <td><strong>Laba Kotor</strong></td>
                                <td><strong><?=$this->convert($t_laba);?></strong></td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
    <!-- //////////////// Biaya //////// -->     
                            <tr>
                                <td colspan="2"><strong>Biaya</strong></td>
                            </tr>
                            <?php 
                            $t_rugi=0;
                            foreach ($header_ids as $headers) 
                            {
                                if(!isset($details["BIAYA"][$headers])){
                                    $details["BIAYA"][$headers]=[];
                                }else{
                            ?>
                                <tr>
                                    <td colspan="2"><strong>&nbsp; &nbsp;<?=@$details["BIAYA"][$headers][0]->header_name?></strong></td>
                                </tr>
                                <?php
                                }
                                foreach ($details["BIAYA"][$headers] as $detail) 
                                {
                                    $saldo=($detail->type=="Kredit"?$detail->t_kredit-$detail->t_debet:$detail->t_debet-$detail->t_kredit);
                                    $t_rugi+=$saldo;
                                ?>
                                
                                <tr>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?=$detail->name?></td>
                                    <td><?=$this->convert($saldo);?></td>
                                </tr>

                                <?php
                                }
                            }
                            ?>  
                            <tr>
                                <td><strong>Total Biaya</strong></td>
                                <td><strong><?=$this->convert($t_rugi);?></strong></td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td><strong>Laba/Rugi</strong></td>
                                <td><strong><?=$this->convert($t_laba-$t_rugi);?></strong></td>
                            </tr>
                    </tbody>
            </table>
        </div>
    </div>
</div>