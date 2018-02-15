<?php
namespace App\MigrationRunner;

class SetupMigrationRunner
{
   public function run($callerContext)
   {
     
        $userMigration = new \App\Migration\UserMigration();
        $userMigration->createTable($callerContext);

        $buildings = new \App\Migration\BuildingsMigration();
        $buildings->createTable();

        $periodic_rates = new \App\Migration\PeriodicratesMigration();
        $periodic_rates->createTable();

        $periodic_rate_details = new \App\Migration\PeriodicratedetailsMigration();
        $periodic_rate_details->createTable();

        $departmentMigration = new \App\Migration\DepartmentMigration();
        $departmentMigration->createTable();

        $roomfacility = new \App\Migration\RoomFacilityMigration();
        $roomfacility->createTable();

        $roomdesc = new \App\Migration\RoomDescriptionMigration();
        $roomdesc->createTable();

        $roomtype = new \App\Migration\RoomTypeMigration();
        $roomtype->createTable();

        $room_rel_description = new \App\Migration\RoomreldescriptionMigration();
        $room_rel_description->createTable();

        $room_rel_facility = new \App\Migration\RoomrelfacilityMigration();
        $room_rel_facility->createTable();

        $room = new \App\Migration\RoomMigration();
        $room->createTable();

        $bedTypeMigration = new \App\Migration\BedTypeMigration();
        $bedTypeMigration->createTable();

        $DayNameMigration = new \App\Migration\DayNameMigration();
        $DayNameMigration->createTable();

        $RoomPriceMigration = new \App\Migration\RoomPriceMigration();
        $RoomPriceMigration->createTable();

        $CompanyMigration = new \App\Migration\CompanyMigration();
        $CompanyMigration->createTable();

        $IdTypeMigration = new \App\Migration\IdTypeMigration();
        $IdTypeMigration->createTable();

        $kota = new \App\Migration\KotaMigration();
        $kota->createTable();

        $negara = new \App\Migration\NegaraMigration();
        $negara->createTable();

        $propinsi = new \App\Migration\PropinsiMigration();
        $propinsi->createTable();

        $currency = new \App\Migration\CurrencyMigration();
        $currency->createTable();

        $currency_rate = new \App\Migration\CurrencyrateMigration();
        $currency_rate->createTable();

        $optionMigration = new \App\Migration\OptionMigration();
        $optionMigration->createTable();

        // resource category
        $resourceCategoryMigration = new \App\Migration\ResourceCategoryMigration();
        $resourceCategoryMigration->createTable();

        // resource
        $resourceMigration = new \App\Migration\ResourceMigration();
        $resourceMigration->createTable();

        // resource action
        $resourceActionMigration = new \App\Migration\ResourceActionMigration();
        $resourceActionMigration->createTable();

        // user permission
        $userPermissionMigration = new \App\Migration\UserPermissionMigration();
        $userPermissionMigration->createTable();

        // room status type 
        $roomStatusTypeMingration = new \App\Migration\RoomstatustypeMigration();
        $roomStatusTypeMingration->createTable();

        // log auditing 
        $LogAuditingMigration = new \App\Migration\LogAuditingMigration();
        $LogAuditingMigration->createTable();

        // Setup Gudang 
        $SetupgudangMigration = new \App\Migration\SetupgudangMigration();
        $SetupgudangMigration->createTable();

   }
}