<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Detail Status Mobil',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Frontdesk',
    'submain_location' => 'Detail Status Mobil'
  ]);

//print_r($room);
//$arrStatus=["Out Of Service","Dirty"];
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Frontdesk </h3>
            <p class="text-muted m-b-30">Detail Status Mobil Nomor : <strong><?=$room->number?></strong></p>
            <?php
                function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
            ?>
            <form class="form-horizontal" method="POST" >
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" name="rooms_id" value="<?=$rooms_id?>">
                        <div class="form-group">
                            <label class="col-md-3 control-label"> <span class="help"> Tanggal</span></label>
                            <div class="col-md-9">
                                <div class="input-daterange input-group" id="date-range" data-date-format="dd-mm-yyyy">
                                        <input  type="text" class="form-control" name="start" value="<?=($start)?>" >
                                    <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                                        <input type="text" class="form-control" name="end"
                                        value="<?=$end?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <button class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <a class="btn btn-success" data-toggle="modal" data-target="#statusModal" >Set Status</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="white-box">
            <div style="width:100%; overflow:auto">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Keterangan</th>  
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $d_start=strtotime($start);
                        $d_end=strtotime($end);
                        $dt=$d_start;
                        while($dt<=$d_end){

                            ?>
                            <tr>
                                <td>
                                <!--<a href="<?=$this->pathFor('frontdesk-roomstatus-detail',["rooms_id"=>$rooms_id,"start"=>$start,"end"=>$end])?>" data-toggle="tooltip" data-original-title="Detail"> <i  class="fa fa-pencil text-inverse m-r-10"></i></a> -->
                                <?=date("d-m-Y",$dt)?></td>
                                <td>
                                    <?php 
                                    /*
                                    if(isset($occupied[date('Y-m-d',$dt)])){
                                        echo "Occupied ";
                                    }elseif(isset($reserved[date('Y-m-d',$dt)])){
                                        echo "Reserved ";
                                    }else{
                                        echo "Vacant ";
                                    }
                                    */
                                    if(isset($status[date('Y-m-d',$dt)])){
                                        //echo $arrStatus[$status[date('Y-m-d',$dt)]->status];
                                        echo $status[date('Y-m-d', $dt)]->type->desc;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?=@$status[date('Y-m-d',$dt)]->remark?>
                                </td>
                            </tr>
                        <?php 
                            $dt=strtotime(date('Y-m-d',$dt)." +1 day");
                            } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="statusModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Status Mobil</h4>
                  </div>
                  <form class="form-horizontal" method="POST" action="<?=$this->pathFor("frontdesk-roomstatus-update",["rooms_id"=>$rooms_id,"start"=>($start),"end"=>($end)])?>">
                  <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="rooms_id" value="<?=$rooms_id?>">
                            <div class="form-group">
                                <label class="col-md-3 control-label"> <span class="help"> Tanggal</span></label>
                                <div class="col-md-9">
                                    <div class="input-daterange input-group" data-date-format="dd-mm-yyyy">
                                            <input  type="text" class="form-control" name="start" value="<?=($start)?>" >
                                        <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                                            <input type="text" class="form-control" name="end"
                                            value="<?=$end?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-3 control-label"> <span class="help"> Status</span></label>
                                <div class="col-md-9">
                                    <select class="form-control" name="status">
                                        <?php foreach ($roomstatus as $roomtype) { ?>
                                            <option value="<?=$roomtype->id?>"><?=$roomtype->desc?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-3 control-label"> <span class="help"> Keterangan</span></label>
                                <div class="col-md-9">  
                                    <textarea class="form-control" name="remark"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                  </div>
                  <div class="modal-footer">
                    <button class="btn-success btn">Set Status</button>
                    <a href="#" class="btn btn-info waves-effect" data-dismiss="modal">Close</a>
                  </div>
                  </form>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>