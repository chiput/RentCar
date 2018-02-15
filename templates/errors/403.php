<?php
$this->layout('layouts/main', [
  // app profile
  'title' => '403 Access Forbidden',
  'app_name' => @$app_profile['name'],
  'author' => @$app_profile['author'],
  'description' => @$app_profile['description'],
  'developer' => @$app_profile['developer'],
  // breadcrumb
  'main_location' => 'Error',
  'submain_location' => 'Access Forbidden'
]);
?>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Akses Ditolak</h3>
            <p class="m-b-5">Mohon maaf saat ini halaman ini tidak tersedia untuk Anda.</p>
            <p class="m-b-5">Jika Anda berpikir ini sebuah kesalahan harap menghubungi sistem administrator.</p>
        </div>
    </div>
</div>
