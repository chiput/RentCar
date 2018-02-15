<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class UserMigration
{
    public function createTable ($callerContext)
    {
        if(!Capsule::schema()->hasTable('users'))
        {
            Capsule::schema()->create('users', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('code');
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->timestamps();
            });

            Capsule::table('users')->insert([
               'code'      => 'admin',
               'name'      => 'admin',
               'email'     => 'kulkul.id@gmail.com',
               'password'  => $callerContext->encrypter->encrypt('admin'),
           ]);
        }
    }
}
