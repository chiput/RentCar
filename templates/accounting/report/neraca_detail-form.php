<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Laporan Neraca Detail',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Akunting',
    'submain_location' => 'Laporan Neraca Detail'
  ]); 
?>

<div class="error">
    <?php print_r(@$errors) ?>
</div>

<div class="row">
    <div class="col-sm-12">
      <div class="white-box">

        <h3 class="box-title m-b-0">Laporan Neraca Detail</h3>
        <p class="text-muted m-b-20 font-13"> </p>
        <form class="form-horizontal" method="POST" target="_blank">

            <div class="form-group">
                <label class="col-md-12"> 
                    <span class="help"> Periode Laporan </span>
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
                <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Tampilkan</button>
                </div>
            </div>

            </div>
        
            
        </form>
      </div>
    </div>
</div>
