<?php
namespace App\MigrationRunner;

class TelpMigrationRunner
{
   public function run($callerContext)
   {
     
        $TelpExtensionMigration = new \App\Migration\TelpExtensionMigration();
        $TelpExtensionMigration->createTable();

        $TelpBiayaMigration = new \App\Migration\TelpBiayaMigration();
        $TelpBiayaMigration->createTable();

        $TelpBillingMigration = new \App\Migration\TelpBillingMigration();
        $TelpBillingMigration->createTable();

   }
}