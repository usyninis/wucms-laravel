<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplates extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('units_templates',function($t)
		{			
			$t->increments('id');
			$t->string('code',255)->unique();
			$t->string('name',255);			
			$t->string('description',255);			
			$t->integer('sort')->default(1);			
		});
		
		DB::statement("ALTER TABLE `units` CHANGE `template` `template_id` INT(11) NOT NULL DEFAULT '0'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('units_templates');
		DB::statement("ALTER TABLE `units` CHANGE `template_id` `template` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL");
	}

}
