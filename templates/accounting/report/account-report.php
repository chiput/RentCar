<?php 
  // $this->layout('layouts/plain', [
  //   // app profile
  //   'title' => 'Laporan Daftar Account',
  //   'app_name' => $app_profile['name'],
  //   'author' => $app_profile['author'],
  //   'description' => $app_profile['description'],
  //   'developer' => $app_profile['developer'],
  //   // breadcrumb
  //   'main_location' => 'Akunting',
  //   'submain_location' => 'Laporan Daftar Account'
  // ]); 
?>
<?php 
  $this->layout('layouts/print', [
    // app profile
    'company' => $options,
    'title' => "Daftar Account",
  ]); 
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
        <h3>LAPORAN ACCOUNT</h3>
            <table class="table table-bordered report">
                <thead>
                    <tr>
                        <th>Grup</th>
                        <th>Header</th>
                        <th>No. Account</th>
                        <th>Nama</th>
                        <th>Tipe</th>
                    </tr>
                </thead>
                <tbody>
                 <?php foreach($headers as $header){ ?>
                    <tr class="active">
                        <td><strong><?=$header->accgroup->name?></strong></td>
                        <td><strong><?=$header->code?> <?=$header->name?></strong></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php 
                    $resourcearray = array();
                    $indexarray = array();
                    foreach($header->accounts as $account) {
                        //Get character information
                        $code = $account->code;
                        $name = $account->name;
                        $type = $account->type;
                        //and anything else you want to add goes here, of course
                        array_push($resourcearray, array('code' => $code, 'name' => $name, 'type' => $type));
                        array_push($indexarray, $code);
                    }
                    array_multisort($indexarray, $resourcearray);
                    foreach($resourcearray as $resource){ ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><?=$resource['code']?></td>
                        <td><?=$resource['name']?></td>
                        <td><?=$resource['type']?></td>
                    </tr>

                    <?php } ?>
                <?php } ?>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>