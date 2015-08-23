<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		// create tables
		Schema::create('users',function($t)
		{
			$t->increments('id');
			$t->string('email', 64);
			$t->string('password', 64);
			$t->string('first_name', 255);			
			$t->string('last_name', 255);			
			$t->tinyInteger('confirmed')->default(1);			
			$t->string('confirmation_code');			
			$t->rememberToken();
			$t->timestamps();
		});

		Schema::create('roles',function ($t) {
            $t->increments('id');
            $t->string('role');
            $t->string('name');
            $t->string('description');
        });

		Schema::create('role_user',function ($t) {
            $t->integer('user_id');
            $t->integer('role_id');
        });

		// add data
      	$roles = [
            ['role' => 'superadmin',	'name'=> 'Суперадминистратор'],
            ['role' => 'admin',			'name'=> 'Администратор'],
            ['role' => 'manager',		'name'=> 'Менеджер'],
            ['role' => 'user',			'name'=> 'Пользователь']
        ];

      	$users = [
            ['email' => 'admin@admin.ru', 'password' => Hash::make('admin@admin.ru')]
        ];
      
		$role_user = [
            ['user_id' => 1, 'role_id' => 1],
            ['user_id' => 1, 'role_id' => 2]
        ];
        
      
        DB::table('roles')->insert($roles);
      	DB::table('users')->insert($users);
        DB::table('role_user')->insert($role_user);

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
		Schema::dropIfExists('roles');
		Schema::dropIfExists('role_user');
	}

}
