<?php
namespace App\MigrationRunner;

class LogisticMigrationRunner
{
   public function run($callerContext)
   {
        $gudterima = new \App\Migration\GudterimaMigration();
        $gudterima->createTable();

        $gudterimadetail = new \App\Migration\GudterimadetailMigration();
        $gudterimadetail->createTable();

        $GudangMigration = new \App\Migration\GudangMigration();
        $GudangMigration->createTable();

        $BarangMigration = new \App\Migration\BarangMigration();
        $BarangMigration->createTable();

        $BrgsatuanMigration = new \App\Migration\BrgsatuanMigration();
        $BrgsatuanMigration->createTable();

        $KonversiMigration = new \App\Migration\KonversiMigration();
        $KonversiMigration->createTable();

        $GudopnameMigration = new \App\Migration\GudopnameMigration();
        $GudopnameMigration->createTable();

        $GudopnamedetailMigration = new \App\Migration\GudopnamedetailMigration();
        $GudopnamedetailMigration->createTable();

        $GudhilangMigration = new \App\Migration\GudhilangMigration();
        $GudhilangMigration->createTable();

        $GudhilangdetailMigration = new \App\Migration\GudhilangdetailMigration();
        $GudhilangdetailMigration->createTable();

        $GudpindahMigration = new \App\Migration\GudpindahMigration();
        $GudpindahMigration->createTable();

        $GudpindahdetailMigration = new \App\Migration\GudpindahdetailMigration();
        $GudpindahdetailMigration->createTable();

        $GudpakaiMigration = new \App\Migration\GudpakaiMigration();
        $GudpakaiMigration->createTable();

        $GudpakaidetailMigration = new \App\Migration\GudpakaidetailMigration();
        $GudpakaidetailMigration->createTable();

        $GudrevisiMigration = new \App\Migration\GudrevisiMigration();
        $GudrevisiMigration->createTable();

        $GudrevisidetailMigration = new \App\Migration\GudrevisidetailMigration();
        $GudrevisidetailMigration->createTable();

        $Brgkategori = new \App\Migration\BrgkategoriMigration();
        $Brgkategori->createTable();

        $GudmintaMigration = new \App\Migration\GudmintaMigration();
        $GudmintaMigration->createTable();

        $GudmintadetailMigration = new \App\Migration\GudmintadetailMigration();
        $GudmintadetailMigration->createTable();        
   }
}