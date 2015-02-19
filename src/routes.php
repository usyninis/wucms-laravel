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




View::addNamespace('template', app_path().'/views/'.Config::get('wucms::app_code'));

Route::pattern('id', '[0-9]+');




//print_array(Setting::all());

Route::group(
	array(
		'prefix' => 'admin',
		'before' => 'auth|admin'
	), 
	function() 
	{
		
	 	Route::get('templates', 'Usyninis\Wucms\UnitsController@templates');
		Route::get('types', 'Usyninis\Wucms\UnitsController@types');
		Route::get('settings', 'Usyninis\Wucms\SettingsController@index');
		//Route::get('units/types', 'UnitsController@types');
		Route::resource('albums', 'Usyninis\Wucms\AlbumsController');
		Route::resource('images', 'Usyninis\Wucms\ImagesController');
		Route::resource('units', 'Usyninis\Wucms\UnitsController');
		Route::resource('groups', 'Usyninis\Wucms\GroupsController');
		Route::resource('props', 'Usyninis\Wucms\PropsController');
		Route::resource('users', 'Usyninis\Wucms\UsersController');
	 
		Route::controller('ajax','Usyninis\Wucms\AjaxController');
		
		
		
		
		//Route::post('map','UnitsController@saveMap');
	}
);



//return Response::error( '503' );


Route::group(
	array(
		'prefix' => 'users'
	), 
	function()
	{
		Route::get('/login', [
			'as'		=> 'admin.login.form',
			'before'	=> 'guest',
			function(){
				return View::make('wucms::login');
			}
		]);

		Route::post('/login',[
			'before'	=> 'guest',
			function(){
				$user = array(
		            'email' => Input::get('email'),
		            'password' => Input::get('password')
		        );
		        //print_r($user);        die();
		        
		        if (Auth::attempt($user,true)) 
		        {
		            return Redirect::route('admin.units.index');
		                //->with('flash_notice', 'You are successfully logged in.');
		        }
		        
		        // authentication failure! lets go back to the login page
		        return Redirect::route('admin.login.form')
		            ->with('flash_error', 'Your email/password combination was incorrect.')
		            ->withInput();
			}
		]);

	
		
		Route::get('/logout', array(
			'as'		=> 'logout',
			function(){
				if(Auth::check()) Auth::logout();
				return Redirect::back();
			}
		));	
	}
);


Route::get('/', array(
	'as'		=> 'index',
	'before'	=> 'develop',
	'uses'		=> 'Usyninis\Wucms\AppController@unit'
 	/* function()
	{
	
		$list = Usyninis\Wucms\Setting::all();
		
		return Response::json($list);		
		
	}  */
));


Route::get('develop', array(
	'as'		=> 'develop',
	'uses'		=> 'Usyninis\Wucms\AppController@develop'
));

Route::get('{all}', array(
	'as'		=> 'unit',
	'before'	=> 'develop',
	'uses'		=> 'Usyninis\Wucms\AppController@unit'
	// function()
	// {
		// $app = app();
		// $controller = $app->make('Usyninis\Wucms\AppController');
		// $controller->callAction($app, $app['router'], 'unit', $parameters = array());
	// }
))->where('all', '.*');

/* 
 */

 
/* Route::matched(function($route, $request)
{
	die($route->getName());
}); */

