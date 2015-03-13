<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCore extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{		
		
		//if (!Schema::hasTable('units'))
      	Schema::create('units',function($t)
		{
			$t->increments('id');
			$t->integer('type_id')->default(0);
			$t->integer('children_type_id')->default(0);
			$t->integer('created_by')->default(0);
			$t->integer('updated_by')->default(0);
			$t->tinyInteger('main')->default(0);
			$t->string('code',255);
			$t->tinyInteger('level')->default(1);
			$t->integer('sort')->default(1);
			$t->integer('parent_id')->default(0);
			$t->string('url',255);
			$t->string('name',255);
			$t->string('title',255);
			$t->integer('image_id')->default(0);
			$t->string('meta_title',255);
			$t->string('meta_keywords',255);
			$t->string('meta_description',255);
			$t->dateTime('public_date');
			$t->string('template',255);
			$t->text('short_content');
          	$t->longText('content');
			$t->integer('count')->default(0);
			$t->tinyInteger('active')->default(0);
			$t->timestamps();
			$t->softDeletes();
		});	
    
		
		Schema::create('units_childrens',function($t)
		{
			$t->integer('unit_id');
			$t->integer('children_id');
			$t->tinyInteger('level')->default(1);
		});
    
		
		Schema::create('types',function($t)
		{
			$t->increments('id');			
			$t->string('code',255);			
			$t->string('name',255);
			$t->integer('template_id')->default(0);
			$t->tinyInteger('default')->default(0);			
		});
		
		
		Schema::create('groups',function($t)
		{
			$t->increments('id');	
			$t->string('code',255);		
			$t->string('name',255);
		});
	
		
		Schema::create('group_unit',function($t)
		{
			$t->integer('group_id');	
			$t->integer('unit_id');	
            $t->integer('sort')->default(1);
		});
	
		
		Schema::create('settings',function($t)
		{
			$t->increments('id');
			$t->string('code',255);	
			$t->string('name',255);	
			$t->string('description',255);	
			$t->string('type',255);	
			$t->integer('value_int');	
			$t->string('value_string',255);	
			$t->text('value_text');	
            $t->integer('sort')->default(1);	
			$t->unique('code');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('units');
		Schema::dropIfExists('units_childrens');
     	Schema::dropIfExists('groups');
     	Schema::dropIfExists('group_unit');
        Schema::dropIfExists('types');
        Schema::dropIfExists('settings');
	}

}
