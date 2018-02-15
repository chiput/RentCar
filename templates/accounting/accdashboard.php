<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Dashboard Accounting',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Accounting',
    'submain_location' => 'Dashboard'
  ]); 


// convert date
function convert_date($date){
    $exp = explode('-', $date);
    if (count($exp)==3) {
        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
    }
    return $date;
}
$dates = [];
?>

<div class="row">
        <div class="col-lg-12 col-sm-8 col-md-8 col-xs-12">
          <ol class="titledash">
            <li><a href="#">Dashboard</a></li>
            <li class="active"> / Accounting - Dashboard</li>
          </ol>
        </div>
    </div>
        <!-- /.col-lg-12 -->

      <!--row -->
      
      <!--row -->
      <div class="row">
        <div class="col-md-6 col-lg-6 col-sm-12">
          <div class="white-box">
            <div class="row jurnal-report">
              <div class="col-md-6 col-sm-6 col-xs-6">
                <?php 
                $currentMonth = date('m');
                $currentYear = date('Y');  
                $months = ['JANUARI','FEBRUARI','MARET','APRIL','MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','OKTOBER','NOVEMBER','DESEMBER'];
                ?>
                <h2 style="color: white;"><?=$months[$currentMonth-1]?> <?=$currentYear?></h2>
                <p style="color: white;">JURNAL REPORT</p>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table ">
                <thead>
                  <tr>
                    <th>No. Bukti</th>
                    <th>Tanggal</th>
                    <th>No. Jurnal</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                   <?php foreach ($jurnals as $no => $jurnal): ?>
                     <tr>
                       <td><?=$jurnal->nobukti?></td>
                       <td><span class="label label-megna label-rounded"><?=convert_date($jurnal->tanggal)?></span></td>
                       <td><?=$jurnal->code?></td>
                       <td><?=$jurnal->keterangan?></td>
                    </tr> 
                    <?php  endforeach;?>
                </tbody>
              </table>
          </div>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->
    <footer class="footer text-center"> 2016 &copy; Elite Admin brought to you by themedesigner.in </footer>

    <style type="text/css">
        .jurnal-report {
            background: #01c0c8;
            margin: 12px -25px;
            padding: 15px;
        }
        .titledash {
            padding: 8px 15px;
            margin-bottom: 20px;
            list-style: none;
            border-radius: 4px;
            font-size: 16px;
        }
        .titledash>.active {
            color: #777;
        }
        .titledash>li {
            display: inline-block;
        }
    </style>
