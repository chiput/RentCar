<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="#">
<meta name="author" content="#">
<link rel="icon" type="image/png" sizes="16x16" href="<?=$this->baseUrl()?>img/hp-favicon.png">
<title><?=$title?></title>
<!-- Bootstrap Core CSS -->
<link href="<?=$this->baseUrl()?>bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="<?=$this->baseUrl()?>css/list.css" rel="stylesheet">
<!-- Page plugins css -->
<link href="<?=$this->baseUrl()?>plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
<!-- Data table -->
<link href="<?=$this->baseUrl()?>plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<!-- Date picker plugins css -->
<link href="<?=$this->baseUrl()?>plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<!-- Daterange picker plugins css -->
<link href="<?=$this->baseUrl()?>plugins/bower_components/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
<link href="<?=$this->baseUrl()?>plugins/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<!-- Footable CSS -->
<link href="<?=$this->baseUrl()?>plugins/bower_components/footable/css/footable.core.css" rel="stylesheet">
<link href="<?=$this->baseUrl()?>plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
<!-- xeditable css -->
<link href="<?=$this->baseUrl()?>plugins/bower_components/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet" />
<!-- Select 2 -->
<link href="<?=$this->baseUrl()?>plugins/bower_components/custom-select/custom-select.css" rel="stylesheet" type="text/css" />
<link href="<?=$this->baseUrl()?>plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
<link href="<?=$this->baseUrl()?>plugins/bower_components/multiselect/css/multi-select.css"  rel="stylesheet" type="text/css" />
<!-- Menu CSS -->
<link href="<?=$this->baseUrl()?>plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
<!-- toast CSS -->
<link href="<?=$this->baseUrl()?>plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
<!-- morris CSS -->
<link href="<?=$this->baseUrl()?>plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
<!-- Clock CSS -->
<link href="<?=$this->baseUrl()?>/plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
<!-- animation CSS -->
<link href="<?=$this->baseUrl()?>css/animate.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="<?=$this->baseUrl()?>css/style-jobdesc.css" rel="stylesheet">
<!-- color CSS -->
<link href="<?=$this->baseUrl()?>css/colors/blue.css" id="theme"  rel="stylesheet">
<link rel="stylesheet" href="<?=$this->baseUrl()?>plugins/bower_components/dropify/dist/css/dropify.min.css">

<!-- jQuery -->
<script src="<?=$this->baseUrl()?>plugins/bower_components/jquery/dist/jquery.min.js"></script>

</head>
<body>

<div class="preloader hidden-print">
  <div class="cssload-speeding-wheel"></div>
</div>
<div id="wrapper">
<?php $this->insert('sections/header') ?>
  <!-- Left navbar-header end -->
<?php $activeUser = $this->getActiveUser();$_SESSION['id'] = $activeUser['id']; ?>
<!-- Left navbar-header end -->

  <!-- Page Content -->
    <div id="page-wrapper" style="min-height: 601px;">
    <!-- Header -->
     <div id="header" style="margin-left: 10px;">
            <div class="">
              <div class="btn-group col-xs-12">
                <button aria-expanded="false" data-toggle="dropdown" class="btn btn-infoheader dropdown-toggle waves-effect waves-light" type="button"><i class="icon-list fa-fw"></i>Board </button>

<!--                     <ul class="nav navbar-top-links navbar-left hidden-xs">
                      <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="icon-arrow-left-circle ti-menu"></i></a></li>
                      <li>
                        <form role="search" class="app-search hidden-xs">
                          <input type="text" placeholder="Search..." class="form-control">
                          <a href=""><i class="fa fa-search"></i></a>
                        </form>
                      </li>
                    </ul> -->

                <ul role="menu" class="dropdown-menu">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin: 0;">×</button>
                <br/>
                <li><i class="icon-list fa-fw"></i>Boards</li>
                  <?php foreach ($boardrecent as $board): ?>
                      <li><a href="/board/list/<?= $board->id; ?>"><?= $board->boardname; ?></a></li>
                  <?php endforeach; ?>
                <li class="divider" style="font-size: 1px;"></li>
                  <li><a href="#" data-target="#add-board" data-toggle="modal">Create new boards</a></li>
                </ul>
                <div id="add-board" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; padding-right: 17px;">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                              <h4 class="modal-title" id="myModalLabel">Add a Board</h4></div>
                          <div class="modal-body">
                              <form action="<?= $this->pathFor('save-board'); ?>" method="POST">
                                  <div class="form-group">
                                      <div class="col-md-10 m-b-20">
                                          <input type="text" name="boardname" class="form-control" placeholder="Add a Board . . . "> 
                                      </div>
                                  </div>
                                  <button type="submit" class="btn btn-info">Save</button>
                              </form>
                          </div>
                      </div>
                    </div>
                </div>
                <div class="right">

                 <div class="btn-group m-r-10">
                    <div class="addmember">
                        <button aria-expanded="true" class="btn btn-infoleft dropdown-toggle waves-effect waves-light" data-toggle="dropdown" style="width: 100%;"><span class="left"><i class="fa fa-user-plus" aria-hidden="true"></i> Add Member</span></button>
                        <ul role="menu" class="dropdown-menu" style="width: 250px;">
                          <form action="<?= $this->pathFor('member'); ?>" method="post">
                            <li>
                                <input type="text" class="form-control" name="addmember" placeholder="insert username">
                            </li>
                            <li class="divider"></li>
                            <button type="submit" class="btn btn-infoleft" style="width: 100%;"><span class="left"><i class="fa fa-user-plus" aria-hidden="true"></i> Add Member</span></button>

                          </form>
                        </ul>
                    </div>
                </div>
                <div class="btn-group m-r-10">
                    <div class="addmember">
                        <button aria-expanded="true" class="btn btn-infoleft" data-toggle="dropdown" style="width: 100%;"><span class="left"><i class="fa fa-archive" aria-hidden="true"></i> Archived Items</span></button>
                        <ul role="menu" class="dropdown-menu" style="width: 320px;">
                        <a href="#"><center><b>Archived</b><button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin: 0;">×</button></center></a>
                        <li class="divider"></li>
                          <!-- <form action="#" method="post" style="display: inline;">
                            <li>
                                <input type="text" class="form-control" name="addmember" placeholder="Search Archived..." style="width: 180px; display: inline;">
                                <a href="#"><u>Switch to lists</u></a>
                            </li>
                          </form> -->
                          <div class="myadmin-dd dd" id="nestable">
                            <?php foreach ($archives as $archive): ?>
                            <ol class="dd-list">
                              <li class="dd-item" data-id="1" style="display: 10px;">
                                <div class="dd-handle"><?= $archive->listname; ?> <span style="display: block; font-size: 12px; padding-top: 10px;"><i class="fa fa-archive" aria-hidden="true"></i> Archived</span> </div>
                                <a href="#"><u>Send to Board </u></a> - <a href="#"><u>Delete</u></a>
                              </li>  
                              <li class="divider"></li>
                            </ol>
                          <?php endforeach; ?>
                          </div>
                        </ul>
                    </div>
                </div>
                <div class="btn-group m-r-10">
                <div class="dropdown">
                <button id="allviews" aria-expanded="false" data-toggle="dropdown" class="btn btn-infoleft" type="button">... <u>Show Menu</u></button>
                <ul role="menu" id="style-1" class="dropdown-menu" style="margin-left: -180px; width: 310px; min-height: 520px; max-height: 520px;overflow: auto;">
                  <a href="#"><center><b>Menu</b><button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin: 0;">×</button></center></a>
                  <li class="divider"></li>
                    <?php foreach ($users as $user): ?>
                      <button class="btn btn-infomember dropdown-toggle waves-effect waves-light" type="button" title="<?= $user->name; ?>" style="text-transform: uppercase;"><?php $initial = substr($user->name, 0, 1); echo $initial[0];?></button>
                    <?php endforeach; ?>
                  <li class="divider"></li>
                  <li><i class="fa fa-indent" aria-hidden="true"></i> Activity</li>
                  <div id="allactiviy"></div>
                </ul>
                </div>
                </div>

                <script type="text/javascript">
                  $('#allviews').on('click', function(e) {
                       e.preventDefault();
                        jQuery.ajax({
                            url:'/board/activities/all/<?= @$boards->id;?>',
                            async: false,
                            type: 'GET',
                            success: function( data ){
                                 $('#allactiviy').html(data);
                            },
                            error: function (xhr, b, c) {
                                console.log("xhr=" + xhr + " b=" + b + " c=" + c);
                            }
                        });

                      });
                </script>

                <!-- <div class="btn-group m-r-10">
                  <div class="dropdown"  style="z-index: 99;">
                    <button aria-expanded="false" data-toggle="dropdown" class="btn btn-infoheader dropdown-toggle waves-effect waves-light" type="button"><i class="fa fa-bell-o" aria-hidden="true"></i></button>
                    <ul role="menu" class="dropdown-menu" style="margin-left: -420px; width: 500px; height: auto;">
                      <a href="#"><center><b>Menu</b><button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin: 0;">×</button></center></a>
                      <li class="divider"></li>
                      <li><a href="">See All Notifications</a></li>
                      <li><a href="">Change Notifications Email Frequency</a></li>
                      <li><a href="">Allow Desktop Notifications</a></li>
                    </ul>
                  </div>
                </div> -->
              </div>
              </div>
              </div>
              </div>
    <!-- content -->
     <div class="row bg-title" style="margin-left: 5px;">
        <div class="col-sm-6 col-xs-9">
          <?php $_SESSION['board'] = @$boards->id;?>
          <a href="#" id="inline-filename" data-type="text" data-pk="<?= @$boards->id; ?>" data-title="Enter filename" class="editable editable-click nameBoard" style="display: inline;"><span><?= @$boards->boardname; ?></span></a>
          <script type="text/javascript">
          $(function(){
            //inline
               $('#inline-filename').editable({
               url: '<?= $this->pathFor('save-board'); ?>',
               type: 'text',
               pk: <?= @$boards->id; ?>,
               name: 'boardname',
               title: 'Enter boardname',
               mode: 'inline'
             });

            });
          </script>
        </div>
      </div>
    <script type="text/javascript">
      window.onload=function(){
      document.getElementById("#scroll-auto-width").offsetWidth;
    }
    </script>
    <div id="style-1" class="container-fluid" style="flex-grow: 1;overflow-y: auto;position: relative;white-space: nowrap;padding: 0 0;margin: 0 25px;margin-bottom: 25px;">
    <div id="scroll-auto-width" class="scrollbarheight" id="style-1">
      <!-- isi content -->
        <?php foreach($lists as $list): ?>
        <div class="col-md-3-dsa">
          <div class="white-box">
      
              <a href="#" id="inline-namecard-<?= $list->id; ?>" data-type="text" data-pk="<?= $list->id?>" data-title="Enter namecard" class="editable editable-click liststyle" style="display: inline;"><?= $list->listname;?></a>
              <script type="text/javascript">
              $(function(){
                   $('#inline-namecard-<?= $list->id; ?>').editable({
                   url: '<?= $this->pathFor('save-list');?>',
                   type: 'text',
                   pk: <?= $list->id?>,
                   name: 'namelist',
                   title: 'Enter namelist',
                   mode: 'inline'
                 });

                });
              </script>
     
              
              <div class="panel-action">
              <div class="myadmin-dd dd" id="nestable">
                <ol id="card-list" class="dd-list">
                <div class="scrollbar" id="style-1">
                  <li class="dd-item " data-id="1">
                      <?php foreach ($list->details as $card):
                        ?>
                          <div class="dd-handle btn-block btn-default" data-toggle="modal" data-target=".bs-example-modal-lg-<?= $card->id; ?>"><?= $card->cardname;?><a href="#">
                          <i class="fa fa-pencil right btn btn-infoarchive" type="button"" aria-hidden="true"></i></a></div>
                          <div class="modal fade bs-example-modal-lg-<?= $card->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                          <!-- modal dialog -->
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin: 0;">×</button>
                                  <a href="#" id="inline-namejob-<?= $card->id; ?>" data-type="text" data-pk="<?= $card->id?>" data-title="Enter namecard" class="editable editable-click liststyle" style="display: inline;"><?= $card->cardname;?></a>
                                  <script type="text/javascript">
                                  $(function(){
                                       $('#inline-namejob-<?= $card->id; ?>').editable({
                                       url: '<?= $this->pathFor('save-cardname');?>',
                                       type: 'text',
                                       pk: <?= $card->id?>,
                                       name: 'namelist',
                                       title: 'Enter namelist',
                                       mode: 'inline'
                                     });

                                    });
                                  </script>
                                </div>
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col-lg-12">
                                      <div class="col-xs-9">
                                        <div class="form-group">
                                          <h4>Description</h4>
                                          <label id="card-<?= $card->id;?>" data-type="textarea" data-pk="<?= $card->id;?>" data-placeholder="Your comments here..." data-title="Enter comments" class="control-label"><?= $card->description; ?></label>
                                          <!-- akhir tampilan form edit -->
                                        </div>
                                        <div id="checknya-tampil<?= $card->id; ?>"></div>
                                        <div class="mdl-card__supporting-text">
                                        <form id="comments<?= $card->id;?>">
                                          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded" data-upgraded=",MaterialTextfield">
                                            <label class="control-label" for="textarea"><i class="ti-comments"></i> Add Comment</label>
                                            <br>
                                            <input type="text" name="idboard" value="<?php echo @$boards->id ?>" class="hide">
                                            <input type="text" name="idcard" value="<?= $card->id;?>" class="hide">
                                            <input type="text" name="iduser" value="<?= $_SESSION['id']; ?>" class="hide">
                                            <textarea name="comment" type="submit" class="form-control status-box mdl-textfield__input" id="textarea" rows="8" placeholder="Add your comment...."></textarea>
                                            <!-- <label class="mdl-textfield__label" for="sample3">Say something...please </label> -->
                                          </div>

                                          <button id="update" class="btn btn-add btn-block btn-success"> Comment</button>
                                        </form>
                                        <div id="activitynya-<?= $card->id; ?>">
                                          

                                        </div>
                                        <div id="comment-show<?= $card->id;?>" class="comment-center"></div>
                                        <script type="text/javascript">
                                         $('form#comments<?= $card->id;?>').submit(function( event ) {
                                            event.preventDefault();
                                            $.ajax({
                                                url: '<?= $this->pathFor('comment-save');?>',
                                                type: 'post',
                                                data: $('form#comments<?= $card->id;?>').serialize(), // Remember that you need to have your csrf token included
                                                dataType: 'json',
                                                success: function( _response ){
                                                    // Handle your response..
                                                },
                                                error: function( _response ){
                                                    // Handle error
                                                }
                                            });
                                            $('textarea.status-box.mdl-textfield__input').val('');
                                         });
                                         $('#comments<?= $card->id;?>').on('submit', function(e) {
                                            e.preventDefault();
                                            $.ajaxSetup({
                                                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
                                            });
                                            jQuery.ajax({
                                                url:'/comment/lihat/<?= $card->id;?>',
                                                async: false,
                                                type: 'GET',
                                                success: function( data ){
                                                     $('#comment-show<?= $card->id;?>').html(data);
                                                },
                                                error: function (xhr, b, c) {
                                                    console.log("xhr=" + xhr + " b=" + b + " c=" + c);
                                                }
                                            });

                                            jQuery.ajax({
                                                url:'/board/activities/lihat/<?= $card->id;?>',
                                                async: false,
                                                type: 'GET',
                                                success: function( data ){
                                                     $('#activitynya-<?= $card->id; ?>').html(data);
                                                },
                                                error: function (xhr, b, c) {
                                                    console.log("xhr=" + xhr + " b=" + b + " c=" + c);
                                                }
                                            });

                                          });
                                         $.ajaxSetup({
                                              headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
                                          });
                                          jQuery.ajax({
                                              url:'/comment/lihat/<?= $card->id;?>',
                                              async: false,
                                              type: 'GET',
                                              success: function( data ){
                                                   $('#comment-show<?= $card->id;?>').html(data);
                                              },
                                              error: function (xhr, b, c) {
                                                  console.log("xhr=" + xhr + " b=" + b + " c=" + c);
                                              }
                                          });

                                          jQuery.ajax({
                                                url:'/board/activities/lihat/<?= $card->id;?>',
                                                async: false,
                                                type: 'GET',
                                                success: function( data ){
                                                     $('#activitynya-<?= $card->id; ?>').html(data);
                                                },
                                                error: function (xhr, b, c) {
                                                    console.log("xhr=" + xhr + " b=" + b + " c=" + c);
                                                }
                                            });
                                        </script>
                                      </div>
                                      </div> 
                                      <div class="col-xs-3">
                                        <h3>Add</h3>
                                          <div class="dropdown open">
                                            <button type="button" class="dropdown-toggle btn waves-effect btn-infoleft" data-toggle="dropdown"><i class="fa fa-check-square-o"></i>  Checklist </button>

                                          <div class="dropdown-menu animated flipInY">
                                          <div class="panel-body">
                                          <div class="header">
                                              Add Checklist
                                          </div>
                                          <div class="form m-t-5">
                                            <form id="checknya<?= $card->id;?>" action="<?= $this->pathFor('save-checklist');?>" method="POST">
                                              <div class="form-body">
                                                  <div class="row">
                                                      <div class="form-group">
                                                        <label class="control-label">Title</label>
                                                        <input type="text" name="boardid" value="<?= $list->board; ?>" class="hidden">
                                                        <input type="text" name="userid" value="<?= $_SESSION['id']; ?>" class="hidden">
                                                        <input type="text" name="cardid" value="<?= $card->id; ?>" class="hidden">
                                                        <input type="text" id="checklistname" class="form-control" placeholder="add your checklist . . ." name="checklistname">
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="form-actions">
                                                  <button type="submit" class="btn waves-effect btn-add btn-infoleft text-left" style="max-width: 70px;">Add</button>
                                              </div>
                                            </form>
                                            <script type="text/javascript">
                                              $('form#checknya<?= $card->id;?>').submit(function( event ) {
                                                event.preventDefault();
                                                $.ajax({
                                                    url: '<?= $this->pathFor('save-checklist');?>',
                                                    type: 'post',
                                                    data: $('form#checknya<?= $card->id;?>').serialize(), // Remember that you need to have your csrf token included
                                                    dataType: 'json',
                                                    success: function( _response ){
                                                        // Handle your response..
                                                    },
                                                    error: function( _response ){
                                                        // Handle error
                                                    }
                                                });
                                                $('input#checklistname').val('');
                                             });
                                             $('#checknya<?= $card->id;?>').on('submit', function(e) {
                                                e.preventDefault();
                                                $.ajaxSetup({
                                                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
                                                });
                                                jQuery.ajax({
                                                    url:'/board/checklist/lihat/<?= $card->id;?>',
                                                    async: false,
                                                    type: 'GET',
                                                    success: function( data ){
                                                         $('#checknya-tampil<?= $card->id;?>').html(data);
                                                    },
                                                    error: function (xhr, b, c) {
                                                        console.log("xhr=" + xhr + " b=" + b + " c=" + c);
                                                    }
                                                });

                                                jQuery.ajax({
                                                    url:'/board/activities/lihat/<?= $card->id;?>',
                                                    async: false,
                                                    type: 'GET',
                                                    success: function( data ){
                                                         $('#activitynya-<?= $card->id; ?>').html(data);
                                                    },
                                                    error: function (xhr, b, c) {
                                                        console.log("xhr=" + xhr + " b=" + b + " c=" + c);
                                                    }
                                                });

                                              });
                                             $.ajaxSetup({
                                                  headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
                                              });
                                              jQuery.ajax({
                                                  url:'/board/checklist/lihat/<?= $card->id;?>',
                                                  async: false,
                                                  type: 'GET',
                                                  success: function( data ){
                                                       $('#checknya-tampil<?= $card->id;?>').html(data);
                                                  },
                                                  error: function (xhr, b, c) {
                                                      console.log("xhr=" + xhr + " b=" + b + " c=" + c);
                                                  }
                                              });
                                              jQuery.ajax({
                                                url:'/board/activities/lihat/<?= $card->id;?>',
                                                async: false,
                                                type: 'GET',
                                                success: function( data ){
                                                     $('#activitynya-<?= $card->id; ?>').html(data);
                                                },
                                                error: function (xhr, b, c) {
                                                    console.log("xhr=" + xhr + " b=" + b + " c=" + c);
                                                }
                                            });
                                            </script>
                                          </div>
                                          </div>
                                          </div>
                                          </div>
                                           <!-- button dueDate -->
                                          <div class="dropdown open">
                                            <button type="button" class="dropdown-toggle btn waves-effect btn-infoleft" data-toggle="dropdown"><i class="fa fa-calendar"></i> Due date</button>
                                              <div class="dropdown-menu animated flipInY">
                                                <div class="panel-body">
                                                <div class="header">
                                                    Change Due Date
                                                </div>
                                                <div class="form m-t-5">
                                                  <form id="dueate<?= $card->id; ?>" action="<?= $this->pathFor('save-card');?>" method="POST">
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="form-group">
                                                              <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                                                <input type="text" name="caard" value="<?= $card->id; ?>" class="hidden"/>
                                                                <input type="text" class="form-control" name="timenya">
                                                                <span class="input-group-addon"> <span class="glyphicon glyphicon-time"></span> </span> </div>
                                                            </div>
                                                            <div class="form-group">
                                                              <div class="input-group">
                                                                <input type="text" id="datepicker-autoclose" class="form-control mydatepicker" name="datenya" placeholder="mm/dd/yyyy">
                                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-actions">
                                                        <button type="submit" class="btn waves-effect btn-add btn-infoleft text-left" style="max-width: 70px;">Add</button>
                                                    </div>
                                                  </form>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                            <script type="text/javascript">
                                                $('form#dueate<?= $card->id;?>').submit(function( event ) {
                                                  event.preventDefault();
                                                  $.ajax({
                                                      url: '<?= $this->pathFor('save-card');?>',
                                                      type: 'post',
                                                      data: $('form#dueate<?= $card->id;?>').serialize(), // Remember that you need to have your csrf token included
                                                      dataType: 'json',
                                                      success: function( _response ){
                                                          // Handle your response..
                                                      },
                                                      error: function( _response ){
                                                          // Handle error
                                                      }
                                                  });
                                                  $('input#dateku').val('');
                                               });
                                            </script>

                                           <!-- button Attachment -->
                                           <div class="dropdown open">
                                            <button type="button" class="dropdown-toggle btn waves-effect btn-infoleft" data-toggle="dropdown"><i class="fa fa-paperclip"></i> Attachment</button>
                                              <div class="dropdown-menu animated flipInY">
                                                <div class="panel-body">
                                                <div class="header">
                                                    Attachment Add
                                                </div>
                                                <div class="form m-t-5">
                                                     <form method="POST" action="<?= $this->pathFor('attachment');?>" enctype="multipart/form-data">
                                                        <input type="text" name="idcard" value="<?= $card->id; ?>" class="hidden">
                                                        <input type="file" id="input-file-now" class="dropify" name="attachment">
                                                        <br/>
                                                        <button type="submit" class="dropdown-toggle btn waves-effect btn-infoleft"><i class="fa fa-paperclip"></i> Attachment</button>
                                                    </form>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                           
                                        <h3>Action</h3>
                                          <a class="btn waves-effect btn-infoleft" href="<?= $this->baseUrl();?>board/delete/card/<?= $list->board; ?>/<?= $card->id;?>"><i class="fa fa-trash-o"></i>  Archive</a>
                                      </div>
                                        </div>
                                        </div>
                                    </div>
                              </div>
                            </div>
                            <!-- modal dialog end -->
                              <script type="text/javascript">
                                $(function(){
                                     $('#card-<?= $card->id;?>').editable({
                                     url: '<?= $this->pathFor('save-card');?>',
                                     pk: <?= $card->id?>,
                                     name: 'carddesc',
                                     title: 'Enter card description',
                                     showbuttons: 'bottom',
                                     mode: 'inline',
                                     row: 5,
                                     cols: 10
                                   });

                                  });
                              </script>
                          </div>
                          <!-- tampil dialog comment end -->
                      <?php endforeach; ?>
                  </li>
                  <form action="<?= $this->pathFor('save-card'); ?>" method="POST">
                      <div id="addcard" class="m-t-15 lihat-<?= $list->id; ?> dn" style="display: none;">
                          <input type="text" name="userid" value="<?= $_SESSION['id'];?>" class="hidden">
                          <input type="text" name="board" value="<?php echo @$boards->id ?>" class="hidden">
                          <input type="text" name="idlist" class="hidden" value="<?= $list->id; ?>">
                          <textarea class="form-control form-control-line" name="cardname" rows="3"></textarea>
                          <button type="submit" class="btn btn-info m-t-20">Add</button> 
                        </div>
                    </form>
                  </div>
                    <a href="#addcard" class="btn btn-block btn-default m-t-10 show-<?= $list->id; ?>">Add a Job ...</a>
                </ol>
              </div>
            </div> 
          </div>
        </div>
          <script>
            $(document).ready(function(){
                $("a.show-<?= $list->id; ?>").click(function(){
                    $(".lihat-<?= $list->id; ?>").toggle();
                });
            });
          </script>
        <?php endforeach; ?>
        <div class="col-md-3-dsa">
            <button type="button" class="btn btn-block btn-rounded btn-default showtop" data-target="#add-list" data-toggle="modal">Add a List ...</button>
            <!-- Start an Alert -->
        </div>
        <div id="add-list" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; padding-right: 17px;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Add a List</h4></div>
                    <div class="modal-body">
                        <form action="<?= $this->pathFor('save-list'); ?>" method="POST">
                            <div class="form-group">
                                <div class="col-md-10 m-b-20">
                                    <input type="text" name="idboard" value="<?php echo @$boards->id ?>" class="hidden">
                                    <input type="text" name="iduser" value="<?= $_SESSION['id']; ?>" class="hidden">
                                    <input type="text" name="listname" class="form-control" placeholder="Add a List . . . "> 
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info">Save</button>
                        </form>
                    </div>
                </div>
                </div>
                </div>
                <!-- /.modal-content -->
                <div class="clear"></div>
            </div>
            <!-- /.modal-dialog -->
        </div>

      <div class="right-sidebar">
        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;"><div class="slimscrollright" style="overflow: hidden; width: auto; height: 100%;">
          <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>

        </div><div class="slimScrollBar" style="background: rgb(220, 220, 220); width: 5px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;"></div><div class="slimScrollRail" style="width: 5px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
      </div>
      <!-- /.right-sidebar -->
    </div>
    <!-- /.container-fluid -->
   <footer class="footer text-center"> <strong>Hospitality Platform</strong> &copy; <?=date('Y')?></footer>
  </div>
</div>

<!-- Bootstrap Core JavaScript -->
<script src="<?=$this->baseUrl()?>bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Menu Plugin JavaScript -->
<script src="<?=$this->baseUrl()?>plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
<!--slimscroll JavaScript -->
<script src="<?=$this->baseUrl()?>js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="<?=$this->baseUrl()?>js/waves.js"></script>
<!--Counter js -->
<script src="<?=$this->baseUrl()?>plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
<script src="<?=$this->baseUrl()?>plugins/bower_components/counterup/jquery.counterup.min.js"></script>
<!--Morris JavaScript -->
<script src="<?=$this->baseUrl()?>plugins/bower_components/raphael/raphael-min.js"></script>
<script src="<?=$this->baseUrl()?>plugins/bower_components/morrisjs/morris.js"></script>
<!-- Custom Theme JavaScript -->
<script src="<?=$this->baseUrl()?>js/custom.js"></script>
<script src="<?=$this->baseUrl()?>js/dashboard1.js"></script>
<!-- Sparkline chart JavaScript -->
<script src="<?=$this->baseUrl()?>plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
<script src="<?=$this->baseUrl()?>plugins/bower_components/jquery-sparkline/jquery.charts-sparkline.js"></script>
<script src="<?=$this->baseUrl()?>plugins/bower_components/toast-master/js/jquery.toast.js"></script>

<script src="<?=$this->baseUrl()?>plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
<!-- React JS -->
<script src="https://fb.me/react-with-addons-15.2.1.js"></script>
<script src="https://fb.me/react-dom-15.2.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.34/browser.min.js"></script>
<!-- Select2 -->
<script src="<?=$this->baseUrl()?>plugins/bower_components/custom-select/custom-select.min.js" type="text/javascript"></script>
<script src="<?=$this->baseUrl()?>plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?=$this->baseUrl()?>plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script src="<?=$this->baseUrl()?>plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$this->baseUrl()?>plugins/bower_components/multiselect/js/jquery.multi-select.js"></script>
<!-- Plugin JavaScript -->
<script src="<?=$this->baseUrl()?>plugins/bower_components/moment/moment.js"></script>
<!-- Date Picker Plugin JavaScript -->
<script src="<?=$this->baseUrl()?>plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- Date range Plugin JavaScript -->
<script src="<?=$this->baseUrl()?>plugins/bower_components/timepicker/bootstrap-timepicker.min.js"></script>
<script src="<?=$this->baseUrl()?>plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?=$this->baseUrl()?>plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.js"></script>

<script src="<?=$this->baseUrl()?>js/numeral.js"></script>
<script src="<?=$this->baseUrl()?>plugins/bower_components/nestable/jquery.nestable.js"></script>

<noscript>&lt;img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=m/hBm1akKd60bm" style="display:none" height="1" width="1" alt=""&gt;</noscript>

<!-- Rename File -->
<script type="text/javascript" src="<?=$this->baseUrl()?>plugins/bower_components/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

<script type="text/javascript">
var isconfirming = false;
  // load a language
  //numeral setting
  numeral.language('id', {
      delimiters: {
          thousands: '.',
          decimal: ','
      },
      abbreviations: {
          thousand: 'k',
          million: 'm',
          billion: 'b',
          trillion: 't'
      },
      ordinal : function (number) {
          return number === 1 ? 'er' : 'ème';
      },
      currency: {
          symbol: 'Rp'
      }
  });
  // switch between languages
  numeral.language('id');
</script>
<!--Style Switcher -->
<!-- <script src="<?=$this->baseUrl()?>plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script> -->
<!-- Footable -->
<script src="<?=$this->baseUrl()?>plugins/bower_components/footable/js/footable.all.min.js"></script>
<script src="<?=$this->baseUrl()?>plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>

<!-- VUEJS -->
<script src="<?=$this->baseUrl()?>js/vue.min.js"></script>
<script src="<?=$this->baseUrl()?>js/vue-resource.min.js"></script>
<script src="<?=$this->baseUrl()?>js/app/vue.checkout-add.js"></script>
<script src="<?=$this->baseUrl()?>js/app/vue.periodic-rate.js"></script>
<script src="<?=$this->baseUrl()?>js/app/vue.currency.js"></script>
<script src="<?=$this->baseUrl()?>js/app/vue.roomchange.js"></script>
<script src="<?=$this->baseUrl()?>js/app/vue.costListBuild.js"></script>
<script src="<?=$this->baseUrl()?>js/app/vue.roomrates.js"></script>
<script src="<?=$this->baseUrl()?>js/app/reservation.js"></script>
<script src="<?=$this->baseUrl()?>js/app/logistic-purchase-request.js"></script>

<!-- Clock Plugin JavaScript -->
<script src="<?=$this->baseUrl()?>plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.js"></script>
<!-- Date Picker Plugin JavaScript -->
<script src="<?=$this->baseUrl()?>plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?=$this->baseUrl()?>plugins/bower_components/dropify/dist/js/dropify.min.js"></script>
<script>
    $(document).ready(function(){
        // Basic
        $('.dropify').dropify();

        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove:  'Supprimer',
                error:   'Désolé, le fichier trop volumineux'
            }
        });

        // Used events
        var drEvent = $('#input-file-events').dropify();

        drEvent.on('dropify.beforeClear', function(event, element){
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element){
            alert('File deleted');
        });

        drEvent.on('dropify.errors', function(event, element){
            console.log('Has Errors');
        });

        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e){
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });
</script>
<script>
// Clock pickers
$('#single-input').clockpicker({
  placement: 'bottom',
  align: 'left',
  autoclose: true,
  'default': 'now'

});

$('.clockpicker').clockpicker({
    donetext: 'Done',
    
})
  .find('input').change(function(){
    console.log(this.value);
});

$('#check-minutes').click(function(e){
  // Have to stop propagation here
  e.stopPropagation();
  input.clockpicker('show')
      .clockpicker('toggleView', 'minutes');
});
if (/mobile/i.test(navigator.userAgent)) {
  $('input').prop('readOnly', true);
}

// Date Picker
    jQuery('.mydatepicker, #datepicker').datepicker();
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
      });
      
    jQuery('#date-range').datepicker({
        toggleActive: true
      });
    jQuery('#datepicker-inline').datepicker({
        
        todayHighlight: true
      });

</script>

<!--Style Switcher -->
<script src="<?=$this->baseUrl()?>plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</body>
</html>