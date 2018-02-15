<?php
namespace App\MigrationRunner;

class PembelianMigrationRunner
{
   public function run($callerContext)
   {
     
        $supplierMigration = new \App\Migration\SupplierMigration();
        $supplierMigration->createTable();

        $pembelianMigration = new \App\Migration\PembelianMigration();
        $pembelianMigration->createTable();

        $pembelianDetailMigration = new \App\Migration\PembelianDetailMigration();
        $pembelianDetailMigration->createTable();

        $PembelianReturMigration = new \App\Migration\PembelianReturMigration();
        $PembelianReturMigration->createTable();

        $PembelianReturDetailMigration = new \App\Migration\PembelianReturDetailMigration();
        $PembelianReturDetailMigration->createTable();

        $PembelianStatusMigration = new \App\Migration\PembelianStatusMigration();
        $PembelianStatusMigration->createTable();

        $GudmintastatusMigration = new \App\Migration\GudmintastatusMigration();
        $GudmintastatusMigration->createTable();

   }
}