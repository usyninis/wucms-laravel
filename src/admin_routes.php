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


Route::get('admin/login', array(
	'as'		=> 'admin.login.form',
	'before'	=> 'admin.guest',
	'uses'		=> 'Usyninis\Wucms\AuthController@loginForm'
));

Route::post('admin/login',[
	'as'		=> 'admin.login',
	'before'	=> 'admin.guest',
	'uses'		=> 'Usyninis\Wucms\AuthController@login'
]);

Route::get('admin/logout', array(
	'as'		=> 'admin.logout',
	'uses'		=> 'Usyninis\Wucms\AuthController@logout'
));

Route::group(
	array(
		'prefix' => 'admin',
		'before' => 'admin.auth',
		'namespace'	=> 'Usyninis\Wucms'
	), 
	function() 
	{
		
	 	Route::get('/', 'UnitsController@index');
	 	Route::get('templates', 'UnitsController@templates');
		Route::get('types', 'UnitsController@types');
		Route::get('settings', 'SettingsController@index');
		Route::post('albums/update-images/{id}', 'AlbumsController@updateImages');
		Route::resource('albums', 'AlbumsController');
		Route::resource('images', 'ImagesController');
		Route::resource('units', 'UnitsController');
		Route::resource('groups', 'GroupsController');
		Route::resource('props', 'PropsController');
		Route::resource('users', 'UsersController');	 
		Route::controller('ajax','AjaxController');
	}
);
