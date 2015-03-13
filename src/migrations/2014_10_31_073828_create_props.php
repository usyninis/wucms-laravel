<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProps extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('props',function($t)
		{			
			$t->increments('id');
			$t->string('code',255)->unique();
			$t->string('name',255);			
			$t->string('description',255);			
			$t->string('type',255);			
			$t->integer('value')->default(0);			
			$t->tinyInteger('multiple')->default(0);
			$t->tinyInteger('required')->default(0);
			
		});
		
		Schema::create('prop_type',function($t)
		{			
			$t->integer('type_id');
			$t->integer('prop_id');
			$t->index('type_id');	
			$t->index('prop_id');	
		});
		
		Schema::create('prop_unit',function($t)
		{			
			$t->integer('unit_id');
			$t->integer('prop_id');
			$t->integer('value_int');	
			$t->string('value_string',255);	
			$t->text('value_text');	
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('props');
		Schema::dropIfExists('prop_type');
		Schema::dropIfExists('prop_unit');
	}

}
