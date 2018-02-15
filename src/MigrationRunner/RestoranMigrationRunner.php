<?php
namespace App\MigrationRunner;
use Illuminate\Database\Capsule\Manager as Capsule;

class RestoranMigrationRunner
{
   public function run($callerContext)
   {
        $resmenu = new \App\Migration\ResmenuMigration();
        $resmenu->createTable();

        $respelanggan = new \App\Migration\RespelangganMigration();
        $respelanggan->createTable();

        $MenukatagoriMigration = new \App\Migration\Menukatagori();
        $MenukatagoriMigration->createTable(); 

        $ResmejaMigration = new \App\Migration\ResmejaMigration();
        $ResmejaMigration->createTable();

        $RespelangganMigration = new \App\Migration\RespelangganMigration();
        $RespelangganMigration->createTable();

        $RespesananMigration = new \App\Migration\RespesananMigration();
        $RespesananMigration->createTable();

        $ResgudangMigration = new \App\Migration\Resgudang();
        $ResgudangMigration->createTable();

        $ResgudangMigration = new \App\Migration\ReswaiterMigration();
        $ResgudangMigration->createTable();

        $ResmenuMigration = new \App\Migration\ResmenuMigration();
        $ResmenuMigration->createTable();

        $ReskategoriMigration = new \App\Migration\ReskategoriMigration();
        $ReskategoriMigration->createTable();

        $ResmenudetailMigration = new \App\Migration\ResmenudetailMigration();
        $ResmenudetailMigration->createTable();

        $RespesanandetailMigration = new \App\Migration\RespesanandetailMigration();
        $RespesanandetailMigration->createTable();

        $ReskasirMigration = new \App\Migration\ReskasirMigration();
        $ReskasirMigration->createTable();

        $ReskasirdetailMigration = new \App\Migration\ReskasirdetailMigration();
        $ReskasirdetailMigration->createTable();

        $ReskasirkuMigration = new \App\Migration\ReskasirkuMigration();
        $ReskasirkuMigration->createTable();

        $ReskasirkudetailMigration = new \App\Migration\ReskasirkudetailMigration();
        $ReskasirkudetailMigration->createTable();

        $ResbookingMigration = new \App\Migration\ResbookingMigration();
        $ResbookingMigration->createTable();



        // if(Capsule::schema()->hasTable('addchargetypes'))
        // {
        //     $seed = array(
        //             array('id' => '1','code' => 'RESTO','name' => 'Restoran','accincome' => '0','acccost' => '0','sell' => '0','buy' => '0','is_active' => '0','is_editable' => '1','users_id' => '1','created_at' => '2017-03-11 11:44:23','updated_at' => NULL)
        //             );
        //     Capsule::table('addchargetypes')->insert($seed);
        // }

        Capsule::schema()->dropIfExists('reskasirwh');
        Capsule::schema()->dropIfExists('reskasirdetailwh');

   }
}