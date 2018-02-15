<?php
// Routes

// Dashboard
$app->get('/[dashboard]', App\Controller\DashboardController::class)
    //->add('accessControlMiddleware')
    ->add('authMiddleware')
    ->setName('dashboard');

// Login
$app->get('/login', App\Controller\LoginController::class)
    ->add('loginMiddleware')
    ->setName('login');
$app->post('/login', App\Controller\LoginController::class.':submit')
    ->add('loginMiddleware')
    ->setName('login-submit');
$app->get('/logout', App\Controller\LoginController::class.':logout')
    ->add('Kulkul\Authentication\AuthenticationMiddleware')
    ->setName('logout');

// Forbidden Resources 403
$app->get('/403-access-forbidden', App\Controller\AccessForbiddenController::class)
    ->add('Kulkul\Authentication\AuthenticationMiddleware')
    ->setName('access-forbidden');

//Dashboard
$app->group('/accounting', function () {

    //dashboard
    $this->get('/dashboard', App\Controller\Accounting\AccDashboardController::class.':jurnal')->setName('dashboard-accounting');


})->add('accessControlMiddleware')
->add('authMiddleware')
->add('LoginDataMiddleware');

// Accounting
$app->group('/accounting/accounts', function () {

    //Accounts
    $this->get('/', App\Controller\Accounting\AccountController::class)->setName('accounting-accounts');

    $this->get('/ajax', App\Controller\Accounting\AccountController::class.':ajax')->setName('accounting-accounts-ajax');

    $this->get('/add', App\Controller\Accounting\AccountController::class.':form')->setName('accounting-accounts-add');

    $this->get('/update/{id}', App\Controller\Accounting\AccountController::class.':form')->setName('accounting-accounts-update');

    $this->post('/save', App\Controller\Accounting\AccountController::class.':save')->setName('accounting-accounts-save');

    $this->get('/delete/{id}', App\Controller\Accounting\AccountController::class.':delete')->setName('accounting-accounts-delete');

})->add('accessControlMiddleware')
->add('authMiddleware')
->add('LoginDataMiddleware');

$app->group('/accounting/headers', function () {

    //Accounts Header
    $this->get('/', App\Controller\Accounting\AccheadersController::class)->setName('accounting-headers');

    $this->get('/add', App\Controller\Accounting\AccheadersController::class.':form')->setName('accounting-headers-add');

    $this->get('/update/{id}', App\Controller\Accounting\AccheadersController::class.':form')->setName('accounting-headers-update');;

    $this->post('/save', App\Controller\Accounting\AccheadersController::class.':save')->setName('accounting-headers-save');

    $this->get('/delete/{id}', App\Controller\Accounting\AccheadersController::class.':delete')->setName('accounting-headers-delete');

})->add('accessControlMiddleware')
->add('authMiddleware')
->add('LoginDataMiddleware');

$app->group('/accounting/jurnal', function () {

    //Accounts Jurnal
    $this->map(["GET","POST"],'/', App\Controller\Accounting\JurnalController::class)->setName('accounting-jurnal');

    $this->get('/add', App\Controller\Accounting\JurnalController::class.':form')->setName('accounting-jurnal-add');

    $this->get('/update/{id}', App\Controller\Accounting\JurnalController::class.':form')->setName('accounting-jurnal-update');

    $this->post('/save', App\Controller\Accounting\JurnalController::class.':save')->setName('accounting-jurnal-save');

    $this->get('/delete/{id}', App\Controller\Accounting\JurnalController::class.':delete')->setName('accounting-jurnal-delete');

    $this->post('/posted', App\Controller\Accounting\JurnalController::class.':posted')->setName('accounting-jurnal-posted');

})->add('accessControlMiddleware')
->add('authMiddleware')
->add('LoginDataMiddleware');

$app->group('/accounting/neraca', function () {

    $this->get('/saldo-awal[/]', App\Controller\Accounting\NeracaController::class)->setName('accounting-neraca-saldo-awal');
    $this->get('/saldo-awal/add', App\Controller\Accounting\NeracaController::class.':form')->setName('accounting-neraca-saldo-awal-add');
    $this->get('/saldo-awal/{id}', App\Controller\Accounting\NeracaController::class.':form')->setName('accounting-neraca-saldo-awal-edit');
    $this->get('/saldo-awal/delete/{id}', App\Controller\Accounting\NeracaController::class.':delete')->setName('accounting-neraca-saldo-awal-delete');
    $this->map(["POST","GET"],'/tutup-buku', App\Controller\Accounting\NeracaController::class.':closing')->setName('accounting-neraca-tutup-buku');

    $this->post('/save', App\Controller\Accounting\NeracaController::class.':save')->setName('accounting-neraca-save');

})->add('accessControlMiddleware')
->add('authMiddleware')
->add('LoginDataMiddleware');

$app->group('/accounting/kastype', function () {

    $this->get('/', App\Controller\Accounting\KastypeController::class)->setName('accounting-kastype');

    $this->get('/add', App\Controller\Accounting\KastypeController::class.':form')->setName('accounting-kastype-add');

    $this->get('/update/{id}', App\Controller\Accounting\KastypeController::class.':form')->setName('accounting-kastype-update');

    $this->post('/save', App\Controller\Accounting\KastypeController::class.':save')->setName('accounting-kastype-save');

    $this->get('/delete/{id}', App\Controller\Accounting\KastypeController::class.':delete')->setName('accounting-kastype-delete');

})->add('accessControlMiddleware')
->add('authMiddleware')
->add('LoginDataMiddleware');

$app->group('/accounting/bank', function () {

    $this->get('[/]', App\Controller\Accounting\BankController::class)->setName('accounting-bank');

    $this->get('/add', App\Controller\Accounting\BankController::class.':form')->setName('accounting-bank-add');

    $this->get('/update/{id}', App\Controller\Accounting\BankController::class.':form')->setName('accounting-bank-update');

    $this->post('/save', App\Controller\Accounting\BankController::class.':save')->setName('accounting-bank-save');

    $this->get('/delete/{id}', App\Controller\Accounting\BankController::class.':delete')->setName('accounting-bank-delete');

})->add('accessControlMiddleware')
->add('authMiddleware')
->add('LoginDataMiddleware');

$app->group('/accounting/creditcard', function () {

    $this->get('[/]', App\Controller\Accounting\CreditcardController::class)->setName('accounting-creditcard');

    $this->get('/add', App\Controller\Accounting\CreditcardController::class.':form')->setName('accounting-creditcard-add');

    $this->get('/update/{id}', App\Controller\Accounting\CreditcardController::class.':form')->setName('accounting-creditcard-update');

    $this->post('/save', App\Controller\Accounting\CreditcardController::class.':save')->setName('accounting-creditcard-save');

    $this->get('/delete/{id}', App\Controller\Accounting\CreditcardController::class.':delete')->setName('accounting-creditcard-delete');

})->add('accessControlMiddleware')
->add('authMiddleware')
->add('LoginDataMiddleware');

$app->group('/accounting/trans-kas', function () {

    $this->get('/{type}', App\Controller\Accounting\AcckasController::class)->setName('accounting-kas');

    $this->get('/{type}/add', App\Controller\Accounting\AcckasController::class.':form')->setName('accounting-kas-add');

    $this->get('/update/{id}', App\Controller\Accounting\AcckasController::class.':form')->setName('accounting-kas-update');

    $this->post('/save', App\Controller\Accounting\AcckasController::class.':save')->setName('accounting-kas-save');

    $this->get('/delete/{id}', App\Controller\Accounting\AcckasController::class.':delete')->setName('accounting-kas-delete');

})->add('accessControlMiddleware')
->add('authMiddleware')
->add('LoginDataMiddleware');

$app->group('/accounting/currency', function () {

    $this->map(["POST","GET"],'[/]', App\Controller\Accounting\CurrencyController::class.':currency')->setName('accounting-currency');

    $this->get('/delete/[{id}]', App\Controller\Accounting\CurrencyController::class.':currency_delete')->setName('accounting-currency-delete');

    $this->map(["POST","GET"],'/rate/[{id}]', App\Controller\Accounting\CurrencyController::class.':rate')->setName('accounting-currency-rate');

})->add('accessControlMiddleware')
->add('authMiddleware')
->add('LoginDataMiddleware');

// $app->group('/accounting/pendapatan', function () {
$app->group('/accounting/labarugi', function () {

      //pendapatan
      $this->group('/pendapatan', function () {
         $this->map(["POST","GET"],'/restorante', App\Controller\Accounting\PendapatanController::class.':restorante')->setName('pendapatan-restorante');
        $this->map(["POST","GET"],'/whitehouse', App\Controller\Accounting\PendapatanController::class.':whitehouse')->setName('pendapatan-whitehouse');
        $this->map(["POST","GET"],'/spa', App\Controller\Accounting\PendapatanController::class.':spa')->setName('pendapatan-spa');
        $this->map(["POST","GET"],'/checkouts', App\Controller\Accounting\PendapatanController::class.':checkout')->setName('pendapatan-checkout'); 
        $this->map(["POST","GET"],'/rekap', App\Controller\Accounting\PendapatanController::class.':rekap')->setName('pendapatan-rekap');

      });

      //pengeluaran
      $this->group('/labarugi', function () {
         $this->get('/pengeluaran/filter', App\Controller\Accounting\PengeluaranController::class)->setName('accounting-pengeluaran');
         $this->post('/pengeluaran/print', App\Controller\Accounting\PengeluaranController::class)->setName('accounting-pengeluaran-print');
      });

      //labarugi
      $this->group('/labarugi', function () {
         $this->get('/labarugi/filter', App\Controller\Accounting\LabarugiController::class)->setName('accounting-labarugi');
         $this->post('/labarugi/print', App\Controller\Accounting\LabarugiController::class)->setName('accounting-labarugi-print');
      });

})->add('accessControlMiddleware')
->add('authMiddleware')
->add('LoginDataMiddleware');


$app->group('/accounting/report', function () {

    $this->post('/pendapatan_harian/print', App\Controller\Accounting\ReportController::class.':pendapatan_harian')->setName('accounting-report-pendapatan_harian-print');

    $this->get('/account', App\Controller\Accounting\ReportController::class.':account')->setName('accounting-report-account');

    $this->get('/saldo', App\Controller\Accounting\ReportController::class.':saldo')->setName('accounting-report-saldo');

    $this->post('/saldo/print', App\Controller\Accounting\ReportController::class.':saldo')->setName('accounting-report-saldo-print');

    $this->get('/jurnal', App\Controller\Accounting\ReportController::class.':jurnal')->setName('accounting-report-jurnal');

    $this->post('/jurnal/print', App\Controller\Accounting\ReportController::class.':jurnal')->setName('accounting-report-jurnal-print');

    $this->get('/buku-besar', App\Controller\Accounting\ReportController::class.':bukubesar')->setName('accounting-report-bukubesar');

    $this->post('/buku-besar/print', App\Controller\Accounting\ReportController::class.':bukubesar')->setName('accounting-report-bukubesar-print');

    $this->get('/laba-rugi', App\Controller\Accounting\ReportController::class.':labarugi')->setName('accounting-report-labarugi');

    $this->post('/laba-rugi/print', App\Controller\Accounting\ReportController::class.':labarugi')->setName('accounting-report-labarugi-print');

    $this->map(["GET","POST"],'/laba-rugi-detail', App\Controller\Accounting\ReportController::class.':labarugi_detail')->setName('accounting-report-labarugi_detail');

    $this->map(["GET","POST"],'/aktiva', App\Controller\Accounting\ReportController::class.':aktiva')->setName('accounting-report-aktiva');

    $this->map(["GET","POST"],'/neraca', App\Controller\Accounting\ReportController::class.':neraca')->setName('accounting-report-neraca');

    $this->map(["GET","POST"],'/neraca-detail', App\Controller\Accounting\ReportController::class.':neraca_detail')->setName('accounting-report-neraca_detail');

    $this->map(["GET","POST"],'/trans-kas', App\Controller\Accounting\ReportController::class.':trans_kas')->setName('accounting-report-trans-kas'); 

    $this->map(["GET","POST"],'/deposit', App\Controller\Accounting\DepositController::class)->setName('accu-deposit');

    // $this->get('/tutup-buku', App\Controller\Accounting\NeracaController::class.':closing')->setName('accounting-neraca-tutup-buku');
})->add('accessControlMiddleware')
->add('authMiddleware')
->add('LoginDataMiddleware');

$app->group('/accounting/aktiva', function () {
    //Accounts Jurnal

    $this->get('/', App\Controller\Accounting\AktivaController::class)->setName('accounting-aktiva');

    $this->get('/add', App\Controller\Accounting\AktivaController::class.':form')->setName('accounting-aktiva-add');

    // $this->post('/tutup-buku', App\Controller\Accounting\NeracaController::class.':closing')->setName('accounting-neraca-tutup-buku');

    $this->get('/update/{id}', App\Controller\Accounting\AktivaController::class.':form')->setName('accounting-aktiva-update');;

    $this->post('/save', App\Controller\Accounting\AktivaController::class.':save')->setName('accounting-aktiva-save');

    $this->get('/delete/{id}', App\Controller\Accounting\AktivaController::class.':delete')->setName('accounting-aktiva-delete');


    $this->map(["GET","POST"],'/aktiva-penyusutan', App\Controller\Accounting\AktivaController::class.':penyusutan')->setName('accounting-aktiva-penyusutan');

    $this->get('/aktiva-penyusutan/delete/{id}', App\Controller\Accounting\AktivaController::class.':penyusutan_delete')->setName('accounting-aktiva-penyusutan-delete');

})->add('accessControlMiddleware')
->add('authMiddleware')
->add('LoginDataMiddleware');

$app->group('/accounting/aktiva/group', function () {
    //Accounts Jurnal

    $this->get('/', App\Controller\Accounting\AktivaGroupController::class)->setName('accounting-aktiva-group');

    $this->get('/add', App\Controller\Accounting\AktivaGroupController::class.':form')->setName('accounting-aktiva-group-add');

    $this->get('/update/{id}', App\Controller\Accounting\AktivaGroupController::class.':form')->setName('accounting-aktiva-group-update');;

    $this->post('/save', App\Controller\Accounting\AktivaGroupController::class.':save')->setName('accounting-aktiva-group-save');

    $this->get('/delete/{id}', App\Controller\Accounting\AktivaGroupController::class.':delete')->setName('accounting-aktiva-group-delete');

})->add('accessControlMiddleware')
->add('authMiddleware')
->add('LoginDataMiddleware');

// Setup
$app->group('/setup', function () {

    // Department
    $this->group('/department', function () {

        $this->get('[/index]', App\Controller\Setup\DepartmentController::class)
            ->setName('setup-department');

        $this->get('/add', App\Controller\Setup\DepartmentController::class.':form')
            ->setName('setup-department-new');

        $this->post('/save', App\Controller\Setup\DepartmentController::class.':save')
            ->setName('setup-department-save');

        $this->get('/update/{id}', App\Controller\Setup\DepartmentController::class.':form')
            ->setName('setup-department-update');

        $this->get('/delete/{id}', App\Controller\Setup\DepartmentController::class.':delete')
            ->setName('setup-department-delete');

    });

    // Department
    $this->group('/building', function () {

        $this->get('[/index]', App\Controller\Setup\BuildingController::class)
            ->setName('setup-building');

        $this->get('/add', App\Controller\Setup\BuildingController::class.':form')
            ->setName('setup-building-new');

        $this->post('/save', App\Controller\Setup\BuildingController::class.':save')
            ->setName('setup-building-save');

        $this->get('/update/{id}', App\Controller\Setup\BuildingController::class.':form')
            ->setName('setup-building-update');

        $this->get('/delete/{id}', App\Controller\Setup\BuildingController::class.':delete')
            ->setName('setup-building-delete');

    });

    // User
    $this->group('/user', function () {

        $this->get('[/]', App\Controller\Setup\UserController::class)
            ->setName('setup-user');

        $this->get('/add', App\Controller\Setup\UserController::class.':form')
            ->setName('setup-user-new');

        $this->post('/save', App\Controller\Setup\UserController::class.':save')
            ->setName('setup-user-save');

        $this->get('/update/{id}', App\Controller\Setup\UserController::class.':update')
            ->setName('setup-user-update');

        $this->get('/delete/{id}', App\Controller\Setup\UserController::class.':delete')
            ->setName('setup-user-delete');

        $this->get('/profile', App\Controller\Setup\UserController::class.':profile')
            ->setName('setup-user-profile');

        $this->post('/saveprofile', App\Controller\Setup\UserController::class.':saveprofile')
            ->setName('setup-user-save-profile');

    });

    $this->group('/useraccess', function () {

        $this->get('/{userId}', App\Controller\Setup\UserAccessController::class)
            ->setName('setup-useraccess');


        $this->post('/save', App\Controller\Setup\UserAccessController::class.':save')
            ->setName('setup-useraccess-save');

    });

    // Room Type
    $this->group('/mobil-type', function () {

        $this->get('[/]', App\Controller\Setup\RoomTypeController::class)
            ->setName('setup-room-type');

        $this->get('/add', App\Controller\Setup\RoomTypeController::class.':form')
            ->setName('setup-room-type-new');

        $this->post('/save', App\Controller\Setup\RoomTypeController::class.':save')
            ->setName('setup-room-type-save');

        $this->get('/update/{id}', App\Controller\Setup\RoomTypeController::class.':form')
            ->setName('setup-room-type-update');

        $this->get('/delete/{id}', App\Controller\Setup\RoomTypeController::class.':delete')
            ->setName('setup-room-type-delete');
    });

    // Room Facility
    $this->group('/room-facility', function () {

        $this->get('[/]', App\Controller\Setup\RoomFacilityController::class)
            ->setName('setup-room-facility');

        $this->get('/add', App\Controller\Setup\RoomFacilityController::class.':form')
            ->setName('setup-room-facility-new');

        $this->post('/save', App\Controller\Setup\RoomFacilityController::class.':save')
            ->setName('setup-room-facility-save');

        $this->get('/update/{id}', App\Controller\Setup\RoomFacilityController::class.':form')
            ->setName('setup-room-facility-update');

        $this->get('/delete/{id}', App\Controller\Setup\RoomFacilityController::class.':delete')
            ->setName('setup-room-facility-delete');

    });

    // Room Description
    $this->group('/room-description', function () {

        $this->get('[/]', App\Controller\Setup\RoomDescriptionController::class)
            ->setName('setup-room-description');

        $this->get('/add', App\Controller\Setup\RoomDescriptionController::class.':form')
            ->setName('setup-room-description-new');

        $this->post('/save', App\Controller\Setup\RoomDescriptionController::class.':save')
            ->setName('setup-room-description-save');

        $this->get('/update/{id}', App\Controller\Setup\RoomDescriptionController::class.':form')
            ->setName('setup-room-description-update');

        $this->get('/delete/{id}', App\Controller\Setup\RoomDescriptionController::class.':delete')
            ->setName('setup-room-description-delete');
    });

    // Bed Type
    $this->group('/bed-type', function () {

        $this->get('[/]', App\Controller\Setup\BedTypeController::class)
            ->setName('setup-bed-type');

        $this->get('/add', App\Controller\Setup\BedTypeController::class.':form')
            ->setName('setup-bed-type-new');

        $this->post('/save', App\Controller\Setup\BedTypeController::class.':save')
            ->setName('setup-bed-type-save');

        $this->get('/update/{id}', App\Controller\Setup\BedTypeController::class.':form')
            ->setName('setup-bed-type-update');

        $this->get('/delete/{id}', App\Controller\Setup\BedTypeController::class.':delete')
            ->setName('setup-bed-type-delete');
    });

    // Room
    $this->group('/mobil', function () {

        $this->get('[/]', App\Controller\Setup\RoomController::class)
            ->setName('setup-room');

        $this->get('/add', App\Controller\Setup\RoomController::class.':form')
            ->setName('setup-room-new');

        $this->post('/save', App\Controller\Setup\RoomController::class.':save')
            ->setName('setup-room-save');

        $this->get('/update/{id}', App\Controller\Setup\RoomController::class.':form')
            ->setName('setup-room-update');

        $this->get('/delete/{id}', App\Controller\Setup\RoomController::class.':delete')
            ->setName('setup-room-delete');
    });

    // Room rate
    $this->group('/mobil-rate', function () {

        $this->get('/{room_id}', App\Controller\Setup\RoomRateController::class)
            ->setName('setup-room-rate');

        /*$this->get('/{room_id}/update', App\Controller\Setup\RoomRateController::class.':update')
            ->setName('setup-room-rate-update');
        */

        $this->post('/{room_id}/save', App\Controller\Setup\RoomRateController::class.':save')
            ->setName('setup-room-rate-save');

    });

    // Room Description
    $this->group('/periodic-rate', function () {

        $this->get('[/]', App\Controller\Setup\PeriodicRateController::class)
            ->setName('setup-periodic-rate');

        $this->get('/add', App\Controller\Setup\PeriodicRateController::class.':form')
            ->setName('setup-periodic-rate-new');

        $this->post('/save', App\Controller\Setup\PeriodicRateController::class.':save')
            ->setName('setup-periodic-rate-save');

        $this->get('/update/{id}', App\Controller\Setup\PeriodicRateController::class.':form')
             ->setName('setup-periodic-rate-update');

        $this->get('/delete/{id}', App\Controller\Setup\PeriodicRateController::class.':delete')
            ->setName('setup-periodic-rate-delete');
    });

    // Room Status Type
    $this->group('/room-status-type', function () {

        $this->get('[/]', App\Controller\Setup\RoomStatusTypeController::class)
            ->setName('setup-room-status-type');

        $this->get('/add', App\Controller\Setup\RoomStatusTypeController::class.':form')
            ->setName('room-status-type-add');

        $this->get('/update/{id}', App\Controller\Setup\RoomStatusTypeController::class.':form')
            ->setName('room-status-type-update');

        $this->post('/save', App\Controller\Setup\RoomStatusTypeController::class.':save')
            ->setName('room-status-type-save');

        $this->get('/delete/{id}', App\Controller\Setup\RoomStatusTypeController::class.':delete')
            ->setName('room-status-type-delete');
    });


    // Options
    $this->group('/options', function () {

        $this->map(["GET","POST"],'/', App\Controller\Setup\OptionController::class)
            ->setName('setup-options');
    });
    // setup gudang
    $this->map(["GET","POST"],'/setup-gudang', App\Controller\Setup\SetupgudangController::class)
            ->setName('setup-gudang');
})->add('accessControlMiddleware')
->add('authMiddleware')
->add('LoginDataMiddleware');

// Frontdesk
$app->group('/rentcar', function () {

      //phonebook
      $this->group('/phonebook', function () {
         $this->get('[/]', App\Controller\FrontDesk\PhonebookController::class)->setName('phonebook');
         $this->get('/add', App\Controller\FrontDesk\PhonebookController::class.':form')->setName('phonebook-new');
         $this->get('/edit/{id}', App\Controller\FrontDesk\PhonebookController::class.':form')->setName('phonebook-edit');
         $this->get('/delete/{id}', App\Controller\FrontDesk\PhonebookController::class.':delete')->setName('phonebook-delete');
         $this->post('/save', App\Controller\FrontDesk\PhonebookController::class.':save')->setName('phonebook-save');
         $this->get('/add/{data}', App\Controller\FrontDesk\PhonebookController::class.':form')->setName('phonebook-data');
      });


    // guest
    $this->group('/pelanggan', function () {

        $this->get('[/]', App\Controller\FrontDesk\GuestController::class)
            ->setName('frontdesk-guest');

        $this->get('/add', App\Controller\FrontDesk\GuestController::class.':form')
            ->setName('frontdesk-guest-new');

        $this->post('/save', App\Controller\FrontDesk\GuestController::class.':save')
            ->setName('frontdesk-guest-save');

        $this->get('/update/{id}', App\Controller\FrontDesk\GuestController::class.':form')
            ->setName('frontdesk-guest-update');

        $this->get('/delete/{id}', App\Controller\FrontDesk\GuestController::class.':delete')
            ->setName('frontdesk-guest-delete');

        $this->get('/ajax_detail/[{id}]',App\Controller\FrontDesk\CostListBuildingController::class.":ajax_detail")
            ->setName('frontdesk-guest-costlistbuilding-ajax_detail');

        $this->map(["GET","POST"],'/guest-list', App\Controller\FrontDesk\GuestController::class.':guestlist')
            ->setName('frontdesk-guest-list');

        $this->map(["GET","POST"],'/guest-list-report', App\Controller\FrontDesk\GuestController::class.':guestlistreport')
            ->setName('frontdesk-guest-list-report');

        $this->map(["GET","POST"],'/arrival-guest', App\Controller\FrontDesk\GuestController::class.':arrivalguest')
            ->setName('frontdesk-guest-arrival');

        $this->map(["GET","POST"],'/departure-guest', App\Controller\FrontDesk\GuestController::class.':departureguest')
            ->setName('frontdesk-guest-departure');


        $this->get('/report-arrival-departure/{id}/{date}', App\Controller\FrontDesk\GuestController::class.':guestlistarrival')
            ->setName('report-arrival-departure');
    });

    //agent
    $this->group('/sopir', function () {

        $this->get('[/]', App\Controller\FrontDesk\AgentController::class)
            ->setName('frontdesk-agent');

        $this->get('/add', App\Controller\FrontDesk\AgentController::class.':form')
            ->setName('frontdesk-agent-new');

        $this->post('/save', App\Controller\FrontDesk\AgentController::class.':save')
            ->setName('frontdesk-agent-save');

        $this->get('/update/{id}', App\Controller\FrontDesk\AgentController::class.':form')
            ->setName('frontdesk-agent-update');

        $this->get('/delete/{id}', App\Controller\FrontDesk\AgentController::class.':delete')
            ->setName('frontdesk-agent-delete');
    });

    $this->group('/agent-rate', function () {

        $this->get('/form/{agent_id}/{room_id}', App\Controller\FrontDesk\AgentRateController::class.':form')
            ->setName('frontdesk-agentrate-form');

        $this->post('/save', App\Controller\FrontDesk\AgentRateController::class.':save')
            ->setName('frontdesk-agentrate-save');

        $this->get('/delete/{id}', App\Controller\FrontDesk\AgentRateController::class.':delete')
            ->setName('frontdesk-agentrate-delete');
    });

    //company
    $this->group('/company', function () {

        $this->get('[/]', App\Controller\FrontDesk\CompanyController::class)
            ->setName('frontdesk-company');

        $this->get('/add', App\Controller\FrontDesk\CompanyController::class.':form')
            ->setName('frontdesk-company-new');

        $this->post('/save', App\Controller\FrontDesk\CompanyController::class.':save')
            ->setName('frontdesk-company-save');

        $this->get('/update/{id}', App\Controller\FrontDesk\CompanyController::class.':form')
            ->setName('frontdesk-company-update');

        $this->get('/delete/{id}', App\Controller\FrontDesk\CompanyController::class.':delete')
            ->setName('frontdesk-company-delete');
    });

    // reservation
    $this->group('/reservation', function () {

        $this->get('[/]', App\Controller\FrontDesk\ReservationController::class)
            ->setName('frontdesk-reservation');

        $this->get('/new', App\Controller\FrontDesk\ReservationController::class.':form')
            ->setName('frontdesk-reservation-add');

        $this->get('/rooms/{checkin}/{checkout}/{agent}', App\Controller\FrontDesk\ReservationController::class.':room_available')
            ->setName('frontdesk-reservation-room');

        $this->get('/edit/{id}', App\Controller\FrontDesk\ReservationController::class.':form')
            ->setName('frontdesk-reservation-edit');

        $this->post('/save', App\Controller\FrontDesk\ReservationController::class.':save')
            ->setName('frontdesk-reservation-save');

        $this->get('/delete/{id}', App\Controller\FrontDesk\ReservationController::class.':delete')
            ->setName('frontdesk-reservation-delete');

    });

    $this->group('/reservation_chart', function () {

        $this->map(['POST','GET'],'/chart-filter', App\Controller\FrontDesk\ReservationChartController::class.':filter')
            ->setName('frontdesk-reservation-chart-filter');

        $this->post('/chart', App\Controller\FrontDesk\ReservationChartController::class)
            ->setName('frontdesk-reservation-chart');
            
    });

    // Jenis biaya
    $this->group('/addchargetype', function () {

        $this->get('[/]', App\Controller\FrontDesk\AddchargetypeController::class)
            ->setName('frontdesk-addchargetype');

        $this->get('/add', App\Controller\FrontDesk\AddchargetypeController::class.':form')
            ->setName('frontdesk-addchargetype-new');

        $this->post('/save', App\Controller\FrontDesk\AddchargetypeController::class.':save')
            ->setName('frontdesk-addchargetype-save');

        $this->get('/update/{id}', App\Controller\FrontDesk\AddchargetypeController::class.':form')
            ->setName('frontdesk-addchargetype-update');

        $this->get('/delete/{id}', App\Controller\FrontDesk\AddchargetypeController::class.':delete')
            ->setName('frontdesk-addchargetype-delete');
    });

    // Biaya tambahan
    $this->group('/addcharge', function () {

        $this->get('[/]', App\Controller\FrontDesk\AddchargeController::class)
            ->setName('frontdesk-addcharge');

        $this->get('/add', App\Controller\FrontDesk\AddchargeController::class.':form')
             ->setName('frontdesk-addcharge-new');

        $this->post('/save', App\Controller\FrontDesk\AddchargeController::class.':save')
            ->setName('frontdesk-addcharge-save');

        $this->get('/update/{id}', App\Controller\FrontDesk\AddchargeController::class.':form')
            ->setName('frontdesk-addcharge-update');

        $this->get('/delete/{id}', App\Controller\FrontDesk\AddchargeController::class.':delete')
            ->setName('frontdesk-addcharge-delete');
    });


    $this->group('/deposit', function () {

        $this->map(["GET","POST"],'/{reservations_id}', App\Controller\FrontDesk\DepositController::class)
            ->setName('frontdesk-deposit');

        $this->get('/delete/{id}', App\Controller\FrontDesk\DepositController::class.':delete')
            ->setName('frontdesk-deposit-delete');

        $this->get('/cetak/{id}', App\Controller\FrontDesk\DepositController::class.':reportKwitansi')
            ->setName('frontdesk-deposit-kwitansi');
    });

    $this->group('/peminjaman', function () {

        $this->get('/', App\Controller\FrontDesk\CheckinGroupController::class)
            ->setName('frondesk-checkingroup');

        $this->get('/add/{reservation_id}', App\Controller\FrontDesk\CheckinGroupController::class.':form')
            ->setName('frondesk-checkingroup-add');

        $this->get('/update/{reservation_detail_id}/{reservation_id}', App\Controller\FrontDesk\CheckinGroupController::class.':form')
            ->setName('frondesk-checkingroup-edit');

        $this->get('/delete/{id}', App\Controller\FrontDesk\CheckinGroupController::class.':delete')
            ->setName('frontdesk-checkingroup-delete');

        $this->post('/save', App\Controller\FrontDesk\CheckinGroupController::class.':save')
            ->setName('frontdesk-checkingroup-save');

    });

    $this->group('/pengembalian', function () {

        $this->get('/', App\Controller\FrontDesk\CheckoutController::class)
            ->setName('frondesk-checkout');

        $this->get('/add', App\Controller\FrontDesk\CheckoutController::class.':form')
            ->setName('frondesk-checkout-add');

        $this->post('/save', App\Controller\FrontDesk\CheckoutController::class.':save')
            ->setName('frontdesk-checkout-save');

        $this->get('/delete/{id}', App\Controller\FrontDesk\CheckoutController::class.':delete')
            ->setName('frontdesk-checkout-delete');

        $this->post('/additional-services-json', App\Controller\FrontDesk\CheckoutController::class.':getAddServices')
            ->setName('frontdesk-checkout-addservices');

        $this->get('/report/single/{id}', App\Controller\FrontDesk\CheckoutController::class.':reportSingle')
            ->setName('frondesk-checkout-report-single');

        $this->post('/deposit', App\Controller\FrontDesk\CheckoutController::class.':deposit')
            ->setName('frontdesk-checkout-add-deposit');
    });


    // Phone bill
    $this->group('/phone-bill', function () {

        $this->get('[/]', App\Controller\FrontDesk\PhoneBillController::class)
            ->setName('phone-bill');

        $this->get('/add/{checkin_id}/{room_id}', App\Controller\FrontDesk\PhoneBillController::class.':add')
            ->setName('phone-bill-add');

        $this->post('/submit', App\Controller\FrontDesk\PhoneBillController::class.':submit')
            ->setName('phone-bill-submit');

        $this->get('/update/{id}', App\Controller\FrontDesk\PhoneBillController::class.':update')
            ->setName('phone-bill-submit');

        $this->get('/delete/{id}', App\Controller\FrontDesk\PhoneBillController::class.':delete')
            ->setName('phone-bill-delete');

    });

    // Mini Bar
    $this->group('/minibar', function () {

        $this->get('[/]', App\Controller\FrontDesk\MiniBarController::class)
            ->setName('minibar');

        $this->get('/add/{checkin_id}/{room_id}', App\Controller\FrontDesk\MiniBarController::class.':add')
            ->setName('minibar-add');

        $this->post('/submit', App\Controller\FrontDesk\MiniBarController::class.':submit')
            ->setName('minibar-submit');

        $this->get('/update/{id}', App\Controller\FrontDesk\MiniBarController::class.':update')
            ->setName('minibar-submit');

        $this->get('/delete/{id}', App\Controller\FrontDesk\MiniBarController::class.':delete')
            ->setName('minibar-delete');

    });

    $this->group('/roomstatus', function () {

        $this->map(["GET","POST"],'[/]', App\Controller\FrontDesk\RoomstatusController::class)
            ->setName('frontdesk-roomstatus');

        $this->map(["GET","POST"],'/detail/{rooms_id}/{start}/{end}', App\Controller\FrontDesk\RoomstatusController::class.':detail')->setName('frontdesk-roomstatus-detail');

        $this->post('/update/{rooms_id}/{start}/{end}', App\Controller\FrontDesk\RoomstatusController::class.':update')->setName('frontdesk-roomstatus-update');

        $this->get('/add/{checkin_id}/{room_id}', App\Controller\FrontDesk\RoomstatusController::class.':add')
            ->setName('frontdesk-roomstatus-add');

        $this->post('/save', App\Controller\FrontDesk\RoomstatusController::class.':save')
            ->setName('frontdesk-roomstatus-save');

        $this->get('/update/{id}', App\Controller\FrontDesk\RoomstatusController::class.':update')
            ->setName('frontdesk-roomstatus-edit');

        $this->get('/delete/{id}', App\Controller\FrontDesk\RoomstatusController::class.':delete')
            ->setName('frontdesk-roomstatus-delete');

    });

    $this->group('/roomchange', function () {
        $this->get('[/]',App\Controller\FrontDesk\RoomchangeController::class)->setName('frontdesk-roomchange');
        $this->get('/add',App\Controller\FrontDesk\RoomchangeController::class.':form')->setName('frontdesk-roomchange-form');
        $this->post('/save',App\Controller\FrontDesk\RoomchangeController::class.':save')->setName('frontdesk-roomchange-save');
        $this->post('/ajax_reserved_room',App\Controller\FrontDesk\RoomchangeController::class.':ajax_reserved_room')->setName('frontdesk-roomchange-ajax_reserved_room');
        $this->get('/delete/{id}',App\Controller\FrontDesk\RoomchangeController::class.':delete')->setName('frontdesk-roomchange-delete');
    });

    $this->group('/costumerlistbuilding',function(){
        $this->get('[/]',App\Controller\FrontDesk\CostListBuildingController::class)->setName('frontdesk-costlistbuilding');
        $this->get('/ajax_detail/{id}',App\Controller\FrontDesk\CostListBuildingController::class.":ajax_detail")->setName('frontdesk-costlistbuilding-ajax_detail');
    });

    // Report
    $this->group('/report', function () {
        $this->get('/list-mobil', App\Controller\FrontDesk\Report\RoomReportController::class)
            ->setName('frontdesk-report-list-rooms');

        $this->get('/room-summary', App\Controller\FrontDesk\Report\RoomSummaryController::class)
            ->setName('frontdesk-report-room-summary');

        $this->get('/pelanggan', App\Controller\FrontDesk\Report\GuestReportController::class)
            ->setName('frontdesk-report-guests');

        $this->get('/reservation-filter', App\Controller\FrontDesk\Report\ReservationReportController::class.':filter')
            ->setName('frontdesk-report-reservation-filter');
        $this->post('/reservation', App\Controller\FrontDesk\Report\ReservationReportController::class.':display')
            ->setName('frontdesk-report-reservation');

        $this->get('/peminjaman-filter', App\Controller\FrontDesk\Report\CheckinReportController::class.':filter')
            ->setName('frontdesk-report-checkin-filter');
        $this->post('/peminjaman', App\Controller\FrontDesk\Report\CheckinReportController::class.':display')
            ->setName('frontdesk-report-checkin');

        $this->get('/pengembalian-filter', App\Controller\FrontDesk\Report\CheckoutReportController::class.':filter')
            ->setName('frontdesk-report-checkout-filter');
        $this->post('/pengembalian', App\Controller\FrontDesk\Report\CheckoutReportController::class.':display')
            ->setName('frontdesk-report-checkout');

        $this->get('/hotel-income-filter', App\Controller\FrontDesk\Report\HotelIncomeController::class.':filter')
            ->setName('frontdesk-report-hotel-income-filter');
        $this->post('/hotel-income', App\Controller\FrontDesk\Report\HotelIncomeController::class)
            ->setName('frontdesk-report-hotel-income');

        $this->get('/income-checkin-filter', App\Controller\FrontDesk\Report\CheckinIncomeController::class.':filter')
            ->setName('frontdesk-report-checkin-income-filter');
        $this->post('/income-checkin-display', App\Controller\FrontDesk\Report\CheckinIncomeController::class)
            ->setName('frontdesk-report-checkin-income-display');

        $this->get('/cashier-filter', App\Controller\FrontDesk\Report\CashierReportController::class.':filter')
            ->setName('frontdesk-report-cashier-filter');
        $this->post('/cashier-display', App\Controller\FrontDesk\Report\CashierReportController::class.':display')
            ->setName('frontdesk-report-cashier-display');

        $this->get('/pelanggan-activity-filter', App\Controller\FrontDesk\Report\GuestActivityController::class.':filter')
            ->setName('frontdesk-report-guest-activity-filter');
        $this->post('/guest-activity-display', App\Controller\FrontDesk\Report\GuestActivityController::class.':display')
            ->setName('frontdesk-report-guest-activity-display');

        $this->get('/guest-history-filter', App\Controller\FrontDesk\Report\GuestHistoryController::class.':filter')
            ->setName('frontdesk-report-guest-history-filter');
        $this->get('/guest-history-display/{id}', App\Controller\FrontDesk\Report\GuestHistoryController::class)
            ->setName('frontdesk-report-guest-history-display');

        $this->get('/reservation-cancel-filter', App\Controller\FrontDesk\Report\ReservationCancelReportController::class.':filter')
            ->setName('frontdesk-report-reservation-cancel-filter');
        $this->post('/reservation-cancel-display', App\Controller\FrontDesk\Report\ReservationCancelReportController::class)
            ->setName('frontdesk-report-reservation-cancel-display');
    });

})->add('accessControlMiddleware')
->add('authMiddleware')
->add('LoginDataMiddleware');

// Pembelian
$app->group('/pembelian', function () {
    // Supplier
    $this->group('/supplier', function () {
        $this->get('/', App\Controller\Pembelian\SupplierController::class)->setName('pembelian-supplier');
        $this->get('/add', App\Controller\Pembelian\SupplierController::class.':form')->setName('pembelian-supplier-add');
        $this->get('/update/{id}', App\Controller\Pembelian\SupplierController::class.':form')->setName('pembelian-supplier-update');
        $this->post('/save', App\Controller\Pembelian\SupplierController::class.':save')->setName('pembelian-supplier-save');
        $this->get('/delete/{id}', App\Controller\Pembelian\SupplierController::class.':delete')->setName('pembelian-supplier-delete');
    });

   // Pembelian
    $this->group('/daftar-pembelian', function () {
        $this->map(["GET","POST"],'[/]', App\Controller\Pembelian\PembelianController::class)->setName('daftar-pembelian');
        $this->get('/add', App\Controller\Pembelian\PembelianController::class.':form')->setName('daftar-pembelian-add');
        $this->get('/update/{id}', App\Controller\Pembelian\PembelianController::class.':form')->setName('daftar-pembelian-update');
        $this->post('/save', App\Controller\Pembelian\PembelianController::class.':save')->setName('daftar-pembelian-save');
        $this->get('/delete/{id}', App\Controller\Pembelian\PembelianController::class.':delete')->setName('daftar-pembelian-delete');
    });

    // Retur Pembelian
    $this->group('/retur-pembelian', function () {
        $this->map(["GET","POST"],'[/]', App\Controller\Pembelian\PembelianReturController::class)->setName('retur-pembelian');
        $this->get('/add/{pembelian_id}', App\Controller\Pembelian\PembelianReturController::class.':form')->setName('retur-pembelian-add');
        $this->get('/update/{id}', App\Controller\Pembelian\PembelianReturController::class.':form')->setName('retur-pembelian-update');
        $this->post('/save', App\Controller\Pembelian\PembelianReturController::class.':save')->setName('retur-pembelian-save');
        $this->get('/delete/{id}', App\Controller\Pembelian\PembelianReturController::class.':delete')->setName('retur-pembelian-delete');
    });

    // Report
    $this->group('/report', function () {
        $this->get('/supplier', App\Controller\Pembelian\ReportController::class.':supplier')->setName('pembelian-report-supplier');
        $this->map(["GET","POST"],'/pembelian[/]', App\Controller\Pembelian\ReportController::class.':pembelian')->setName('pembelian-report-all');
        $this->map(["GET","POST"],'/pembelian-detail[/]', App\Controller\Pembelian\ReportController::class.':pembeliandetail')->setName('pembeliandetail-report-all');
        $this->get('/cetak-pembelian/{id}', App\Controller\Pembelian\ReportController::class.':printpurchase')->setName('pembelian-report-purchase');
        $this->map(["GET","POST"],'/retur-pembelian[/]', App\Controller\Pembelian\ReportController::class.':pembelianretur')->setName('retur-pembelian-report');
        $this->get('/cetak-retur-pembelian/{id}', App\Controller\Pembelian\ReportController::class.':printretur')->setName('retur-pembelian-print');
    });
})->add('accessControlMiddleware')
->add('authMiddleware')
->add('LoginDataMiddleware');

// Management
$app->group('/management', function () {

    // Analisa Kamar
    $this->group('/mobil', function () {
        $this->map(["GET","POST"],'/mobil-availability', App\Controller\Management\RoomAvailabilityController::class)
            ->setName('room-availabel');
        $this->map(["GET","POST"],'/occupancy-room', App\Controller\Management\OccupancyController::class)
            ->setName('occupancy');
        $this->map(["GET","POST"],'/favorite-mobil', App\Controller\Management\AnalisaKamarController::class)
            ->setName('room-favorite');
        $this->map(["GET","POST"],'/reservasi-room', App\Controller\Management\AnalisaKamarController::class.':reservasi_kamar')
            ->setName('analisa-reservasi');
        $this->map(["GET","POST"],'/checkin-room', App\Controller\Management\AnalisaKamarController::class.':checkin')
            ->setName('analisa-checkin');
    });

    // Analisa Restoran
    $this->group('/restoran', function () {
        $this->map(["GET","POST"],'/favorite-table', App\Controller\Management\AnalisaRestoranController::class.':meja')
            ->setName('favorite-table');
        $this->map(["GET","POST"],'/favorite-menu', App\Controller\Management\AnalisaRestoranController::class.':menu')
            ->setName('favorite-menu');
        $this->map(["GET","POST"],'/kinerja-waiter', App\Controller\Management\AnalisaRestoranController::class.':waiter')
            ->setName('kinerja-waiter');
        $this->map(["GET","POST"],'/penjualan-perjam', App\Controller\Management\PenjualanPerjamController::class)
            ->setName('penjualan-perjam');
        $this->map(["GET","POST"],'/penjualan-perhari', App\Controller\Management\PenjualanPerhariController::class)
            ->setName('penjualan-perhari');
    });

        // Analisa Store
    $this->group('/store', function () {
        $this->map(["GET","POST"],'/store-penjualan-perjam', App\Controller\Management\StorePenjualanPerjamController::class)
            ->setName('store-penjualan-perjam');
        $this->map(["GET","POST"],'/store-penjualan-perhari', App\Controller\Management\StorePenjualanPerhariController::class)
            ->setName('store-penjualan-perhari');
    });

    // Analisa Tamu
    $this->group('/pelanggan', function () {
        $this->map(["GET","POST"],'/favorite-pelanggan', App\Controller\Management\AnalisaTamuController::class)
            ->setName('favorite-guests');
        $this->map(["GET","POST"],'/pelanggan-birthday', App\Controller\Management\AnalisaTamuController::class.':birthday')
            ->setName('guests-birthday');
    });

    // Analisa Spa
    $this->group('/spa', function () {
        $this->map(["GET","POST"],'/kinerja-terapis', App\Controller\Management\AnalisaSpaController::class.':terapis')
            ->setName('kinerja-terapis');
        $this->map(["GET","POST"],'/favorite-layanan', App\Controller\Management\AnalisaSpaController::class.':layanan')
            ->setName('favorite-layanan');
    });
   
    // Agent & Sales
    $this->group('/sopir', function () {
        $this->map(["GET","POST"],'/aktifitaspenjualan', App\Controller\Management\AktifitasPenjualanController::class)
            ->setName('salesActivity');
            $this->map(["GET","POST"],'/diagramaktifitas', App\Controller\Management\ActivityDiagramController::class)
            ->setName('activityDiagram');
    });

    // Analisa Keuangan
    $this->group('/keuangan', function() {
        $this->map(["GET","POST"],'/analisa-keuangan', App\Controller\Management\AnalisaKeuanganController::class)
            ->setName('analisa-keuangan');
    });
    $this->map(["GET","POST"],'/log-activity/{table}/{id}', App\Controller\Management\LogAuditingController::class)
            ->setName('log-activity');

})->add('accessControlMiddleware')
->add('authMiddleware')
->add('LoginDataMiddleware');

$app->group('/logistic', function () {
    //gudang
    $this->group('/warehouse', function () {
        $this->get('[/]', App\Controller\Logistic\GudangController::class)->setName('logistic-warehouse');
        $this->get('/add', App\Controller\Logistic\GudangController::class.':form')->setName('logistic-warehouse-add');
        $this->get('/edit/{id}', App\Controller\Logistic\GudangController::class.':form')->setName('logistic-warehouse-edit');
        $this->post('/save', App\Controller\Logistic\GudangController::class.':save')->setName('logistic-warehouse-save');
        $this->get('/delete/{id}', App\Controller\Logistic\GudangController::class.':delete')->setName('logistic-warehouse-delete');
    });

    //barang
    $this->group('/good', function () {
        $this->get('[/]', App\Controller\Logistic\BarangController::class)->setName('logistic-good');
        $this->get('/add', App\Controller\Logistic\BarangController::class.':form')->setName('logistic-good-add');
        $this->get('/edit/{id}', App\Controller\Logistic\BarangController::class.':form')->setName('logistic-good-edit');
        $this->post('/save', App\Controller\Logistic\BarangController::class.':save')->setName('logistic-good-save');
        $this->get('/delete/{id}', App\Controller\Logistic\BarangController::class.':delete')->setName('logistic-good-delete');
    });

    //konversi satuan
    $this->group('/conversion', function () {
        $this->get('[/]', App\Controller\Logistic\KonversiController::class)->setName('logistic-conversion');
        $this->get('/add', App\Controller\Logistic\KonversiController::class.':form')->setName('logistic-conversion-add');
        $this->get('/edit/{id}', App\Controller\Logistic\KonversiController::class.':form')->setName('logistic-conversion-edit');
        $this->post('/save', App\Controller\Logistic\KonversiController::class.':save')->setName('logistic-conversion-save');
        $this->get('/delete/{id}', App\Controller\Logistic\KonversiController::class.':delete')->setName('logistic-conversion-delete');

    });

    // kategori
    $this->group('/category', function () {
        $this->get('[/]', App\Controller\Logistic\BrgkategoriController::class)->setName('logistic-category');
        $this->get('/add', App\Controller\Logistic\BrgkategoriController::class.':form')->setName('logistic-category-add');
        $this->get('/edit/{id}', App\Controller\Logistic\BrgkategoriController::class.':form')->setName('logistic-category-edit');
        $this->post('/save', App\Controller\Logistic\BrgkategoriController::class.':save')->setName('logistic-category-save');
        $this->get('/delete/{id}', App\Controller\Logistic\BrgkategoriController::class.':delete')->setName('logistic-category-delete');

    });

    //satuan
    $this->group('/unit', function () {
        $this->get('[/]', App\Controller\Logistic\BrgsatuanController::class)->setName('logistic-unit');
        $this->get('/add', App\Controller\Logistic\BrgsatuanController::class.':form')->setName('logistic-unit-add');
        $this->get('/edit/{id}', App\Controller\Logistic\BrgsatuanController::class.':form')->setName('logistic-unit-edit');
        $this->post('/save', App\Controller\Logistic\BrgsatuanController::class.':save')->setName('logistic-unit-save');
        $this->get('/delete/{id}', App\Controller\Logistic\BrgsatuanController::class.':delete')->setName('logistic-unit-delete');
    });

    // Barang Hilang
    $this->group('/loss-item', function () {
        $this->map(["GET","POST"],'[/]', App\Controller\Logistic\GudhilangController::class)->setName('logistic-loss-item');
        $this->get('/add', App\Controller\Logistic\GudhilangController::class.':form')->setName('logistic-loss-item-add');
        $this->get('/edit/{id}', App\Controller\Logistic\GudhilangController::class.':form')->setName('logistic-loss-item-edit');
        $this->post('/save', App\Controller\Logistic\GudhilangController::class.':save')->setName('logistic-loss-item-save');
        $this->get('/delete/{id}', App\Controller\Logistic\GudhilangController::class.':delete')->setName('logistic-loss-item-delete');
        $this->get('/report/{id}', App\Controller\Logistic\GudhilangController::class.':report')->setName('logistic-loss-item-report');
    });

    // Permintaan Barang
    $this->group('/purchase-request', function () {
        $this->map(["GET","POST"],'[/]', App\Controller\Logistic\PermintaanBarangController::class)->setName('logistic-purchase-request');
        $this->get('/add', App\Controller\Logistic\PermintaanBarangController::class.':form')->setName('logistic-purchase-request-add');
        $this->get('/edit/{id}', App\Controller\Logistic\PermintaanBarangController::class.':form')->setName('logistic-purchase-request-edit');
        $this->post('/save', App\Controller\Logistic\PermintaanBarangController::class.':save')->setName('logistic-purchase-request-save');
        $this->get('/delete/{id}', App\Controller\Logistic\PermintaanBarangController::class.':delete')->setName('logistic-purchase-request-delete');
        $this->get('/report/{id}', App\Controller\Logistic\PermintaanBarangController::class.':report')->setName('logistic-purchase-request-report');
        $this->post('/posted', App\Controller\Logistic\PermintaanBarangController::class.':posted')->setName('logistic-purchase-request-posted');
        $this->get('/status/{id}', App\Controller\Logistic\PermintaanBarangController::class.':status')->setName('logistic-purchase-request-delete-status');
        $this->get('/request', App\Controller\Logistic\PermintaanBarangController::class.':form')->setName('logistic-purchase-request-request');
    });

    // Pemakaian Barang
    $this->group('/usage', function () {
        $this->map(["GET","POST"],'[/]', App\Controller\Logistic\GudpakaiController::class)->setName('logistic-usage');
        $this->get('/add', App\Controller\Logistic\GudpakaiController::class.':form')->setName('logistic-usage-add');
        $this->get('/edit/{id}', App\Controller\Logistic\GudpakaiController::class.':form')->setName('logistic-usage-edit');
        $this->post('/save', App\Controller\Logistic\GudpakaiController::class.':save')->setName('logistic-usage-save');
        $this->get('/delete/{id}', App\Controller\Logistic\GudpakaiController::class.':delete')->setName('logistic-usage-delete');
        $this->get('/report/{id}', App\Controller\Logistic\GudpakaiController::class.':report')->setName('logistic-usage-report');
    });

    // Mutasi Gudang
    $this->group('/mutation', function () {
        $this->map(["GET","POST"],'[/]', App\Controller\Logistic\GudpindahController::class)->setName('logistic-mutation');
        $this->get('/add', App\Controller\Logistic\GudpindahController::class.':form')->setName('logistic-mutation-add');
        $this->get('/edit/{id}', App\Controller\Logistic\GudpindahController::class.':form')->setName('logistic-mutation-edit');
        $this->post('/save', App\Controller\Logistic\GudpindahController::class.':save')->setName('logistic-mutation-save');
        $this->get('/delete/{id}', App\Controller\Logistic\GudpindahController::class.':delete')->setName('logistic-mutation-delete');
        $this->get('/report/{id}', App\Controller\Logistic\GudpindahController::class.':report')->setName('logistic-mutation-report');
    });

    // Stok Opname
    $this->group('/stocktaking', function () {
        $this->map(["GET","POST"],'[/]', App\Controller\Logistic\GudopnameController::class)->setName('logistic-stocktaking');
        $this->get('/add', App\Controller\Logistic\GudopnameController::class.':form')->setName('logistic-stocktaking-add');
        $this->get('/edit/{id}', App\Controller\Logistic\GudopnameController::class.':form')->setName('logistic-stocktaking-edit');
        $this->post('/save', App\Controller\Logistic\GudopnameController::class.':save')->setName('logistic-stocktaking-save');
        $this->get('/delete/{id}', App\Controller\Logistic\GudopnameController::class.':delete')->setName('logistic-stocktaking-delete');
        $this->get('/report/{id}', App\Controller\Logistic\GudopnameController::class.':report')->setName('logistic-stocktaking-report');
    });

    $this->group('/report', function () {
        $this->map(["GET","POST"],'/usage[/]', App\Controller\Logistic\GudpakaiController::class.':report_all')->setName('logistic-usage-report-all');
        $this->map(["GET","POST"],'/revision[/]', App\Controller\Logistic\GudrevisiController::class.':report_all')->setName('logistic-revision-report-all');
        $this->map(["GET","POST"],'/loss-item[/]', App\Controller\Logistic\GudhilangController::class.':report_all')->setName('logistic-loss-item-report-all');
        $this->map(["GET","POST"],'/mutation[/]', App\Controller\Logistic\GudpindahController::class.':report_all')->setName('logistic-mutation-report-all');
        $this->map(["GET","POST"],'/receive[/]', App\Controller\Logistic\GudterimaController::class.':report_all')->setName('logistic-receive-report-all');
        $this->map(["GET","POST"],'/stock-card[/]', App\Controller\Logistic\KartuStokController::class.':stock_card')->setName('logistic-stock-card');
        $this->map(["GET","POST"],'/stock[/]', App\Controller\Logistic\StokController::class.':stock')->setName('logistic-stock-report');
    });

    // Revisi Stok
    $this->group('/revision', function () {
        $this->map(["GET","POST"],'[/]', App\Controller\Logistic\GudrevisiController::class)->setName('logistic-revision');
        $this->get('/add', App\Controller\Logistic\GudrevisiController::class.':form')->setName('logistic-revision-add');
        $this->get('/edit/{id}', App\Controller\Logistic\GudrevisiController::class.':form')->setName('logistic-revision-edit');
        $this->post('/save', App\Controller\Logistic\GudrevisiController::class.':save')->setName('logistic-revision-save');
        $this->get('/delete/{id}', App\Controller\Logistic\GudrevisiController::class.':delete')->setName('logistic-revision-delete');
        $this->get('/report/{id}', App\Controller\Logistic\GudrevisiController::class.':report')->setName('logistic-revision-report');
    });

    // Revisi Stok
    $this->group('/receive', function () {
        $this->map(["GET","POST"],'[/]', App\Controller\Logistic\GudterimaController::class)->setName('logistic-receive');
        $this->get('/add/{pembelian_id}', App\Controller\Logistic\GudterimaController::class.':form')->setName('logistic-receive-add');
        $this->get('/edit/{id}', App\Controller\Logistic\GudterimaController::class.':form')->setName('logistic-receive-edit');
        $this->post('/save', App\Controller\Logistic\GudterimaController::class.':save')->setName('logistic-receive-save');
        $this->get('/delete/{id}', App\Controller\Logistic\GudterimaController::class.':delete')->setName('logistic-receive-delete');
        $this->get('/report/{id}', App\Controller\Logistic\GudterimaController::class.':report')->setName('logistic-receive-report');
    });

    $this->group('/barcode', function () {
        $this->map(["GET","POST"],'[/]', App\Controller\Logistic\BarcodeController::class)->setName('logistic-barcode');
    });

})->add('accessControlMiddleware')
->add('authMiddleware')
->add('LoginDataMiddleware');

$app->group('/housekeeping', function(){

  $this->group('/room-service', function(){
    $this->map(["GET","POST"],'[/]',App\Controller\Housekeeping\RoomServiceController::class)
          ->setName('houskeeping-roomservice');
    $this->get('/add',App\Controller\Housekeeping\RoomServiceController::class.':form')
          ->setName('houskeeping-roomservice-form');
    $this->get('/edit/{id}',App\Controller\Housekeeping\RoomServiceController::class.':form')
          ->setName('houskeeping-roomservice-edit');
    $this->post('/save',App\Controller\Housekeeping\RoomServiceController::class.':save')
          ->setName('houskeeping-roomservice-save');
    $this->get('/delete/{id}',App\Controller\Housekeeping\RoomServiceController::class.':delete')
          ->setName('houskeeping-roomservice-delete');
  });

  $this->group('/laundry-tarif', function(){
    $this->get('/', App\Controller\Housekeeping\PricelaundryController::class)
         ->setName('housekeeping-laundry-tarif');
    $this->get('/add', App\Controller\Housekeeping\PricelaundryController::class. ':form')
         ->setName('housekeeping-laundry-tarif-add');
    $this->get('/edit/{id}', App\Controller\Housekeeping\PricelaundryController::class. ':form')
         ->setName('housekeeping-laundry-tarif-edit');
    $this->post('/save', App\Controller\Housekeeping\PricelaundryController::class. ':save')
          ->setName('housekeeping-laundry-tarif-save');
    $this->get('/delete/{id}', App\Controller\Housekeeping\PricelaundryController::class. ':delete')
          ->setName('housekeeping-laundry-tarif-delete');
    });

  $this->group('/laundry-layanan', function(){
    $this->get('/', App\Controller\Housekeeping\LaundryserviceController::class)
         ->setName('housekeeping-laundry-layanan');
    $this->get('/add', App\Controller\Housekeeping\LaundryserviceController::class. ':form')
         ->setName('housekeeping-laundry-layanan-add');
    $this->get('/edit/{id}', App\Controller\Housekeeping\LaundryserviceController::class. ':form')
         ->setName('housekeeping-laundry-layanan-edit');
    $this->post('/save', App\Controller\Housekeeping\LaundryserviceController::class. ':save')
          ->setName('housekeeping-laundry-layanan-save');
    $this->get('/delete/{id}', App\Controller\Housekeeping\LaundryserviceController::class. ':delete')
          ->setName('housekeeping-laundry-layanan-delete');
  });

  $this->group('/pinjam-barang', function(){
    $this->get('[/]',App\Controller\Housekeeping\BorrowController::class)
          ->setName('houskeeping-pinjambarang');
    $this->get('/add',App\Controller\Housekeeping\BorrowController::class.':form')
          ->setName('houskeeping-pinjambarang-form');
    $this->get('/edit/{id}',App\Controller\Housekeeping\BorrowController::class.':form')
          ->setName('houskeeping-pinjambarang-edit');
    $this->post('/save',App\Controller\Housekeeping\BorrowController::class.':save')
          ->setName('houskeeping-pinjambarang-save');
    $this->get('/delete/{id}',App\Controller\Housekeeping\BorrowController::class.':delete')
          ->setName('houskeeping-pinjambarang-delete');
  });

  $this->group('/jenis-barang-pinjam', function(){
    $this->get('[/]',App\Controller\Housekeeping\BorrowTypeController::class)
          ->setName('houskeeping-jenis-pinjambarang');
    $this->get('/add',App\Controller\Housekeeping\BorrowTypeController::class.':form')
          ->setName('houskeeping-jenis-pinjambarang-form');
    $this->get('/edit/{id}',App\Controller\Housekeeping\BorrowTypeController::class.':form')
          ->setName('houskeeping-jenis-pinjambarang-edit');
    $this->post('/save',App\Controller\Housekeeping\BorrowTypeController::class.':save')
          ->setName('houskeeping-jenis-pinjambarang-save');
    $this->get('/delete/{id}',App\Controller\Housekeeping\BorrowTypeController::class.':delete')
          ->setName('houskeeping-jenis-pinjambarang-delete');
  });

  $this->group('/barang-temuan', function(){
    $this->get('/', App\Controller\Housekeeping\FindItemController::class)
         ->setName('housekeeping-barangtemuan');
    $this->get('/add', App\Controller\Housekeeping\FindItemController::class. ':form')
         ->setName('housekeeping-barangtemuan-add');
    $this->get('/edit/{id}', App\Controller\Housekeeping\FindItemController::class. ':form')
         ->setName('housekeeping-barangtemuan-edit');
    $this->post('/save', App\Controller\Housekeeping\FindItemController::class. ':save')
         ->setName('housekeeping-barangtemuan-save');
    $this->get('/delete/{id}', App\Controller\Housekeeping\FindItemController::class. ':delete')
         ->setName('housekeeping-barangtemuan-delete');
  });

  $this->group('/barang-hilang', function(){
    $this->get('/', App\Controller\Housekeeping\LostItemController::class)
         ->setName('housekeeping-barang');
    $this->get('/add', App\Controller\Housekeeping\LostItemController::class. ':form')
         ->setName('housekeeping-barang-add');
    $this->get('/edit/{id}', App\Controller\Housekeeping\LostItemController::class. ':form')
         ->setName('housekeeping-barang-edit');
    $this->post('/save', App\Controller\Housekeeping\LostItemController::class. ':save')
         ->setName('housekeeping-barang-save');
    $this->get('/delete/{id}', App\Controller\Housekeeping\LostItemController::class. ':delete')
         ->setName('housekeeping-barang-delete');
  });

  $this->group('/barang-kembali', function(){
    $this->get('/', App\Controller\Housekeeping\ReturnItemController::class)
         ->setName('housekeeping-barangkembali');
    $this->get('/add', App\Controller\Housekeeping\ReturnItemController::class. ':form')
         ->setName('housekeeping-barangkembali-add');
    $this->get('/edit/{id}', App\Controller\Housekeeping\ReturnItemController::class. ':form')
         ->setName('housekeeping-barangkembali-edit');
    $this->post('/save', App\Controller\Housekeeping\ReturnItemController::class. ':save')
         ->setName('housekeeping-barangkembali-save');
    $this->get('/delete/{id}', App\Controller\Housekeeping\ReturnItemController::class. ':delete')
         ->setName('housekeeping-barangkembali-delete');
  });

  $this->group('/report', function(){
    $this->get('/baranghilang-filter', App\Controller\Housekeeping\Report\LostItemReportController::class.':filter')
        ->setName('housekeeping-report-baranghilang-filter');
    $this->post('/baranghilang', App\Controller\Housekeeping\Report\LostItemReportController::class.':display')
        ->setName('housekeeping-report-baranghilang');
    $this->get('/barangtemuan-filter', App\Controller\Housekeeping\Report\FindItemReportController::class.':filter')
        ->setName('housekeeping-report-barangtemuan-filter');
    $this->post('/barangtemuan', App\Controller\Housekeeping\Report\FindItemReportController::class.':display')
        ->setName('housekeeping-report-barangtemuan');
    $this->get('/pendapatanlaundry-filter', App\Controller\Housekeeping\Report\LaundryReportController::class.':filter')
        ->setName('housekeeping-report-pendapatanlaundry-filter');
    $this->post('/pendapatanlaundry', App\Controller\Housekeeping\Report\LaundryReportController::class.':display')
        ->setName('housekeeping-report-pendapatanlaundry');
    $this->get('/pemeliharaankamar-filter', App\Controller\Housekeeping\Report\RoomReportController::class.':filter')
        ->setName('housekeeping-report-pemeliharaankamar-filter');
    $this->post('/pemeliharaankamar', App\Controller\Housekeeping\Report\RoomReportController::class.':display')
        ->setName('housekeeping-report-pemeliharaankamar');
    $this->get('/pinjambarang-filter', App\Controller\Housekeeping\Report\BorrowReportController::class.':filter')
        ->setName('housekeeping-report-pinjambarang-filter');
    $this->post('/pinjambarang', App\Controller\Housekeeping\Report\BorrowReportController::class.':display')
        ->setName('housekeeping-report-pinjambarang');
    $this->get('/roomserviceschedule-filter', App\Controller\Housekeeping\Report\RoomservicescheduleController::class.':filter')
        ->setName('housekeeping-report-roomserviceschedule-filter');
    $this->post('/roomserviceschedule', App\Controller\Housekeeping\Report\RoomservicescheduleController::class.':display')
        ->setName('housekeeping-report-roomserviceschedule');
    $this->get('/roomserviceschedule/{id}', App\Controller\Housekeeping\Report\RoomservicescheduleController::class.':display1')
        ->setName('housekeeping-report-roomserviceschedule1');
  });

  $this->group('/laundry', function(){
    $this->get('/', App\Controller\Housekeeping\LaundryController::class)
         ->setName('housekeeping-laundry');
    $this->get('/add', App\Controller\Housekeeping\LaundryController::class. ':form')
         ->setName('housekeeping-laundry-add');
    $this->get('/edit/{id}', App\Controller\Housekeeping\LaundryController::class. ':form')
         ->setName('housekeeping-laundry-edit');
    $this->post('/save', App\Controller\Housekeeping\LaundryController::class. ':save')
          ->setName('housekeeping-laundry-save');
    $this->get('/delete/{id}', App\Controller\Housekeeping\LaundryController::class. ':delete')
          ->setName('housekeeping-laundry-delete');
    $this->get('/cetak/{id}', App\Controller\Housekeeping\LaundryController::class. ':cetak')
          ->setName('housekeeping-laundry-cetak');
    $this->get('/kasir/{id}', App\Controller\Housekeeping\LaundryController::class. ':kasir')
          ->setName('housekeeping-laundry-kasir');
    $this->post('/kasirsave', App\Controller\Housekeeping\LaundryController::class. ':kasirsave')
          ->setName('housekeeping-laundry-kasirsave');
    });

$this->group('/room-status', function(){
    $this->map(["GET","POST"],'[/]', App\Controller\Housekeeping\HkRoomStatusController::class)
         ->setName('housekeeping-room-status');
    $this->post('/save', App\Controller\Housekeeping\HkRoomStatusController::class. ':save')
          ->setName('housekeeping-room-status-save');
    $this->post('/process', App\Controller\Housekeeping\HkRoomStatusController::class. ':process')
          ->setName('housekeeping-room-status-process');
    });


})->add('accessControlMiddleware')
  ->add('authMiddleware')
  ->add('LoginDataMiddleware');

$app->group('/spa', function () {
    
  //terapis
  $this->group('/terapis', function () {
     $this->get('[/]', App\Controller\Spa\SpaController::class)->setName('terapis');
     $this->get('/add', App\Controller\Spa\SpaController::class.':form')->setName('terapis-new');
     $this->get('/edit/{id}', App\Controller\Spa\SpaController::class.':form')->setName('terapis-edit');
     $this->get('/delete/{id}', App\Controller\Spa\SpaController::class.':delete')->setName('terapis-delete');
     $this->post('/save', App\Controller\Spa\SpaController::class.':save')->setName('terapis-save');
     $this->get('/add/{data}', App\Controller\Spa\SpaController::class.':form')->setName('terapis-data');
  });

  //Layanan
    $this->group('/layanan', function () {
        $this->get('[/]', App\Controller\Spa\LayananController::class)->setName('layanan');
        $this->get('/add', App\Controller\Spa\LayananController::class.':form')->setName('spa-layanan-new');
        $this->get('/edit/{id}', App\Controller\Spa\LayananController::class.':form')->setName('spa-layanan-edit');
        $this->get('/delete/{id}', App\Controller\Spa\LayananController::class.':delete')->setName('spa-layanan-delete');
        $this->post('/save', App\Controller\Spa\LayananController::class.':save')->setName('spa-layanan-save');
        $this->get('/ajax', App\Controller\Spa\LayananController::class.':ajax')->setName('spa-layanan-ajax');
        $this->post('/ajaxKonversi', App\Controller\Spa\LayananController::class.':ajaxKonversi')->setName('spa-layanan-ajaxKonversi');
    });

    //KasirSpa
    $this->group('/kasirspa', function () {
        $this->get('[/]', App\Controller\Spa\KasirSpaController::class)->setName('kasirspa');
        $this->get('/add', App\Controller\Spa\KasirSpaController::class.':form')->setName('kasirspa-add');
        // $this->get('/add/{data}', App\Controller\Spa\KasirSpaController::class.':form')->setName('kasirspa-data');
        $this->get('/edit/{id}', App\Controller\Spa\KasirSpaController::class.':form')->setName('kasirspa-edit');
        $this->post('/save', App\Controller\Spa\KasirSpaController::class.':save')->setName('kasirspa-save');
        $this->get('/delete/{id}', App\Controller\Spa\KasirSpaController::class.':delete')->setName('kasirspa-delete');
        $this->get('/ajax/{id}', App\Controller\Spa\KasirSpaController::class.':ajax')->setName('kasirspa-ajax');
        $this->get('/kasirspa-report/{id}', App\Controller\Spa\KasirSpaController::class.':kasirspareport')
            ->setName('kasirspa-report');
    });

  //kategorilayanan
  $this->group('/kategorilayanan', function () {
        $this->get('[/]', App\Controller\Spa\KategoriLayananController::class)->setName('kategorilayanan');
        $this->get('/add', App\Controller\Spa\KategoriLayananController::class.':form')->setName('kategorilayanan-add');
        $this->get('/edit/{id}', App\Controller\Spa\KategoriLayananController::class.':form')->setName('kategorilayanan-edit');
        $this->get('/delete/{id}', App\Controller\Spa\KategoriLayananController::class.':delete')->setName('kategorilayanan-delete');
        $this->post('/save', App\Controller\Spa\KategoriLayananController::class.':save')->setName('kategorilayanan-save');
    });

    //Gudangspa
    $this->group('/gudangspa', function () {
       $this->get('[/]', App\Controller\Spa\GudangSpaController::class)->setName('gudangspa');
       $this->get('/add', App\Controller\Spa\GudangSpaController::class.':form')->setName('gudangspa-new');
       $this->get('/edit/{id}', App\Controller\Spa\GudangSpaController::class.':form')->setName('gudangspa-edit');
       $this->get('/delete/{id}', App\Controller\Spa\GudangSpaController::class.':delete')->setName('gudangspa-delete');
       $this->post('/save', App\Controller\Spa\GudangSpaController::class.':save')->setName('gudangspa-save');
       $this->post('/ajax', App\Controller\Spa\GudangSpaController::class.':ajax')->setName('gudangspa-ajax');
   });

    //reportspa
    $this->group('/report', function () {
     $this->get('/layanan', App\Controller\Spa\Report\LayananReportController::class)->setName('layanan-report');
     $this->map(["GET","POST"],'/terapis', App\Controller\Spa\Report\TerapisReportController::class)->setName('terapis-report');
     $this->get('/terapis/print/{start}/{end}', App\Controller\Spa\Report\TerapisReportController::class.':printterapiskinerja')->setName('terapis-report-print-kinerja');
     $this->get('/terapis/print', App\Controller\Spa\Report\TerapisReportController::class.':printterapis')->setName('terapis-report-print');
     $this->post('/spapenjualan', App\Controller\Spa\Report\PenjualanSpaReportController::class)->setName('penjualan-spa-report');
    $this->map(["GET","POST"],'/rekap-penjualan-spa', App\Controller\Spa\Report\PenjualanSpaReportController::class.':rekappenjualanspa')
            ->setName('report-rekap-penjualan-spa');
    $this->map(["GET","POST"],'/rekap-penjualan-spa-print', App\Controller\Spa\Report\PenjualanSpaReportController::class.':rekappenjualanspaprint')
            ->setName('spa-report-rekap-penjualan-print');
    $this->map(["GET","POST"],'/laporan-penjualan-spa', App\Controller\Spa\Report\PenjualanSpaReportController::class.':laporanpenjualanspa')->setName('laporan-penjualan-spa-report');
    $this->get('/laporan-penjualan-spa-print/{id}/{date}', App\Controller\Spa\Report\PenjualanSpaReportController::class.':laporanpenjualanspaprint')
            ->setName('laporan-penjualan-spa-report-print');
  });

})->add('accessControlMiddleware')
->add('authMiddleware')
->add('LoginDataMiddleware');

// jobdesc
$app->group('/board', function() {
    $this->get('/{id}', App\Controller\Jobdesc\BoardController::class)->setName('tampil-board');
    $this->post('/save', App\Controller\Jobdesc\BoardController::class.':save')->setName('save-board');
    $this->post('/member', App\Controller\Jobdesc\BoardController::class.':member')->setName('member');
    // $this->get('/add', App\Controller\BoardController::class.':form')->setName('form-board');
    // $this->get('/update/{id}', App\Controller\BoardController::class.':form')->setName('update-board');
    $this->get('/list/{id}', App\Controller\Jobdesc\ListController::class)->setName('list-board');
    $this->post('/save-list', App\Controller\Jobdesc\ListController::class.':save')->setName('save-list');
    // $this->get('/delete/{id}', App\Controller\BoardController::class.':delete')->setName('delete-board');

    $this->get('/card/{id}', App\Controller\Jobdesc\ListController::class)->setName('card-board');
    $this->post('/save-card', App\Controller\Jobdesc\CardController::class.':save')->setName('save-card');
    $this->get('/delete/card/{board}/{id}', App\Controller\Jobdesc\CardController::class.':delete')->setName('hapus-card');
    $this->post('/save-cardname', App\Controller\Jobdesc\ListController::class.':savecard')->setName('save-cardname');

    $this->post('/save-checklist', App\Controller\Jobdesc\ChecklistController::class.':save')->setName('save-checklist');
    $this->get('/checklist/lihat/{id}', App\Controller\Jobdesc\ChecklistController::class)->setName('checklist-tampil');

    $this->post('/save-child', App\Controller\Jobdesc\ChildlistController::class.':save')->setName('save-child');
    $this->get('/childlist/lihat/{id}', App\Controller\Jobdesc\ChildlistController::class)->setName('child-tampil');
    $this->get('/childlist/delete/{id}', App\Controller\Jobdesc\ChildlistController::class.':delete')->setName('child-delete');
    $this->get('/childlist/save/{card}/{id}/{nama}/{status}', App\Controller\Jobdesc\ChildlistController::class.':saveactive')->setName('child-save');


    $this->get('/activities/lihat/{id}', App\Controller\Jobdesc\ActivityController::class)->setName('activity-tampil');
    $this->get('/activities/all/{id}', App\Controller\Jobdesc\ActivityController::class.':allview')->setName('all-activity');
    $this->post('/attachment', App\Controller\Jobdesc\CardController::class.':attachment')->setName('attachment');

})->add('accessControlMiddleware')
->add('authMiddleware')
->add('LoginDataMiddleware');

// Biaya telepon
$app->group('/telp', function() {

    //biaya
    $this->group('/biaya', function () {
         $this->get('[/]', App\Controller\Telepon\TeleponController::class)->setName('telpbiaya');
         $this->get('/add', App\Controller\Telepon\TeleponController::class.':formbiaya')->setName('telpbiaya-new');
         $this->get('/edit/{id}', App\Controller\Telepon\TeleponController::class.':formbiaya')->setName('telpbiaya-edit');
         $this->get('/delete/{id}', App\Controller\Telepon\TeleponController::class.':deletebiaya')->setName('telpbiaya-delete');
         $this->post('/save', App\Controller\Telepon\TeleponController::class.':biayasave')->setName('telpbiaya-save');
    });

    //Extention
    $this->group('/extention', function () {
         $this->get('[/]', App\Controller\Telepon\TeleponController::class.':telpextension')->setName('telpextention');
         $this->get('/add', App\Controller\Telepon\TeleponController::class.':formextention')->setName('telpextention-new');
         $this->get('/edit/{id}', App\Controller\Telepon\TeleponController::class.':formextention')->setName('telpextention-edit');
         $this->get('/delete/{id}', App\Controller\Telepon\TeleponController::class.':deleteextention')->setName('telpextention-delete');
         $this->post('/save', App\Controller\Telepon\TeleponController::class.':extentionsave')->setName('telpextention-save');
    });

    //billing
    $this->group('/billing', function () {
        $this->get('[/]', App\Controller\Telepon\TeleponController::class.':billing')->setName('telp-billing');
        $this->get('/view', App\Controller\Telepon\TeleponController::class.':billingview')->setName('telp-billing-view');
        $this->get('/form', App\Controller\Telepon\TeleponController::class.':billingform')->setName('telp-billing-form');
        $this->map(["GET","POST"],'/setup', App\Controller\Telepon\TeleponController::class.':setup')->setName('telp-setup');
    });

})->add('accessControlMiddleware')
->add('authMiddleware')
->add('LoginDataMiddleware');

// store
$app->group('/store', function() {
   //Gudang
    $this->group('/gudang', function () {
       $this->get('[/]', App\Controller\Store\GudangController::class)->setName('store-gudang');
       $this->get('/add', App\Controller\Store\GudangController::class.':form')->setName('store-gudang-new');
       $this->get('/edit/{id}', App\Controller\Store\GudangController::class.':form')->setName('store-gudang-edit');
       $this->get('/delete/{id}', App\Controller\Store\GudangController::class.':delete')->setName('store-gudang-delete');
       $this->post('/save', App\Controller\Store\GudangController::class.':save')->setName('store-gudang-save');
       $this->post('/ajax', App\Controller\Store\GudangController::class.':ajax')->setName('store-gudang-ajax');
   });

    $this->group('/kasir', function () {
        $this->get('[/]', App\Controller\Store\KasirController::class)->setName('store-kasir');
        $this->get('/add', App\Controller\Store\KasirController::class.':form')->setName('store-kasir-add');
        $this->post('/save', App\Controller\Store\KasirController::class.':save')->setName('store-kasir-save');
        $this->get('/edit/{id}', App\Controller\Store\KasirController::class.':form')->setName('store-kasir-edit');
        $this->get('/delete/{id}', App\Controller\Store\KasirController::class.':delete')->setName('store-kasir-delete');
        $this->get('/ajax/{id}', App\Controller\Store\KasirController::class.':ajax')->setName('store-kasir-ajax');
        $this->get('/kasir-report/{id}', App\Controller\Store\KasirController::class.':kasirreport')
            ->setName('store-kasir-report');
    });

    $this->group('/barang', function () {
       $this->get('[/]', App\Controller\Store\BarangController::class)->setName('store-barang');
       $this->get('/add', App\Controller\Store\BarangController::class.':form')->setName('store-barang-add');
       $this->get('/edit/{id}', App\Controller\Store\BarangController::class.':form')->setName('store-barang-edit');
       $this->get('/delete/{id}', App\Controller\Store\BarangController::class.':delete')->setName('store-barang-delete');
       $this->post('/save', App\Controller\Store\BarangController::class.':save')->setName('store-barang-save');
   });
   $this->map(["GET","POST"],'/laporan-penjualan', App\Controller\Store\KasirController::class.':laporanpenjualan')
            ->setName('store-laporan-penjualan');
   $this->get('/laporan-penjualan-print/{date}', App\Controller\Store\KasirController::class.':laporanpenjualanprint')->setName('store-laporan-penjualan-print');

})->add('accessControlMiddleware')
->add('authMiddleware')
->add('LoginDataMiddleware');

$app->group('/comment', function() {
    $this->post('/save', App\Controller\Jobdesc\CommentController::class.':save')->setName('comment-save');
    $this->get('/lihat/{id}', App\Controller\Jobdesc\CommentController::class)->setName('comment-tampil');

})->add('accessControlMiddleware')
->add('authMiddleware')
->add('LoginDataMiddleware');


/**
* ADMINISTRATIVE AREA
*       ||
*       ||
*       ||
*       ||
*       VV
**/

// Example route with middleware
$app->get('/test', function($req,$res,$args){
    $options = Kulkul\Options::all();
});

$app->group('/migrate', function () {
    $this->get('[/]', function ($request, $response, $args) {

        $setupMigrationRunner = new App\MigrationRunner\SetupMigrationRunner();
        $setupMigrationRunner->run($this);

        $accountingMigrationRunner = new App\MigrationRunner\AccountingMigrationRunner();
        $accountingMigrationRunner->run($this);

        $frontDeskMigrationRunner = new App\MigrationRunner\FrontDeskMigrationRunner();
        $frontDeskMigrationRunner->run($this);

        $logisticMigrationRunner = new App\MigrationRunner\LogisticMigrationRunner();
        $logisticMigrationRunner->run($this);

        $RestoranMigrationRunner = new App\MigrationRunner\RestoranMigrationRunner();
        $RestoranMigrationRunner->run($this);

        $SpaMigrationRunner = new App\MigrationRunner\SpaMigrationRunner();
        $SpaMigrationRunner->run($this);

        $pembelianMigrationRunner = new App\MigrationRunner\PembelianMigrationRunner();
        $pembelianMigrationRunner->run($this);

        $HousekeepingMigrationRunner = new App\MigrationRunner\HousekeepingMigrationRunner();
        $HousekeepingMigrationRunner->run($this);

        $JobdescMigrationRunner = new App\MigrationRunner\JobdescMigrationRunner();
        $JobdescMigrationRunner->run($this);

        $TelpMigrationRunner = new App\MigrationRunner\TelpMigrationRunner();
        $TelpMigrationRunner->run($this);

        $StoreMigrationRunner = new App\MigrationRunner\StoreMigrationRunner();
        $StoreMigrationRunner->run($this);

        return $response;
    });
});


$app->group('/demo', function () {
    $this->get('[/]', function ($request, $response, $args) {

        $setupDemoSeeding = new App\Demo\SetupSeeding();
        $setupDemoSeeding->run($this);

        $frontDeskDemoSeeding = new App\Demo\FrontDeskSeeding();
        $frontDeskDemoSeeding->run($this);

        $accountingDeskDemoSeeding = new App\Demo\AccountingSeeding();
        $accountingDeskDemoSeeding->run($this);

        return $response;
    });
});
