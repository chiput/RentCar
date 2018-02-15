<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Kurs Mata Uang',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Akunting',
    'submain_location' => 'Kurs Mata Uang'
  ]); 

?>

<?php if ($this->getSessionFlash('success')): ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('success'); ?>
</div>
<?php endif; ?>
<?php if ($this->getSessionFlash('error_messages')): ?>
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('error_messages'); ?>
</div>
<?php endif; ?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Kurs Mata Uang</h3>
            <p class="text-muted m-b-30">Data kurs</p>
            <form class="form" method="POST">
                <div class="form-group">
                    <label class="col-md-12"> <span class="help"> Periode</span></label>
                    <div class="col-md-6">
                        <div class="form-group">
                            <select name="month" class="form-control">
                                <?php 
                                for($m=1;$m<=12;$m++){?>
                                <option value="<?=$m?>" <?=$month==$m?'selected="selected"':''?>>
                                    <?=date("F",strtotime("2015-12-01 +".$m." months"))?>
                                </option>
                                <?php }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <select name="year" class="form-control">
                                <?php 
                                for($y=2016;$y<=2021;$y++){?>
                                <option value="<?=$y?>" <?=$year==$y?'selected="selected"':''?>>
                                <?=$y?>
                                </option>
                                <?php }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                    <div class="form-group">
                        <button class="btn btn-info">Filter</button>
                    </div>
                    </div>
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kurs</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $dt_start=strtotime($year."-".$month."-01");
                    $dt_end=strtotime(date("Y-m-t",$dt_start));
                    $dt=$dt_start;
                    while($dt<=$dt_end){
                        $curdate=date("Y-m-d",$dt);
                    ?>
                        <tr>
                            <td><?=date("Y-m-d",$dt)?></td>
                            <td><input name="rate[<?=$curdate?>]" 
                            value="<?=isset($rates[$curdate])?$rates[$curdate]:0?>" 
                            class="form-control" /></td>
                        </tr>
                    <?php 
                    $dt=strtotime(date("Y-m-d",$dt)." +1 day");
                    }
                    ?>
                    </tbody>
                </table>
                    
                <div class="form-group">
                    <button class="btn btn-success">Simpan</button>
                </div>
            </form>
            
        </div>
    </div>
</div>
