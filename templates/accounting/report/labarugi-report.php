<?php 
  // $this->layout('layouts/plain', [
  //   // app profile
  //   'title' => 'Laporan Laba & Rugi',
  //   'app_name' => $app_profile['name'],
  //   'author' => $app_profile['author'],
  //   'description' => $app_profile['description'],
  //   'developer' => $app_profile['developer'],
  //   // breadcrumb
  //   'main_location' => 'Akunting',
  //   'submain_location' => 'Laporan Laba & Rugi'
  // ]); 

  $total=0;

  // $newarr=[]; $group_ids=[];
  // foreach ($details as $detail) {
  //     $newarr[$detail->id][]=$detail;
  //     $account_ids[$detail->id]=$detail->id;
  // }
  // $details=$newarr;
  
?>
<?php 
    $this->layout('layouts/print', [
        // app profile
        'company' => $options,
        'title' => "Laporan Laba & Rugi",
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
            <h3>LAPORAN LABA & RUGI</h3>
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
                            foreach ($details as $detail) 
                            {
                                if($detail->group_name=="PENDAPATAN"){

                                $saldo=$detail->t_kredit-$detail->t_debet;
                                $t_laba+=$saldo;
                            ?>
                            <tr>
                                <td><?=$detail->name?></td>
                                <td><?=number_format($saldo,0,",",".")?></td>
                            </tr>
                            <?php             
                                }    
                            } ?>
                        <!-- //////////////// HPP //////// -->
                            <tr>
                                <td colspan="2"><strong>HPP</strong></td>
                            </tr>
                            <?php 
                            foreach ($details as $detail) 
                            {
                                if($detail->group_name=="HPP"){

                                $saldo=$detail->t_debet-$detail->t_kredit;
                                $t_laba-=$saldo;
                            ?>
                            <tr>
                                <td><?=$detail->name?></td>
                                <td>(<?=$this->convert($saldo);?>)</td>
                            </tr>
                            <?php             
                                }    
                            }
                            ?>
                            <tr>
                                <td><strong>Laba Kotor</strong></td>
                                <td><?=$this->convert($t_laba);?></td>
                            </tr>
                        <!-- //////////////// Biaya //////// -->
                            <tr>
                                <td colspan="2"><strong>Biaya</strong></td>
                            </tr>
                            <?php 
                            $t_rugi=0;
                            foreach ($details as $detail) 
                            {
                                if($detail->group_name=="BIAYA"){

                                $saldo=$detail->t_debet-$detail->t_kredit;
                                $t_rugi+=$saldo;
                            ?>
                            <tr>
                                <td><?=$detail->name?></td>
                                <td><?=$this->convert($saldo);?></td>
                            </tr>
                            <?php             
                                }    
                            }
                            ?>
                            <tr>
                                <td><strong>Total Biaya</strong></td>
                                <td><?=number_format($t_rugi,0,",",".")?></td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td><strong>Laba/Rugi</strong></td>
                                <td><?=number_format($t_laba-$t_rugi,0,",",".")?></td>
                            </tr>
                    </tbody>
            </table>
        </div>
    </div>
</div>