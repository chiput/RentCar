<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class UserPermissionMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('user_permissions'))
        {
            //Capsule::schema()->dropIfExists('user_permissions');
            Capsule::schema()->create('user_permissions', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('user_id');
                $table->integer('resource_action_id');
                $table->timestamps();
            });

           $user_permissions = [];
           for($i=5;$i<=468;$i++){
            $user_permissions[]=array('user_id' => '1','resource_action_id' => $i,'created_at' => '2017-03-09 15:07:29','updated_at' => '2017-03-09 15:07:29');
           }
                
            Capsule::table('user_permissions')->insert($user_permissions);
        }
    }
}
