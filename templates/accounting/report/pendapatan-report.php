<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => $judul,
  ]); 
?>

<?php
    function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }
?>
<h3><?= $judul ?></h3>
<h4 style="margin-top: -8px;">
Tanggal <?php echo $d_start ?> sampai <?php echo $d_end ?>
</h4>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <!-- rekap pendapatan -->
            <!-- validasi jika rekap pendapatan dan jika tidak -->
            <?php if ($identitas == 'rekap'){
                //Checkout total pendapatan
                foreach ($datas as $key => $data) {
                    $restorantedetail[$key] = 0;
                    $whitehousedetail[$key] = 0;
                    $spadetail[$key] = 0;
                    $telepondetail[$key] = 0;
                    $biayatambahandetail[$key] = 0;
                    $jumlah[$key] = 0;
                    $roomdetail[$key] = 0;

                    // identifikasi additional charge restoran dan biaya tambahan dan total room
                        foreach ($data->details as $det) {
                            foreach ($det->reservationDetails->additional_charges as $add) {
                                foreach ($add->detail as $addetail) {
                                    //biaya tambahan
                                    if($addetail->addchargetypes_id != 1 and $addetail->addchargetypes_id != 2 and $addetail->addchargetypes_id != 4 ){
                                        $biayatambahandetail[$key] += $add->ntotal;
                                        $biayatambahan = array_sum($biayatambahandetail);
                                    } 

                                    //restorante
                                    if($addetail->addchargetypes_id == 1 and strpos($add->nobukti, 'RI.') !== false){
                                        $restorantedetail[$key] = $restorantedetail[$key] + $addetail->sell;
                                        $restorante = array_sum($restorantedetail);
                                    }

                                    //whitehouse
                                    if($addetail->addchargetypes_id == 1 and strpos($add->nobukti, 'WH.') !== false){
                                        $whitehousedetail[$key] = $whitehousedetail[$key] + $addetail->sell;
                                        $whitehouse = array_sum($whitehousedetail);
                                    }

                                    //spa
                                    if($addetail->addchargetypes_id == 4 and strpos($add->nobukti, 'SPA.') !== false){
                                        $spadetail[$key] = $spadetail[$key] + $addetail->sell;
                                        $spa = array_sum($spadetail);
                                    }

                                    //Telepon
                                    if($addetail->addchargetypes_id == 2 and strpos($add->nobukti, 'TP.') !== false){
                                        $telepondetail[$key] = $telepondetail[$key] + $addetail->sell;
                                        $telepon = array_sum($telepondetail);
                                    }
                                }
                            }
                            //total room
                            $roomdetail[$key] += $det->reservationDetails->price;
                            $room = array_sum($roomdetail);
                        }
                }
                // Restorante total pendapatan
                $restorantes = 0;
                foreach ($ri as $data) { 
                    if($data->tunai || $data->kartubayar != 0) {
                        $restorantes += $data->tunai+$data->kartubayar;
                    }
                }
                $whitehouses = 0;
                foreach ($wh as $data) { 
                    if($data->tunai || $data->kartubayar != 0) {
                        $whitehouses += $data->tunai+$data->kartubayar; 
                    }
                }
                // Spa total pendapatan
                $spa_total = 0;
                foreach ($sp as $spas) {
                     if ($spas->tunai || $spas->kartubayar !=0) {
                         $spa_total += $spas->tunai+$spas->kartubayar;
                     }
                 }
                ?>
            <table class="table report">
                <thead>
                    <tr>
                        <th>Pendapatan</th>
                        <th>Room</th>
                        <th>Restorante Italia</th>
                        <th>White Horse</th>
                        <th>Spa</th>
                        <th>Telepon</th>
                        <th>Biaya Tambahan</th>
                        <?php if($identitas == 'checkout') { ?>
                            <th>Jumlah</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Restorante Italia</td>
                        <td>-</td>
                        <td><?php if(isset($restorantes)){ if($restorantes != 0 ){ echo 'Rp.'.$this->convert($restorantes);} else { echo '-';} } ?></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>White House</td>
                        <td>-</td>
                        <td>-</td>
                        <td><?php if(isset($whitehouses)){ if($whitehouses != 0){ echo 'Rp.'.$this->convert($whitehouses);}  else { echo '-';} }?></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Spa</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td><?php if(isset($spa_total)){ if($spa_total != 0){ echo 'Rp.'.$this->convert($spa_total);}  else { echo '-';} }?></td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Checkout</td>
                        <td><?php if(isset($room)){ echo 'Rp.'. $this->convert($room);} else { echo '-';};?></td>
                        <td><?php if(isset($restorante)){ echo 'Rp.'. $this->convert($restorante);} else { echo '-';}?></td>
                        <td><?php if(isset($whitehouse)){ echo 'Rp.'. $this->convert($whitehouse);} else { echo '-';}?></td>
                        <td><?php if(isset($spa)){ echo 'Rp.'. $this->convert($spa);} else { echo '-';}?></td>
                        <td><?php if(isset($telepon)){ echo 'Rp.'. $this->convert($telepon);} else { echo '-';}?></td>
                        <td><?php if(isset($biayatambahan)){ echo 'Rp.'. $this->convert($biayatambahan);} else { echo '-';}?></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th style="text-align: left;">Pendapatan</th>
                        <td><?php if(isset($room)){ echo 'Rp.'. $this->convert($room);} else { echo '-';}?></td>
                        <td><?php if(isset($restorante)){ echo 'Rp.'. $this->convert($restorante+$restorantes);} else { echo '-';}?></td>
                        <td><?php if(isset($whitehouse)){ echo 'Rp.'. $this->convert($whitehouse+$whitehouses);} else { echo '-';}?></td>
                        <td><?php if(isset($spa)){ echo 'Rp.'. $this->convert($spa+$spa_total);} else { echo '-';}?></td>
                        <td><?php if(isset($telepon)){ echo 'Rp.'. $this->convert($telepon);} else { echo '-';}?></td>
                        <td><?php if(isset($biayatambahan)){ echo 'Rp.'. $this->convert($biayatambahan);} else { echo '-';}?></td>
                    </tr>
                </tfoot>
            </table>
            <?php } else { ?>
            <!-- end rekap pendapatan -->
            <table class="table report">
                <thead>
                    <tr>
                        <th>No Bukti</th>
                        <th>Room</th>
                        <th>Restorante Italia</th>
                        <th>White Horse</th>
                        <th>Spa</th>
                        <th>Telepon</th>
                        <th>Biaya Tambahan</th>
                        <?php if($identitas == 'checkout') { ?>
                            <th>Jumlah</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <!-- -Jika identias restorante -->
                    <?php if($identitas == 'restorante') {
                        $restorante = 0;
                        foreach ($datas as $data) { 
                            if($data->tunai || $data->kartubayar != 0) {
                                $restorante += $data->tunai+$data->kartubayar; ?>
                                <tr>
                                    <td><?= $data->nobukti;?></td>
                                    <td>-</td>
                                    <td><?php echo 'Rp.'.$this->convert($data->tunai+$data->kartubayar);?></td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                        <?php
                            } 
                        } 
                    // jika identitas whitehouse
                    } elseif($identitas == 'whitehouse') {
                        $whitehouse = 0;
                        foreach ($datas as $data) { 
                            if($data->tunai || $data->kartubayar != 0) {
                                $whitehouse += $data->tunai+$data->kartubayar; ?>
                                <tr>
                                    <td><?= $data->nobukti;?></td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td><?php echo 'Rp.'. $this->convert($data->tunai+$data->kartubayar)?></td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                        <?php
                            } 
                        } 
                        //jika identitasnya spa
                    } elseif($identitas == 'spa') {
                        $spa = 0;
                        foreach ($datas as $data) { 
                            if($data->tunai || $data->kartubayar != 0) {
                                $spa += $data->tunai+$data->kartubayar; ?>
                                <tr>
                                    <td><?= $data->nobukti;?></td>
                                    <td>-</td>
                                    <td>-</td> 
                                    <td>-</td>
                                    <td><?php echo 'Rp.'.$this->convert($data->tunai+$data->kartubayar);?></td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                        <?php
                            } 
                        } 
                    } elseif($identitas == 'checkout') {
                        foreach ($datas as $key => $data) { ?>
                            <?php 
                            $restorantedetail[$key] = 0;
                            $whitehousedetail[$key] = 0;
                            $spadetail[$key] = 0;
                            $telepondetail[$key] = 0;
                            $biayatambahandetail[$key] = 0;
                            $jumlah[$key] = 0;
                            $roomdetail[$key] = 0;

                            // identifikasi additional charge restoran dan biaya tambahan dan total room
                                foreach ($data->details as $det) {
                                    foreach ($det->reservationDetails->additional_charges as $add) {
                                        foreach ($add->detail as $addetail) {
                                            //biaya tambahan
                                            if($addetail->addchargetypes_id != 1 and $addetail->addchargetypes_id != 2){
                                                $biayatambahandetail[$key] += $add->ntotal;
                                                $biayatambahan = array_sum($biayatambahandetail);
                                            } 

                                            //restorante
                                            if($addetail->addchargetypes_id == 1 and strpos($add->nobukti, 'RI.') !== false){
                                                $restorantedetail[$key] = $restorantedetail[$key] + $addetail->sell;
                                                $restorante = array_sum($restorantedetail);
                                            }

                                            //whitehouse
                                            if($addetail->addchargetypes_id == 1 and strpos($add->nobukti, 'WH.') !== false){
                                                $whitehousedetail[$key] = $whitehousedetail[$key] + $addetail->sell;
                                                $whitehouse = array_sum($whitehousedetail);
                                            }

                                            //spa
                                            if($addetail->addchargetypes_id == 4 and strpos($add->nobukti, 'SPA.') !== false){
                                                $spadetail[$key] = $spadetail[$key] + $addetail->sell;
                                                $spa = array_sum($spadetail);
                                            }

                                            //Telepon
                                            if($addetail->addchargetypes_id == 2 and strpos($add->nobukti, 'TP.') !== false){
                                                $telepondetail[$key] = $telepondetail[$key] + $addetail->sell;
                                                $telepon = array_sum($telepondetail);
                                            }
                                        }
                                    }
                                    //total room
                                    $roomdetail[$key] += $det->reservationDetails->price;
                                    $room = array_sum($roomdetail);
                                }
                            // jumlah per 1 baris
                            $jumlah[$key] = $biayatambahandetail[$key] + $restorantedetail[$key] +  $whitehousedetail[$key] + $spadetail[$key] + $telepondetail[$key] + $roomdetail[$key];
                            $total = array_sum($jumlah);
                            ?>
                                <tr>
                                    <td><?= $data->checkout_code;?></td>
                                    <td><?php if($roomdetail[$key] != 0){ echo 'Rp.'.$this->convert($roomdetail[$key]);} else { echo '-';}?></td>
                                    <td><?php if($restorantedetail[$key] != 0){ echo 'Rp.'.$this->convert($restorantedetail[$key]);} else { echo '-';}?></td>
                                    <td><?php if($whitehousedetail[$key] != 0){ echo 'Rp.'.$this->convert($whitehousedetail[$key]);} else { echo '-';}?></td>
                                    <td><?php if($spadetail[$key] != 0){ echo 'Rp.'. $this->convert($spadetail[$key]);} else { echo '-';}?></td>
                                    <td><?php if($telepondetail[$key] != 0){ echo 'Rp.'. $this->convert($telepondetail[$key]);} else { echo '-';}?></td>
                                    <td><?php if($biayatambahandetail[$key] != 0){ echo 'Rp.'. $this->convert($biayatambahandetail[$key]);} else { echo '-';}?></td>
                                    <td><?php if($jumlah[$key] != 0){ echo 'Rp.'. $this->convert($jumlah[$key]);} else { echo '-';}?></td>
                                </tr>
                        <?php
                        } 
                    } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total Pendapatan</th>
                        <td><?php if(isset($room)){ echo 'Rp.'. $this->convert($room);} else { echo '-';}?></td>
                        <td><?php if(isset($restorante)){ echo 'Rp.'. $this->convert($restorante);} else { echo '-';}?></td>
                        <td><?php if(isset($whitehouse)){ echo 'Rp.'. $this->convert($whitehouse);} else { echo '-';}?></td>
                        <td><?php if(isset($spa)){ echo 'Rp.'. $this->convert($spa);} else { echo '-';}?></td>
                        <td><?php if(isset($telepon)){ echo 'Rp.'. $this->convert($telepon);} else { echo '-';}?></td>
                        <td><?php if(isset($biayatambahan)){ echo 'Rp.'. $this->convert($biayatambahan);} else { echo '-';}?></td>
                        <?php if($identitas == 'checkout') { ?>
                            <td><?php if(isset($total)){ echo 'Rp.'. $this->convert($total);} else { echo '-';}?></td>
                        <?php } ?>
                    </tr>
                </tfoot>
            </table>
            <?php } ?>
            </center>
        </div>
    </div>
</div>
<style type="text/css">
    table td {
        padding: 8px !important;
    }
</style>