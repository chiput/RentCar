<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<link rel="icon" type="image/png" sizes="16x16" href="<?=$this->baseUrl()?>/img/hp-favicon.png">

<title><?=$title?></title>
</head>
<body>
<div style="margin-top: 180px;"></div>
<!-- <table class="header">
  <tbody>
    <tr>
      <td><img width="70" src="<?=$this->baseUrl()?>img/<?=$company['profile_logo']?>"></td>
      <td style="padding-left: 20px">
        <h2><?=$company['profile_name']?></h2>
        <p><?=$company['profile_address']?><br/>
        Phone : <?=$company['profile_phone']?> Fax : <?=$company['profile_fax']?><br/>
        Website : <?=$company['profile_website']?> Email : <?=$company['profile_email']?></p>
      </td>
    </tr>
  </tbody>
</table>
<hr/> -->
<div id="wrapper">
  <div id="page-wrapper">
    <div class="container-fluid">
    <!-- <a href="javascript:window.print()" class="button print">Print</a> -->
    <?=$this->section('content')?>
    <a href="javascript:window.print()" class="button print">Print</a>
    <a href="<?php echo $this->pathFor('kasirwh-add'); ?>" class="button print">Transaksi Baru</a>
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
