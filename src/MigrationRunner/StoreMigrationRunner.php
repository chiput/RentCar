<?php
namespace App\MigrationRunner;

class StoreMigrationRunner
{
   public function run($callerContext)
   {
        $gudterima = new \App\Migration\StoregudangMigration();
        $gudterima->createTable();  

        $storekasir = new \App\Migration\StorekasirMigration();
        $storekasir->createTable();   

        $storekasirdetail = new \App\Migration\StorekasirdetailMigration();
        $storekasirdetail->createTable();      

        $storebarang = new \App\Migration\StorebarangMigration();
        $storebarang->createTable();  
   }
}