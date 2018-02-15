<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Pengembalian",
  ]); 
?>
<?php
    $total_rooms = 0;
    $total_add_charge = 0;
?>

<h3>RentCar</h3>

<table>
    <tr>
        <td>Pengembalian Code :</td>
        <td><?php echo $checkout->checkout_code ?></td>
    </tr>
</table>
<table  class="report" width="100%">
    <tdead>
        <tr>
            <td>Mobil</td>
            <td>Plat Nomor</td>
            <td>Peminjaman</td>
            <td>Pengembalian</td>
            <td>Pelanggan</td>
            <td>Peminjaman Code</td>
            <td>Price</td>
        </tr>
    </tdead>
    <tbody>
        <?php foreach ($checkout_detail as $cod): ?>
        <?php $checkin = explode(' ',$cod->reservationDetails->checkin_at);?>
        <?php $checkoutnya = explode(' ',$cod->reservationDetails->checkout_at);?>
        <tr>
            <td><?php echo $cod->reservationDetails->room->number ?></td>
            <td><?php echo $cod->reservationDetails->room->level ?></td>
            <td><?php echo convert_date($checkin[0])." ".substr($cod->reservationDetails->checkin_at,11,18) ?></td>
            <td><?php echo convert_date($checkoutnya[0])." ".substr($cod->reservationDetails->checkin_at,11,18) ?></td>
            <td><?php echo $cod->reservationDetails->reservation->guest->name ?></td>
            <td><?php echo $cod->reservationDetails->checkin_code ?></td>

            <!-- after -->
            <?php if($checkout->hiddenhrgkamar==1){?>
                <td>0</td>
            <?php } else { ?>
                <td><?php echo $this->convert($cod->reservationDetails->price+$cod->reservationDetails->priceExtra) ?></td>
            <?php } ?>
            <?php $total_rooms +=  $cod->reservationDetails->price;?>
            <!-- before -->
            <!--<td><?php //echo $this->convert($cod->reservationDetails->price+$cod->reservationDetails->priceExtra) ?></td>-->
            <?php //$total_rooms +=  $cod->reservationDetails->price+$cod->reservationDetails->priceExtra; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
    <?php
     function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
    ?>
<table style="float: left; margin-top: 10px; " width="100%">
    <tbody>
        <tr>
                <table>
                <tbody>
                    <tr>
                        <td>Total Price</td>
                        <?php if($checkout->hiddenhrgkamar==1){?>
                            <td>0</td>
                        <?php } else { ?>
                            <td><?php echo $this->convert($total_rooms); ?></td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td>Subtotal</td>
                        <?php if($checkout->hiddenhrgkamar==1){?>
                            <td><?php echo $this->convert($total_add_charge); ?></td>
                        <?php } else { ?>
                            <td><?php echo $this->convert($total_rooms+$total_add_charge); ?></td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td>Discount</td>
                        <td><?php echo $this->convert($checkout->discount); ?></td>
                    </tr>
                    <tr>
                        <td>Service Charge</td>
                        <td><?php echo $this->convert($checkout->service_charge); ?></td>
                    </tr>
                    <tr>
                        <td>Tax</td>
                        <td><?php echo $this->convert($checkout->tax_charge); ?></td>
                    </tr>
                    <tr>
                        <td>Deposit</td>
                        <td><?php echo $this->convert($checkout->deposit); ?></td>
                    </tr>
                    <tr>
                        <td>Refund</td>
                        <td><?php echo $this->convert($checkout->refund); ?></td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <?php if($checkout->hiddenhrgkamar==1){?>
                            <td><?php echo $this->convert($checkout->total-$total_rooms); ?></td>
                        <?php } else { ?>
                            <td><?php echo $this->convert($checkout->total); ?></td>
                        <?php } ?>
                    </tr>
                    </tbody>
                </table>
                <?php if($checkout->hiddenhrgkamar==1){?>
                <table>
                    <tr>
                        <td>Cash</td>
                        <td><?php echo $this->convert($checkout->cash); ?></td>
                    </tr>
                    <tr>
                        <td>Creditcard</td>
                        <td><?php echo $this->convert($checkout->creditcard_amount); ?></td>
                    </tr>
                    <tr>
                        <td>Change</td>
                        <td><?php echo $this->convert($checkout->payment_change); ?></td>
                    </tr>
                </table>
                <?php } ?>
            </td>
        </tr>    
    </tbody>
</table>
<table class="report" width="100%" style="margin-top: 20px;">
    <thead>
        <tr>
            <th width="30%" style="border: none;">Front Office</th>
            <th width="40%" style="border: none;"></th>
            <th width="30%" style="border: none;">Guest</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: center; border: none; "></br></br></br></br></br></td>
            <td style="text-align: center; border: none; "></br></td>
            <td style="text-align: center; border: none; "></br></td>
        </tr>
        <tr>
            <td style="text-align: center; border-top: none; border-left: none; border-right: none;"><?php echo $cod->reservationDetails->reservation->user->name ?></td>
            <td style="text-align: center; border: none;"></td>
            <td style="text-align: center; border-top: none; border-left: none; border-right: none;"><?php echo $cod->reservationDetails->reservation->guest->name ?></td>
        </tr>
    </tbody>
</table>

