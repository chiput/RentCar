<?php
namespace App\MigrationRunner;

class HousekeepingMigrationRunner
{
   public function run($callerContext)
   {
        $BorrowMigration = new \App\Migration\BorrowMigration();
        $BorrowMigration->createTable();

        $BorrowTypeMigration = new \App\Migration\BorrowTypeMigration();
        $BorrowTypeMigration->createTable();

        $HottemuanMigration = new \App\Migration\HottemuanMigration();
        $HottemuanMigration->createTable();

        $HothilangMigration = new \App\Migration\HothilangMigration();
        $HothilangMigration->createTable();

        $LaunlayananMigration = new \App\Migration\LaunlayananMigration();
        $LaunlayananMigration->createTable();

        $LauntarifMigration = new \App\Migration\LauntarifMigration();
        $LauntarifMigration->createTable();

        $HotserviceMigration = new \App\Migration\HotserviceMigration();
        $HotserviceMigration->createTable();

        $HotservicebarangMigration = new \App\Migration\HotservicebarangMigration();
        $HotservicebarangMigration->createTable();

        $Hotservicedetail2Migration = new \App\Migration\Hotservicedetail2Migration();
        $Hotservicedetail2Migration->createTable();

        $LaundryMigration = new \App\Migration\LaundryMigration();
        $LaundryMigration->createTable();

        $LaundrydetailMigration = new \App\Migration\LaundrydetailMigration();
        $LaundrydetailMigration->createTable();

        $LaundrykasirMigration = new \App\Migration\LaundrykasirMigration();
        $LaundrykasirMigration->createTable();

        $RoomstatuslogMigration = new \App\Migration\RoomstatuslogMigration();
        $RoomstatuslogMigration->createTable();

   }
}
