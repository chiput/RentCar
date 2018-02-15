<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Daftar Kamar",
  ]); 
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3>LAPORAN RIWAYAT TAMU</h3>
                <?php
                    function convert_date($date){
                        $exp = explode('-', $date);
                        if (count($exp)==3) {
                            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                        }
                        return $date;
                    }
                ?>
            <table class="table table-bordered report">
                <tbody>
                    <tr>
                        <td><label> <span class="help">Nama Tamu</span></label></td>
                        <td width="50%">: <?=$guest->name?></td>
                    </tr>
                    <tr>
                        <td><label> <span class="help"> Alamat</span></label></td>
                        <td>: <?=$guest->address?></td>
                    </tr>
                    <tr>                
                        <td><label> <span class="help"> Negara</span></label>
                        <td>: <?=$guest->country?></td>
                    </tr>
                    <tr>
                        <td><label> <span class="help"> Provinsi</span></label></td>
                        <td>: <?=$guest->state?></td>
                    </tr>
                    <tr>
                        <td><label> <span class="help"> Kota</span></label></td>
                        <td>: <?=$guest->city?></td>
                    </tr>
                    <tr>
                        <td><label> <span class="help"> Kode Pos</span></label></td>
                        <td>: <?=$guest->zipcode?></td>
                    </tr>
                    <tr>
                        <td><label><span class="help"> Telepon</span></label></td>
                        <td width="50%">: <?=$guest->phone?></td>
                    </tr>
                    <tr>
                        <td><label> <span class="help"> Fax</span></label></td>
                        <td>: <?=$guest->fax?></td>
                    </tr>
                    <tr>
                        <td><label> <span class="help"> Email</span></label></td>
                        <td>: <?=$guest->email?></td>
                    </tr>
                    <tr>
                        <td><label> <span class="help"> Jenis Kelamin</span></label></td>
                        <td>: <?=$guest->sex?></td>
                    </tr>
                    <tr>
                        <td><label> <span class="help"> Tanggal Lahir</span></label></td>
                        <td>: <?php echo convert_date(@$guest->date_of_birth) ?></td>
                    </tr>
                    <tr>
                        <td><label> <span class="help"> Jenis Identitas</span></label></td>
                        <td>: <?=$guest->idtype?></td>
                    </tr>
                    <tr>
                        <td><label> <span class="help"> Tanggal Berlaku</span></label></td>
                        <td>: <?php echo convert_date(@$guest->date_of_validation) ?></td>
                    </tr>
                    <tr>
                        <td><label> <span class="help"> Nomor Identitas</span></label></td>
                        <td>: <?=@$guest->idcode?></td>
                    </tr>
                </tbody>
            </table>                       
        </div>
        <div class="col-md-6">
            <h3>LAPORAN RIWAYAT TRANSAKSI</h3>
            <table class="table table-bordered report">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kamar</th>
                        <th>Item</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($addcharges as $addcharge){ ?>
                        <?php foreach($addcharge->detail as $detail){ ?>
                    <tr>
                        <td><?=convert_date($addcharge->tanggal);?></td>
                        <td><?=$addcharge->reservation_detail->room->number?></td>
                        <td><?=$detail->addchargetype->name?></td>
                        <td style="text-align: right;"><?=$this->convert($detail->qty)?></td>
                        <td style="text-align: right;"><?=$this->convert($detail->sell)?></td>
                        <td style="text-align: right;"><?=$this->convert($detail->qty*$detail->sell)?></td>
                        <td ><?=$detail->remark?></td>
                    </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <h3>LAPORAN CHECK IN</h3>
            <table class="table table-bordered report">
                <thead>
                    <tr>
                        <th>No Bukti</th>
                        <th>Tgl. Reservasi</th>
                        <th>Check In/Out</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($reservations as $reservation){ ?>
                    <tr>
                        <td><?=$reservation->nobukti?></td>
                        <td><?php echo convert_date(substr(@$reservation->tanggal,0,10))." ".substr(@$reservation->tanggal,11,18); ?></td>
                         <td><?php echo convert_date(substr(@$reservation->checkin,0,10))." ".substr(@$reservation->checkin,11,18); ?> /  <?php echo convert_date(substr(@$reservation->checkout,0,10))." ".substr(@$reservation->checkout,11,18); ?> </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
    </div>
</div>  