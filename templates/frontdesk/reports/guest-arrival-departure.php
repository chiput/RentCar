<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Daftar Tamu In House",
  ]); 
?>
<table class="report">
    <thead>
        <tr>
            <th>No</th>
            <th width="80px">No. Kamar</th>
            <th width="250px">Nama Tamu</th>
            <th width="125px">Negara</th>
            <th width="100px">Checkin</th>
            <th width="100px">Checkout</th>
            <th width="70px">Agent</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $i = 1;
            foreach ($guests as $guest):  ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $guest->number; ?></td>
                <td><?=$guest->name?></td>
                <td><?php echo $guest->country; ?></td>
                <td><?php $x = explode(" ",$guest->checkin); echo $newDate = date("d-m-Y", strtotime($x[0]));?></td>
                <td><?php $z = explode(" ",$guest->checkout); echo $newDate = date("d-m-Y", strtotime($z[0]));?></td>
                <td><?php foreach ($guest->agent($guest->res) as $agent):
                        echo $agent->name;
                endforeach; ?></td>
            </tr>
        <?php $i++; endforeach; ?>
    </tbody>
</table>