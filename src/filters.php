<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
		

	
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/


Route::filter('admin.guest', function()
{
	if ( Auth::check())
		return Redirect::route('index');
});

Route::filter('admin.auth', function()
{
	
	if ( ! Auth::check())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::route('admin.login.form');
		}
	}
});

/* Route::filter('admin.role', function($route, $request, $value)
{
	if ( ! User::isRole($value))
	{
		if (Request::ajax())
		{
			return Response::make('No set role '.$value, 401);
		}
		else
		{
			return Redirect::route('index'); 
		}
		
	}
}) */;



Route::filter('develop', function()
{	
	
	if( ! Config::get('wucms::app_enable'))
	{
		if( ! Session::get('test') && ! Input::get('test')) 
		{	
			$view = 'template::errors.develop';
			
			if( ! View::exists($view)) $view = 'wucms::errors.develop';
			
			return Response::view($view, [], 503);
		}
		Session::put('test','Y');
	}
});



/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('admin.csrf', function()
{	
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
