<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Status Mobil',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Frontdesk',
    'submain_location' => 'Status Mobil'
  ]);

//print_r($reservations);
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Status Mobil</h3>
            <p class="text-muted m-b-30">Data Status Mobil</p>
            <p>
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal" >Deposit Baru</a>
            </p>
            <div style="width:100%; overflow:auto">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Mobil</th>
                            <?php 
                            $dtstart=strtotime($start);
                            $dtend=strtotime($end);
                            $dt=$dtstart;
                            while($dt<$dtend):
                            ?>
                            <th><?=date("Y-m-d",$dt)?></th>
                            <?php
                            $dt=strtotime(date("Y-m-d",$dt)." + 1 day");
                            endwhile;
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($rooms as $room){ ?>
                            <tr>
                                <td><?=$room->number?></td>
                                <?php 
                                $dt=$dtstart;
                                while($dt<$dtend):
                                ?>
                                <td>
                                <?php 

                                if( isset($reservations[$room->id][date("Y-m-d",$dt)]))
                                {
                                    echo "a";
                                }


                                ?>


                                </td>
                                <?php
                                $dt=strtotime(date("Y-m-d",$dt)." + 1 day");
                                endwhile;
                                ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

