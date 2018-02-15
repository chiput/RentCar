<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => '',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => '',
    'submain_location' => '',
  ]);
?>

<p class="text-center">
    <img class="" src="<?=$this->baseUrl()?>img/hp-dashboard-bg.png" width="25%">
</p>
