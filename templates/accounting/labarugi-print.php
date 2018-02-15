<?php 
    $this->layout('layouts/print', [
        // app profile
        'company' => $options,
        'title' => "Laba Rugi",
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
            <h3>Laporan LABA & RUGI</h3>
                <h4 style="margin-top: -8px;">
                    <span>Tanggal:
                        <?php echo date('d-m-Y', strtotime($range['start'])); ?>
                        s/d
                        <?php echo date('d-m-Y', strtotime($range['end'])); ?>
                    </span>
                </h4>
                <?php
                    // total pengeluaran script
                    $totalpengeluaran = 0;
                    foreach ($data as $data) { 
                        $totalpengeluaran += $data->nominal;
                    }

                    // total pendapatan script

                    //Checkout total pendapatan
                    foreach ($datas as $key => $data) {
                        $restorantedetail[$key] = 0;
                        $whitehousedetail[$key] = 0;
                        $spadetail[$key] = 0;
                        $telepondetail[$key] = 0;
                        $biayatambahandetail[$key] = 0;
                        $jumlah[$key] = 0;
                        $roomdetail[$key] = 0;

                        // set default nilai agar tidak muncul eror
                        $biayatambahan = 0;
                        $restorante = 0;
                        $whitehouse = 0;
                        $spa = 0;
                        $telepon = 0;

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
                    // white house total pendapatan
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

                     // total sum dari semua pendapatan
                     $fixtotal = $room + $restorante + $restorantes + $whitehouse + $whitehouses + $spa + $spa_total + $telepon + $biayatambahan;

                     // laba rugi perhitungan
                     $labarugi = $fixtotal - $totalpengeluaran;
                ?>
                <table class="table table-bordered report" width="100%">
                    <thead>
                        <tr>
                            <th>Keterangan</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                        <tbody>
                            <tr>
                                <td><strong>Pendapatan</strong></td>
                                <td>Rp. <?= $this->convert($fixtotal) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Pengeluaran</strong></td>
                                <td>Rp. <?= $this->convert($totalpengeluaran)?></td>
                            </tr>
                            <tr>
                                <td><strong>Laba/Rugi</strong></td>
                                <td>Rp. <?= $this->convert($labarugi)?></td>
                            </tr>
                    </tbody>
            </table>
        </div>
    </div>
</div>