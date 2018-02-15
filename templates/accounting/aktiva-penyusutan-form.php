<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Penyusutan Aktiva',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Akunting',
    'submain_location' => 'Penyusutan Aktiva'
  ]); 
?>

<div class="error">
    <?php print_r(@$errors) ?>
</div>


<div class="row">
    <div class="col-sm-12">

        <?php if ($this->getSessionFlash('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $this->getSessionFlash('success'); ?>
        </div>
        <?php endif; ?>

        <?php if ($this->getSessionFlash('error')): ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $this->getSessionFlash('error'); ?>
        </div>
        <?php endif; 
        function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
        ?>

        <div class="white-box">

            <h3 class="box-title m-b-0">Penyusutan Aktiva</h3>
            <p class="text-muted m-b-30 font-13">Data Penyusutan Aktiva</p>
            <form class="form-horizontal" method="POST">

                <div class="form-group">
                    <label class="col-md-12"> 
                        <span class="help"> Periode Penyusutan </span>
                    </label>
                    <div class="col-md-6">
                    <select  class="form-control" name="month" >
                        <?php 
                            $months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                            foreach($months as $month => $name){ ?>
                                <option value="<?=$month+1?>"
                                <?=date('m')==$month+1?'selected="selected"':''?>
                                ><?=$name?></option>
                            <?php } 
                        ?>
                    </select>
                    </div>

                    <div class="col-md-6">
                    <select  class="form-control" name="year" >
                        <?php for($y=2015;$y<=date("Y");$y++){ ?>
                        <option value="<?=$y?>">
                            <?=$y?>
                        </option>
                        <?php } ?>
                    </select>
                    </div>
  
                        
                </div>
                                  <div class="form-group m-b-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Proses</button>
                        </div>
                    </div>
            </form>

            

            <hr />

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Bulan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($aktivajurnals as $aktivajurnal){ ?>
                    <tr>
                        <td><a href="<?=$this->pathFor('accounting-aktiva-penyusutan-delete',["id"=>$aktivajurnal->id])?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a> <?=convert_date($aktivajurnal->tanggal)?></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>
