<?php
namespace App\MigrationRunner;

class AccountingMigrationRunner
{
   public function run($callerContext)
   {
     
        $AccaktivagroupMigration = new \App\Migration\AccaktivagroupMigration();
        $AccaktivagroupMigration->createTable();

        $accaktivajurnaldetails = new \App\Migration\AccaktivajurnaldetailsMigration();
        $accaktivajurnaldetails->createTable();

        $accaktivajurnals = new \App\Migration\AccaktivajurnalsMigration();
        $accaktivajurnals->createTable();

        $accaktivas = new \App\Migration\AccaktivasMigration();
        $accaktivas->createTable();

        $Accgroups = new \App\Migration\AccgroupsMigration();
        $Accgroups->createTable();

        $accheaders = new \App\Migration\AccheadersMigration();
        $accheaders->createTable();

        $accjurnaldetails = new \App\Migration\AccjurnaldetailsMigration();
        $accjurnaldetails->createTable();

        $accjurnals = new \App\Migration\AccjurnalsMigration();
        $accjurnals->createTable();

        $acckas = new \App\Migration\AcckasMigration();
        $acckas->createTable();

        $acckasdetails = new \App\Migration\AcckasdetailsMigration();
        $acckasdetails->createTable();

        $acckasdetails = new \App\Migration\AcckastypesMigration();
        $acckasdetails->createTable();

        $accneracadetails = new \App\Migration\AccneracadetailsMigration();
        $accneracadetails->createTable();

        $accneracas = new \App\Migration\AccneracasMigration();
        $accneracas->createTable();

        $accounts = new \App\Migration\AccountsMigration();
        $accounts->createTable();

        $banks = new \App\Migration\BanksMigration();
        $banks->createTable();

   }
}