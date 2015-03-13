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
		Schema::create('users',function($t)
		{
			$t->increments('id');
			$t->string('email', 64);
			$t->string('password', 64);
			$t->string('name', 255);			
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
