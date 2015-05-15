<?php

App::before(function($request)
{
	

	
});


App::after(function($request, $response)
{



});


Route::filter('admin.guest', function()
{
	if(Auth::check())
	{		
		if(Request::ajax())
		{
			return Response::make('Forbidden', 403);
		}
		else
		{
			return Redirect::route('index');				
		}
	}

});

Route::filter('admin.role', function($route, $request, $value)
{
	
	if (Request::ajax())
	{
		if( ! Auth::user()->isRole($value))
			return Response::make('Forbidden', 403); 
		
	}
	else
	{
		if( ! Auth::user()->isRole($value))
			return Response::make('Forbidden', 403);
		
	}	

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
			return Redirect::route('admin.login.form')
				->with('back_url',Request::url());				
				
		}
	}
});



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


Route::filter('admin.csrf', function()
{	
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
