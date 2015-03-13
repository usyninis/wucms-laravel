<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{		
		Schema::create('images',function($t)
		{
			$t->increments('id');
			$t->string('filename',255);
			$t->string('path',255);			
			$t->integer('created_by');		
			$t->integer('album_id')->default(0);
			$t->string('name',255);	
			$t->text('description');	
			$t->integer('sort')->default(1);	
			$t->timestamps();
		});
      
      	Schema::create('albums',function($t)
		{
			$t->increments('id');		
			$t->integer('image_id');		
			$t->integer('created_by');
			$t->string('name',255);	
			$t->text('description');
			$t->integer('count');
		});
      
      	Schema::create('units_images',function($t)
		{
			$t->integer('unit_id');		
			$t->integer('image_id');		
			$t->integer('sort');
		});
	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('images');
        Schema::dropIfExists('albums');
        Schema::dropIfExists('units_images');
	}

}
