<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('/',[
	'as'		=> 'index',
	'before'	=> 'develop',
	'uses'		=> 'Usyninis\Wucms\AppController@index'	
]);



Route::get('{code}',[
	'as'		=> 'unit',
	'before'	=> 'develop',
	'uses'		=> 'Usyninis\Wucms\AppController@unit'	
])->where('code','[a-z0-9_-]+');


Route::get('{any}/{code}',[
	'as'		=> 'unit',
	'before'	=> 'develop',
	'uses'		=> 'Usyninis\Wucms\AppController@unit'	
])->where('any','.*')->where('code','[a-z0-9_-]+'); 