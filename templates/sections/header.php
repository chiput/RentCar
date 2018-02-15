<?php
    $activeUser = $this->getActiveUser();
    // $this->menuLink();
?>
<!-- Navigation -->
  <nav class="navbar navbar-default navbar-static-top m-b-0 hidden-print">
    <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
      <div class="top-left-part"><a class="logo" href="<?=$this->baseUrl()?>"><b><img src="<?=$this->baseUrl()?>plugins/images/hp-dashboard-60x60.png" alt="home"></b><span class="hidden-xs" style=""><img src="<?=$this->baseUrl()?>plugins/images/text-hp.png" alt="home"></span></a></div>
      <ul class="nav navbar-top-links navbar-left hidden-xs">
        <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="icon-arrow-left-circle ti-menu"></i>')?></li>
      </ul>
      <ul class="nav navbar-top-links navbar-right pull-right">
        <li class="dropdown">
            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#">
                <img src="<?=$this->baseUrl()?>plugins/images/users/avatar.png" alt="user-img" width="36" class="img-circle">
                <b class="hidden-xs"> <?php echo $activeUser['name'] ?> </b>
            </a>
          <ul class="dropdown-menu dropdown-user animated">
            <li><?=$this->menuLink('setup-user-profile',['id' => $activeUser['id']],'<i class="ti-user"></i> My Profile')?></li>
            <li><?=$this->menuLink('logout',[],'<i class="fa fa-power-off"></i> Logout')?></li>
          </ul>
          <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
      </ul>
    </div>
    <!-- /.navbar-header -->
    <!-- /.navbar-top-links -->
    <!-- /.navbar-static-side -->
  </nav>
  <!-- Left navbar-header -->
  <div class="navbar-default sidebar hidden-print" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">
        <ul class="nav" id="side-menu">
            <li class="emak"><a href="#" class="waves-effect"><i class="fa fa-automobile fa-fw"></i> <span class="hide-menu">Rent Car <span class="fa arrow"></span></span></a>
              <ul class="nav nav-second-level">
                <li><?=$this->menuLink('frontdesk-guest',[],'Pelanggan')?></li>
                <li><?=$this->menuLink('frontdesk-agent',[],'Sopir')?></li>
                <li class="emak"><a href="javascript:void(0)" class="waves-effect">Mobil </a><span class="fa arrow"></span>
                  <ul class="nav nav-third-level">
                    <li><?=$this->menuLink('setup-room',[],'Data Mobil')?></li>
                    <li><?=$this->menuLink('setup-room-type',[],'Jenis Mobil')?></li>
                    <li><?=$this->menuLink('setup-room-status-type',[],'Jenis Status Mobil')?></li>
                    </ul>
                  </li>
                  <li><?=$this->menuLink('frontdesk-roomstatus',[],'Status Mobil')?></li>
                <li class="emak"><a href="javascript:void(0)" class="waves-effect">Transaksi </a><span class="fa arrow"></span>
                  <ul class="nav nav-third-level">
                    <li><?=$this->menuLink('frontdesk-reservation',[],'Reservasi')?></li>
                    <li><?=$this->menuLink('frondesk-checkingroup',[],'Peminjaman')?></li>
                    <li><?=$this->menuLink('frondesk-checkout',[],'Pengembalian')?></li>
                    </ul>
                  </li>
                <li><?=$this->menuLink('frontdesk-reservation-chart-filter',[],'Reservation Chart')?></li>
                <li class="emak"><a href="javascript:void(0)" class="waves-effect">Laporan </a><span class="fa arrow"></span>
                  <ul class="nav nav-third-level">
                    <li><?=$this->menuLink('frontdesk-report-list-rooms',[],'Daftar Mobil')?></li>
                    <li><?=$this->menuLink('frontdesk-report-guests',[],'Daftar Pelanggan')?></li>
                    <li><?=$this->menuLink('frontdesk-report-reservation-filter',[],'Laporan Reservasi')?></li>
                    <li><?=$this->menuLink('frontdesk-report-checkin-filter',[],'Laporan Peminjaman')?></li>
                    <li><?=$this->menuLink('frontdesk-report-checkout-filter',[],'Laporan Pengembalian')?></li>
                    <li><?=$this->menuLink('frontdesk-report-cashier-filter',[],'Laporan Kasir')?></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li class="emak"><a href="#" class="waves-effect"><i class="ti-briefcase fa-fw"></i> <span class="hide-menu">Management <span class="fa arrow"></span></span></a>
              <ul class="nav nav-second-level">
                <li class="emak"><a href="javascript:void(0)" class="waves-effect">Mobil </a><span class="fa arrow"></span>
                  <ul class="nav nav-third-level">
                    <li><?=$this->menuLink('room-availabel',[],'Ketersediaan Mobil')?></li>
                    <li><?=$this->menuLink('room-favorite',[],'Mobil Terfavorit')?></li>
                  </ul>
                </li>
                <li class="emak"><a href="javascript:void(0)" class="waves-effect">Pelanggan </a><span class="fa arrow"></span>
                  <ul class="nav nav-third-level">
                    <li><?=$this->menuLink('favorite-guests',[],'Pelanggan Terfavorit')?></li>
                    <!-- <li><?=$this->menuLink('guests-birthday',[],'Ulang Tahun Pelanggan')?></li> -->
                  </ul>
                </li>
                <li class="emak"><a href="javascript:void(0)" class="waves-effect">Sopir </a><span class="fa arrow"></span>
                  <ul class="nav nav-third-level">
                    <li><?=$this->menuLink('salesActivity',[],'Aktifitas Penjualan')?></li>
                  </ul>
                </li>
                <li class="emak"><a href="javascript:void(0)" class="waves-effect">Office </a><span class="fa arrow"></span>
                  <ul class="nav nav-third-level">
                    <li><?=$this->menuLink('analisa-keuangan',[],'Keuangan')?><li>
                    <li><?=$this->menuLink('analisa-reservasi',[],'Reservasi')?><li>
                  </ul>
                </li>
              </ul>
            </li>
            <li class="emak"><a href="#" class="waves-effect"><i class="fa fa-spin fa-cog fa-fw"></i> <span class="hide-menu">Setups <span class="fa arrow"></span></span></a>
              <ul class="nav nav-second-level">
                <li><?=$this->menuLink('frontdesk-company',[],'Perusahaan')?></li>
                <li><?=$this->menuLink('setup-options',[],'Opsi')?></li>
                <li><?=$this->menuLink('setup-user',[],'Users')?></li>
              </ul>
            </li>
            <li><?=$this->menuLink('logout',[],'<i class="fa fa-sign-out fa-fw"></i> <span class="hide-menu">Log out</span>')?></li>
        </ul>
    </div>
  </div>

<script type="text/javascript">
$(document).ready(function() {
  $('.emak').each( function() {
    var hiddenLI = $(this).children('ul.nav').children('li').find('.boom');

    if(hiddenLI.length == 0) {
      $(this).hide();
    }
  });
});

</script>