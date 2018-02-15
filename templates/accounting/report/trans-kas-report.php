<?php 
  // $this->layout('layouts/plain', [
  //   // app profile
  //   'title' => 'Laporan Transaksi Kas & Bank',
  //   'app_name' => $app_profile['name'],
  //   'author' => $app_profile['author'],
  //   'description' => $app_profile['description'],
  //   'developer' => $app_profile['developer'],
  //   // breadcrumb
  //   'main_location' => 'Akunting',
  //   'submain_location' => 'Laporan Transaksi Kas & Bank'
  // ]); 

  $totaldebet=0; 
  $totalkredit=0; 
  $arrType=[0,"Kas","Bank"];
?>
<?php 
    $this->layout('layouts/print', [
        // app profile
        'company' => $options,
        'title' => "Daftar Account",
    ]);
    function convert_date($date){
        $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
        return $date;
    } 
?>
<div class="row" >
    <div class="col-sm-12">
        <div class="white-box">
            <h3>LAPORAN TRANSAKSI KAS & BANK</h3>
                <h4 style="margin-top: -8px;">
                    <span>Tanggal:
                        <?php echo date('d-m-Y', strtotime($range['start'])); ?>
                        s/d
                        <?php echo date('d-m-Y', strtotime($range['end'])); ?>
                    </span>
                </h4>    
                <?php foreach ($trans as $tran) { ?>
                <div class="form-group" style="padding-top: 20px">
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <label class="col-md-6"> 
                                        <span class="help"> No. Bukti : <?=$tran->nobukti?></span> 
                                    </label>
                                </td>
                                <td>
                                    <label class="col-md-6"> 
                                        <span class="help"> Tanggal : <?=convert_date($tran->tanggal)?></span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="col-md-6"> 
                                        <span class="help"> User : <?=@$tran->user->name?></span><br/>
                                    </label>
                                </td>
                                <td>
                                    <label class="col-md-6"> 
                                        <span class="help"> Jenis : <?=$arrType[$tran->type]?></span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <label class="col-md-6"> 
                                        <span class="help"> Keterangan : <?=$tran->keterangan?></span>
                                    </label>
                                </td>
                            </tr>
                        </tbody>
                    </table>                
                </div>
                <table class="table table-bordered report" style="padding-bottom: 80px">
                        <thead>
                            <tr>
                                <th width="25">Transaksi</th>
                                <th width="25">Keterangan</th>
                                <th width="15">Debet</th>
                                <th width="15">Kredit</th>
                                <th width="20">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // $subtotaldebet=0;
                            // $subtotalkredit=0;
                            foreach($tran->details as $detail){ 
                                // $subtotaldebet+=$detail->debet;
                                // $subtotalkredit+=$detail->kredit;
                                ?>
                            <tr>
                                <td><?=$detail->acckastype->name?></td>
                                <td><?=$detail->remark?></td>
                                <td>
                                <?php echo @$detail->acckastype->accdebet->code?> || <?php echo @$detail->acckastype->accdebet->name?></td>
                                <td><?php echo @$detail->acckastype->acckredit->code?> || <?php echo @$detail->acckastype->acckredit->name?></td>
                                <td><?php echo $this->convert($detail->nominal);?></td>
                            </tr>
                            <?php } 
                            // $totaldebet+=$subtotaldebet; 
                            // $totalkredit+=$subtotalkredit; 
                            ?>
                        </tbody>
                </table>
                <!-- <hr style="padding-bottom:25px"/> -->
            <?php } ?>
        </div>
    </div>
</div> 