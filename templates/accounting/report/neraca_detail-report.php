<?php 
  // $this->layout('layouts/plain', [
  //   // app profile
  //   'title' => 'Laporan Neraca Detail',
  //   'app_name' => $app_profile['name'],
  //   'author' => $app_profile['author'],
  //   'description' => $app_profile['description'],
  //   'developer' => $app_profile['developer'],
  //   // breadcrumb
  //   'main_location' => 'Akunting',
  //   'submain_location' => 'Laporan Neraca Detail'
  // ]); 

?>
<?php 
    $this->layout('layouts/print', [
        // app profile
        'company' => $options,
        'title' => "Laporan Neraca Detail",
    ]); 
        $no = 1;
        $months = ['januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember'];
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
            <h3>LAPORAN NERACA DETAIL</h3>
                <h4 style="text-transform: capitalize; margin-top: -10px;">Periode&nbsp<?=$months[$month-1]?> <?=$year?>        
                </h4>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="2" valign="top">
                                <table class="table report">
                                    <tbody>
                                        <?php 
                                        $totalaktiva=0;
                                        foreach($groups as $group) { 
                                            if(substr($group->name,0,6)=="AKTIVA")
                                            {
                                        ?>
                                        <tr>
                                            <td colspan="2"><strong><?=$group->name?></strong></td>
                                        </tr>
                                        <?php 
                                            foreach($headers as $header) { 
                                                if($header->accgroups_id==$group->id)
                                                {  

                                                    // $saldo=@$details[$header->id]->t_debet-@$details[$header->id]->t_kredit;
                                                    // $totalaktiva+=$saldo;
                                        ?>
                                        <tr>
                                            <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<?=$header->name?></td>
                                        </tr>
                                        <?php 
                                                foreach($accounts as $account) 
                                                { 
                                                    if($account->accheaders_id==$header->id)
                                                    {  
                                                        $saldo=@$details[$account->id]->t_debet-@$details[$account->id]->t_kredit;
                                                        $totalaktiva+=$saldo;
                                        ?>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$account->name?></td>
                                            <td><?=$this->convert($saldo)?></td>
                                        </tr>
                                        <?php
                                                    }
                                                } 

                                                }
                                            }
                                        ?>

                                        <?php 
                                            }
                                        } 
                                        ?>
                                    </tbody>
                                </table>
                            </td>
                            <td colspan="2" valign="top">
                                
                                <table class="table report">
                                    <tbody>
                                        <?php 
                                        $totalhutang=0;
                                        foreach($groups as $group) { 
                                            if(substr($group->name,0,6)=="HUTANG")
                                            {
                                        ?>
                                        <tr>
                                            <td colspan="2"><strong><?=$group->name?></strong></td>
                                        </tr>
                                        <?php 
                                            foreach($headers as $header) { 
                                                if($header->accgroups_id==$group->id)
                                                {  

                                                    $saldo=@$details[$header->id]->t_kredit-@$details[$header->id]->t_debet;
                                                    $totalhutang+=$saldo;
                                        ?>
                                        <tr>
                                            <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<?=$header->name?></td>
                                        </tr>
                                        <?php 
                                                foreach($accounts as $account) 
                                                { 
                                                    if($account->accheaders_id==$header->id)
                                                    {  
                                                        $saldo=@$details[$account->id]->t_kredit-@$details[$account->id]->t_debet;
                                                        $totalhutang+=$saldo;
                                        ?>

                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$account->name?></td>
                                            <td><?=$this->convert($saldo)?></td>
                                        </tr>
                                        <?php
                                                    }
                                                }

                                                }
                                            }
                                        ?>

                                        <?php 
                                            }
                                        } 
                                        ?>
                                        <tr>
                                            <td>Total Hutang: </td>
                                            <td><strong><?=$this->convert($totalhutang)?></strong></td>
                                        </tr>
                                        <?php 
                                        $totalmodal=0;
                                        foreach($groups as $group) { 
                                            if(substr($group->name,0,5)=="MODAL")
                                            {
                                        ?>
                                        <tr>
                                            <td colspan="2"><strong><?=$group->name?></strong></td>
                                        </tr>
                                        <?php 
                                            foreach($headers as $header) { 
                                                if($header->accgroups_id==$group->id)
                                                {  

                                                    $saldo=@$details[$header->id]->t_kredit-@$details[$header->id]->t_debet;
                                                    $totalmodal+=$saldo;
                                        ?>
                                        <tr>
                                            <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<?=$header->name?></td>
                                        </tr>
                                        <?php 
                                                foreach($accounts as $account) 
                                                { 
                                                    if($account->accheaders_id==$header->id)
                                                    {  
                                                        $saldo=@$details[$account->id]->t_kredit-@$details[$account->id]->t_debet;
                                                        $totalmodal+=$saldo;
                                        ?>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$account->name?></td>
                                            <td><?=$this->convert($saldo)?></td>
                                        </tr>
                                        <?php
                                                    }
                                                }

                                                }
                                            }
                                        ?>

                                        <?php 
                                            }
                                        } 
                                        ?>
                                        <tr>
                                            <td>Total Modal: </td>
                                            <td><strong><?=$this->convert($totalmodal)?></strong></td>
                                        </tr>
                                        <?php 
                                        $laba=0;
                                        foreach($groups as $group) { 
                                            if($group->name=="PENDAPATAN"||$group->name=="HPP")
                                            {
                                                foreach($headers as $header) { 
                                                    if($header->accgroups_id==$group->id)
                                                    {  
                                                        foreach($accounts as $account) 
                                                        { 
                                                            if($account->accheaders_id==$header->id)
                                                            {

                                                                $saldo=@$details[$account->id]->t_kredit-@$details[$account->id]->t_debet;
                                                                $laba+=$saldo;
                                                            }
                                                        }
                                                    }
                                                }
                                            }elseif($group->name=="BIAYA"){
                                                foreach($headers as $header) { 
                                                    if($header->accgroups_id==$group->id)
                                                    {  

                                                        foreach($accounts as $account) 
                                                        { 
                                                            if($account->accheaders_id==$header->id)
                                                            {

                                                                $saldo=@$details[$account->id]->t_debet-@$details[$account->id]->t_kredit;
                                                                $laba-=$saldo;
                                                            }
                                                        }
                                                        
                                                    }
                                                }
                                            }
                                        } 
                                        ?>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;LABA / RUGI
                                            <td><strong><?=$this->convert($laba)?></strong></td>
                                        </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Total Aktiva: </td>
                            <td><strong><?=$this->convert($totalaktiva)?></strong></td>
                            
                            <td>Total Pasiva: </td>
                            <td><strong><?=$this->convert($totalhutang+$totalmodal+$laba)?></strong></td>
                                            
                        </tr>       
                    </tfoot>
                </table>    
            <hr style="padding-bottom:25px"/>
        </div>
    </div>
</div>