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
    <?=$this->section('content')?>
    <a href="javascript:window.print()" class="button print">Print</a>
    </div>
  </div>
<footer class="footer text-center"> <strong></strong></footer>     
</div>
<style>
    body {
        font-family: sans-serif;
        font-size: 90%;
    }

    table.report {
        font-size: 90%;
        border-collapse: collapse;
    }

    table.report th, table.report td {
        border: 1px solid #777;
        padding: 3px 5px;
    }

    tr.date-container > td {
        padding: 10px 5px 3px 5px;
        border: none;
    }

    table.header {
        font-size: 80%;
        border-collapse: collapse;
    }

    table.header th, table.header td {
        border: none;
        padding: 3px 5px;
    }

    .button{
        background-color: #ABABAB;
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