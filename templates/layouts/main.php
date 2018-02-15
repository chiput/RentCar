<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="<?=$description?>">
<meta name="author" content="<?=$developer?>">
<link rel="icon" type="image/png" sizes="16x16" href="<?=$this->baseUrl()?>img/hp-favicon.png">
<title><?=$title?> - <?=$app_name?></title>
<!-- Bootstrap Core CSS -->
<link href="<?=$this->baseUrl()?>bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
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
<link href="<?=$this->baseUrl()?>css/style.css" rel="stylesheet">
<!-- color CSS -->
<link href="<?=$this->baseUrl()?>css/colors/blue.css" id="theme"  rel="stylesheet">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<!-- <script src="http://www.w3schools.com/lib/w3data.js"></script> -->


<!-- jQuery -->
<script src="<?=$this->baseUrl()?>plugins/bower_components/jquery/dist/jquery.min.js"></script>

</head>
<body>
<!-- Preloader -->
<div class="preloader hidden-print">
  <div class="cssload-speeding-wheel"></div>
</div>
<div id="wrapper">
    <?php $this->insert('sections/header') ?>
  <!-- Left navbar-header end -->
  <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 hidden">
                  <h4 class="page-title"><?=$title?></h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 hidden">
                  <?php if ( isset($main_location) && $main_location!='' ) { ?>
                  <ol class="breadcrumb">
                    <li><a href="#"><?=$main_location?></a></li>
                    <li class="active"><?=$submain_location?></li>
                  </ol>
                  <?php } ?>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div id="NotANumber" class="myadmin-alert myadmin-alert-icon myadmin-alert-click alert-danger myadmin-alert-top alerttop"> <i class="fa fa-ban"></i> Tolong Masukan Angaka !  <a href="#" class="closed">&times;</a> </div>

            <div class="container-fluid">
              <?=$this->section('content')?>
            </div>
            <footer class="footer text-center"> <strong>Hospitality Platform</strong> &copy; <?=date('Y')?></footer>
        </div>
      <!-- /#page-wrapper -->
    </div>
</div>
<!-- /#wrapper -->

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
<script src="<?=$this->baseUrl()?>js/react/react-with-addons.js"></script>
<script src="<?=$this->baseUrl()?>js/react/react-dom.js"></script>
<script src="<?=$this->baseUrl()?>js/react/browser.min.js"></script>
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

 $(document).ready(function() {
    // $.toast({
    //   heading: 'Welcome to Elite admin',
    //   text: 'Use the predefined ones, or specify a custom position object.',
    //   position: 'top-right',
    //   loaderBg:'#ff6849',
    //   icon: 'info',
    //   hideAfter: 3500,

    //   stack: 6
    // })
    //$('.myDataTable').DataTable({paging:false,pageLength:1000}); //paging causing confusion
    //delete confirmation
    $('.fa-close').parent().click(function(event) {
          return confirm('Klik ok untuk menghapus');
        });
    $('.myDataTable').on( 'init.dt', function () {
        //delete confirmation
        console.log($(this).find('.fa-close').parent().get());
          $(this).find('.fa-close').parent().unbind( "click" );

          $(this).find('.fa-close').parent().click(function(event) {

            return confirm('Klik ok untuk menghapus');
          });

    } ).DataTable({
      "order": []
    }); //paging causing confusion
    $('.footable').footable();
    $(".select2").select2();
    $('.input-daterange').datepicker({
      toggleActive: true
    });
    $('.mydatepicker').datepicker({
      autoclose:true,
      ignoreReadonly: false
    });
    $('.clockpicker').clockpicker({
        donetext: 'Done',
    });
  });

  function IsNumber(value,id){
    if(isNaN(value)){
      $("#"+id).focus();
      $("#NotANumber").fadeToggle(350);
      setTimeout(function(){ $("#NotANumber").fadeToggle(350); }, 1000);
    }
  }
  
  // var num = document.getElementById('format_Number');
  // num.addEventListener('keyup', function(e)
  // {
  //   if (num.value == "") {
  //     var s = 0;
  //     num.value = s.toLocaleString();
  //   }else{
  //     var n = format_number(this.value);
  //     var s = n.replace(/^0+/, '');
  //     num.value = s.toLocaleString();
  //   }
  // },false);

  // function format_number(number, prefix, thousand_separator, decimal_separator)
  // {
  //   var thousand_separator = thousand_separator || '.',
  //   decimal_separator = decimal_separator || ',',
  //   regex   = new RegExp('[^' + decimal_separator + '\\d]', 'g'),
  //   number_string = number.replace(regex, '').toString(),
  //   split   = number_string.split(decimal_separator),
  //   rest    = split[0].length % 3,
  //   result    = split[0].substr(0, rest),
  //   thousands = split[0].substr(rest).match(/\d{3}/g);
    
  //   if (thousands) {
  //     separator = rest ? thousand_separator : '';
  //     result += separator + thousands.join(thousand_separator);
  //   }
  //   result = split[1] != undefined ? result + decimal_separator + split[1] : result;
  //   return prefix == undefined ? result : (result ? prefix + result : '');
  // };

</script>
<!--Style Switcher -->
<!-- <script src="<?=$this->baseUrl()?>plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script> -->
<!-- Footable -->
<script src="<?=$this->baseUrl()?>plugins/bower_components/footable/js/footable.all.min.js"></script>
<script src="<?=$this->baseUrl()?>plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>

<!-- VUEJS -->
<script src="<?=$this->baseUrl()?>js/vue.min.js"></script>
<script src="<?=$this->baseUrl()?>js/vue-resource.min.js"></script>
<script src="<?=$this->baseUrl()?>js/curFormatter.js"></script>
<script src="<?=$this->baseUrl()?>js/app/vue.checkout-add.js"></script>
<script src="<?=$this->baseUrl()?>js/app/vue.periodic-rate.js"></script>
<script src="<?=$this->baseUrl()?>js/app/vue.currency.js"></script>
<script src="<?=$this->baseUrl()?>js/app/vue.roomchange.js"></script>
<script src="<?=$this->baseUrl()?>js/app/vue.costListBuild.js"></script>
<script src="<?=$this->baseUrl()?>js/app/vue.roomrates.js"></script>
<script src="<?=$this->baseUrl()?>js/app/reservation.js"></script>
<script src="<?=$this->baseUrl()?>js/app/housekeepingtemuan.js"></script>
<script src="<?=$this->baseUrl()?>js/app/logistic-stocktaking.js"></script>
<script src="<?=$this->baseUrl()?>js/app/logistic-loss-item.js"></script>
<script src="<?=$this->baseUrl()?>js/app/logistic-mutation.js"></script>
<script src="<?=$this->baseUrl()?>js/app/logistic-usage.js"></script>
<script src="<?=$this->baseUrl()?>js/app/resmenu-form.js"></script>
<script src="<?=$this->baseUrl()?>js/app/roomservice.js"></script>
<script src="<?=$this->baseUrl()?>js/app/housekeepingkembali.js"></script>
<script src="<?=$this->baseUrl()?>js/app/logistic-revision.js"></script>
<script src="<?=$this->baseUrl()?>js/app/housekeepingpinjam.js"></script>
<script src="<?=$this->baseUrl()?>js/app/housekeeping.js"></script>
<script src="<?=$this->baseUrl()?>js/app/housekeepingjenis.js"></script>
<script src="<?=$this->baseUrl()?>js/app/restoran/gudang.js"></script>
<script src="<?=$this->baseUrl()?>js/app/logistic-purchase-request.js"></script>
<script src="<?=$this->baseUrl()?>js/app/searchtabel.js"></script>
<script src="<?=$this->baseUrl()?>js/app/purchase-order.js"></script>
<script src="<?=$this->baseUrl()?>js/app/logistic-barcode.js"></script>
<script src="<?=$this->baseUrl()?>js/app/retur-order.js"></script>
<script src="<?=$this->baseUrl()?>js/app/laundry.js"></script>
<script src="<?=$this->baseUrl()?>js/app/agent-rate.js"></script>
<script src="<?=$this->baseUrl()?>js/app/neraca.js"></script>
<script src="<?=$this->baseUrl()?>js/app/jurnal.form.js"></script>
<script src="<?=$this->baseUrl()?>js/acckas-form.js"></script>
</body>
</html>
