<?php
namespace App\MigrationRunner;
use Illuminate\Database\Capsule\Manager as Capsule;

class SpaMigrationRunner
{
   public function run($callerContext)
   {

        $SpaterapisMigration = new \App\Migration\SpaterapisMigration();
        $SpaterapisMigration->createTable();

        $SpakasirMigration = new \App\Migration\SpakasirMigration();
        $SpakasirMigration->createTable();

        $SpakasirdetailMigration = new \App\Migration\SpakasirdetailMigration();
        $SpakasirdetailMigration->createTable();

        $SpakategoriMigration = new \App\Migration\SpakategoriMigration();
        $SpakategoriMigration->createTable();

        $SpalayananMigration = new \App\Migration\SpalayananMigration();
        $SpalayananMigration->createTable();

        $SpalayanandetailMigration = new \App\Migration\SpalayanandetailMigration();
        $SpalayanandetailMigration->createTable();

        $SpagudangMigration = new \App\Migration\SpagudangMigration();
        $SpagudangMigration->createTable();
  
   }
}