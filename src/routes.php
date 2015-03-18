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






Route::pattern('id', '[0-9]+');
Route::pattern('code', '[a-z0-9-]+');
Route::pattern('any', '.*');




//print_array(Setting::all());

Route::get('admin/login', array(
	'as'		=> 'admin.login.form',
	'before'	=> 'admin.guest',
	function()
	{
		return View::make('wucms::login');
	}
));

Route::post('admin/login',[
	//'as'		=> 'admin.login',
	'before'	=> 'admin.guest',
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

Route::get('admin/logout', array(
	'as'		=> 'admin.logout',
	function()
	{
		if(Auth::check()) Auth::logout();
		return Redirect::back();
	}
));

Route::group(
	array(
		//'as'	=> 'admin',
		'prefix' => 'admin',
		'before' => 'admin.auth',
		'namespace'	=> 'Usyninis\Wucms'
	), 
	function() 
	{
		
	 	Route::get('templates', 'UnitsController@templates');
		Route::get('types', 'UnitsController@types');
		Route::get('settings', 'SettingsController@index');
		//Route::get('units/types', 'UnitsController@types');
		Route::resource('albums', 'AlbumsController');
		Route::resource('images', 'ImagesController');
		Route::resource('units', 'UnitsController');
		Route::resource('groups', 'GroupsController');
		Route::resource('props', 'PropsController');
		Route::resource('users', 'UsersController');
	 
		Route::controller('ajax','AjaxController');
		
		
		

		

		

		
		//Route::post('map','UnitsController@saveMap');
	}
);



//return Response::error( '503' );






/* Route::get('develop', array(
	'as'		=> 'develop',
	'uses'		=> 'Usyninis\Wucms\AppController@develop'
)); */



//require app_path()."/routes.php";
/* 
 Route::get('/', array(
	'as'		=> 'index',
	'before'	=> 'develop',
	'uses'		=> 'Usyninis\Wucms\AppController@index'
 	 function()
	{
	
		dd(Route::getRoutes());
		
		$list = Usyninis\Wucms\Setting::all();
		
		return Response::json($list);		
		
	}   
));
*/ 
/* Route::get(Request::path(),[
	'as'		=> 'unit',
	'before'	=> 'develop',
	'uses'		=> 'Usyninis\Wucms\AppController@unit'	
]); */

/* Route::get('{code}', function()
{
	echo 'code - '.Route::input('code').'<br/>';
	echo 'id - '.Route::input('id').'<br/>';
	//echo 'code - '.$code.'<br/>';
	return 'parents';
	
});
Route::get('{any?}/{code}', function()
{
	echo 'code - '.Route::input('code').'<br/>';
	echo 'id - '.Route::input('id').'<br/>';
	//echo 'code - '.$code.'<br/>';
	return 'parents';
	
});
 */
/* Route::get('{code}',[
	//'as'		=> 'index',
	'before'	=> 'develop',
	'uses'		=> 'Usyninis\Wucms\AppController@unit'	
]); */





 
/* Route::get('{code}',[
	'as'		=> 'unit',
	'before'	=> 'develop',
	'uses'		=> 'Usyninis\Wucms\AppController@unit'	
]);



Route::get('{any?}/{code}',[
	'as'		=> 'unit',
	'before'	=> 'develop',
	'uses'		=> 'Usyninis\Wucms\AppController@unit'	
]); */
 
/*
Route::get('/', array(
	'as'		=> 'index',
	//'before'	=> 'develop',
	'uses'		=> 'Usyninis\Wucms\AppController@unit'
 	 function()
	{
	
		dd(Route::getRoutes());
		
		$list = Usyninis\Wucms\Setting::all();
		
		return Response::json($list);		
		
	}  
));

 */


/*  Route::get('dfs', array(
	'as'		=> 'unit',
	'before'	=> 'admin.develop',
	'uses'		=> 'Usyninis\Wucms\AppController@unit'
	// function()
	// {
		// $app = app();
		// $controller = $app->make('Usyninis\Wucms\AppController');
		// $controller->callAction($app, $app['router'], 'unit', $parameters = array());
	// }
)); */
 
/* 
 */

 
/* Route::matched(function($route, $request)
{
	die($route->getName());
}); */

