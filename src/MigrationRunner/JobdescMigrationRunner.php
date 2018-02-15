<?php
namespace App\MigrationRunner;

class JobdescMigrationRunner
{
   public function run($callerContext)
   {
        $boardMigration = new \App\Migration\BoardMigration();
        $boardMigration->createTable();

        $listMigration = new \App\Migration\ListMigration();
        $listMigration->createTable();

        $cardMigration = new \App\Migration\CardMigration();
        $cardMigration->createTable();

        $commentMigration = new \App\Migration\CommentMigration();
        $commentMigration->createTable();

        $checklistMigration = new \App\Migration\ChecklistMigration();
        $checklistMigration->createTable();

        $childlistMigration = new \App\Migration\ChildlistMigration();
        $childlistMigration->createTable();

        $activityMigration = new \App\Migration\ActivityMigration();
        $activityMigration->createTable();

    }
}