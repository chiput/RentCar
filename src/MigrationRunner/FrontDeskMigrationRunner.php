<?php
namespace App\MigrationRunner;

class FrontDeskMigrationRunner
{
   public function run($callerContext)
   {
        $PhonebookMigration = new \App\Migration\PhonebookMigration();
        $PhonebookMigration->createTable();

        $addchargedetails = new \App\Migration\AddchargedetailsMigration();
        $addchargedetails->createTable();

        $addcharges = new \App\Migration\AddchargesMigration();
        $addcharges->createTable();

        $addchargetypes = new \App\Migration\AddchargetypesMigration();
        $addchargetypes->createTable();

        $agents = new \App\Migration\AgentsMigration();
        $agents->createTable();

        $agentRates = new \App\Migration\AgentratesMigration();
        $agentRates->createTable();

        $check_outs = new \App\Migration\CheckoutsMigration();
        $check_outs->createTable();

        $check_out_details = new \App\Migration\CheckOutDetailsMigration();
        $check_out_details->createTable();

        $creditcards = new \App\Migration\CreditcardsMigration();
        $creditcards->createTable();

        $deposits = new \App\Migration\DepositsMigration();
        $deposits->createTable();

        $reservationdetails = new \App\Migration\ReservationdetailsMigration();
        $reservationdetails->createTable();

        $reservations = new \App\Migration\ReservationsMigration();
        $reservations->createTable();

        $room_changes = new \App\Migration\RoomchangesMigration();
        $room_changes->createTable();

        $room_status = new \App\Migration\RoomstatusMigration();
        $room_status->createTable();

        $GuestMigration = new \App\Migration\GuestMigration();
        $GuestMigration->createTable();
   }
}