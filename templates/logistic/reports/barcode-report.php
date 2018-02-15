<?php 
  $this->layout('layouts/plain', [
    // app profile
  ]); 

foreach($kode as $key=>$bs){
  echo '<div>';
  echo '<img src="data:image/png;base64,' . $barcode[$key] . '" alt="'.$nama[$key].'">';
  echo '<br/>';
  echo $bs;
  echo '<br/>';
  echo $nama[$key];
  echo '<br/><br/><br/><br/><br/>';
  echo '</div>';
}
?>
<style>
body{
  text-align: center;
}
div{
  float: left;
  margin: 20px;
}
</style>



