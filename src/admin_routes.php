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





//print_array(Setting::all());

Route::get('admin', array(
	'before'	=> 'admin.auth',
	function(){
		return Redirect::route('admin.units.index');
	}
));
Route::get('admin/login', array(
	'as'		=> 'admin.login.form',
	'before'	=> 'admin.guest',
	'uses'		=> 'Usyninis\Wucms\UsersController@loginForm'
));

Route::post('admin/login',[
	'as'		=> 'admin.login',
	'before'	=> 'admin.guest',
	'uses'		=> 'Usyninis\Wucms\UsersController@login'
]);

Route::get('admin/logout', array(
	'as'		=> 'admin.logout',
	'uses'		=> 'Usyninis\Wucms\UsersController@logout'
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
		Route::post('albums/update-images/{id}', 'AlbumsController@updateImages');
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

