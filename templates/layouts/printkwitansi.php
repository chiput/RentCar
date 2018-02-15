<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<link rel="icon" type="image/png" sizes="16x16" href="<?=$this->baseUrl()?>/img/hp-favicon.png">

<title><?=$title?></title>
</head>
<body>
<table class="header">
  <tbody>
    <tr>
      <?php $key = key_encryptor('decrypt',$company['key']); ?>
      <td><img width="70" src="<?=$this->baseUrl()?>img/<?=$company['profile_logo']?>"></td>
      <td style="padding-left: 20px">
        <h2><?=encryptor('decrypt',$company['profile_name'],$key)?></h2>
        <p><?=encryptor('decrypt',$company['profile_address'],$key)?><br/>
        Phone : <?=$company['profile_phone']?> Fax : <?=$company['profile_fax']?><br/>
        Website : <?=$company['profile_website']?> Email : <?=$company['profile_email']?></p>
      </td>
    </tr>
  </tbody>
</table>
<hr/>
<div id="wrapper">
  <div id="page-wrapper">
    <div class="container-fluid">
    <!-- <a href="javascript:window.print()" class="button print">Print</a> -->
    <?=$this->section('content')?>
    <a href="javascript:window.print()" class="button print">Print</a>
    </div>
  </div>
<footer class="footer text-center"> <strong></strong></footer>     
</div>
<style>
    @import url(https://fonts.googleapis.com/css?family=Poppins:400,500,300,600,700);

    @font-face {
      font-family: 'Poppins';
      font-style: normal;
      font-weight: 400;
      src: url(https://fonts.gstatic.com/s/poppins/v1/2fCJtbhSlhNNa6S2xlh9GyEAvth_LlrfE80CYdSH47w.woff2) format('woff2');
      unicode-range: U+02BC, U+0900-097F, U+1CD0-1CF6, U+1CF8-1CF9, U+200B-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FB;
    }
    h1,
    h2,
    h3,
    td,tr,th
    {
      color: #2b2b2b;
      font-family: 'Poppins', sans-serif;
      margin: 10px 0;
      font-weight: 300;
    }
    h1 {
      line-height: 48px;
      font-size: 36px;
    }
    h2 {
      line-height: 36px;
      font-size: 24px;
    }
    h3 {
      line-height: 30px;
      font-size: 21px;
    }
    
    body {
        font-family: sans-serif;
        font-size: 90%;
    }

    table.report {
        border-collapse: collapse;
        width: 100%;
        font-size: 90%;
    }

    table.report th, table.report td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    tr.date-container > td {
        padding: 10px 5px 3px 5px;
        border: none;
    }

    table.header {
        font-size: 80%;
        border-collapse: collapse;
    }

    table th, table td {
        border: none;
        padding: 3px 5px;
    }

    .button{
        background-color: #ABABAB;
        margin-top: 5px;
        display: inline-block;
        padding:4px 8px;
        color:#000;
        text-decoration: none;
    }
    .button:hover{
        background-color: #008AFF;
        color: #fff;
    }

    @media print {
    .print {
        display:none;
    }
    }
</style>


<!-- /#wrapper -->
</body>
</html>
<?php
     function key_encryptor($action, $string) {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        //pls set your unique hashing key
        $secret_key = 'harmoni';
        $secret_iv = 'xyz';

        // hash
        $key = hash('sha256', $secret_key);
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        //do the encyption given text/string/number
        if( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if( $action == 'decrypt' ){
            //decrypt the given text/string/number
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    function encryptor($action, $string, $pass) {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        //pls set your unique hashing key
        $secret_key = $pass;
        $secret_iv = 'xyz';

        // hash
        $key = hash('sha256', $secret_key);
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        //do the encyption given text/string/number
        if( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if( $action == 'decrypt' ){
            //decrypt the given text/string/number
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }
?>