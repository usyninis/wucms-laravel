<?php


/* App::missing(function($exception)
{
	//die('App::missing');
	
	return App::make('Usyninis\Wucms\AppController')->unit();
	
	
	//return App::make('Usyninis\Wucms\AppController')->unit();
	$segments = Request::segments();
	$old_code = end($segments);
	if($new_unit = Unit::whereProp('old_code','=',$old_code)->first())
		//print_array($new_unit);
		return Redirect::to($new_unit->url,301);
		
		//return Response::view('template::error404', array(), 404);
		
			
	
			
		
		
	//return ($old_code);
    return Response::view('template::errors.error404', array(), 404);
	
});
 */

App::error(function(Illuminate\Database\Eloquent\ModelNotFoundException $e)
{
	
	
	$segments = Request::segments();
	$old_code = end($segments);
	if($new_unit = Unit::whereProp('old_code','=',$old_code)->first())
		//print_array($new_unit);
		return Redirect::to($new_unit->url,301);
		
		//return Response::view('template::error404', array(), 404);
		
			
	
			
		
		
	//return ($old_code);
    return Response::view('template::errors.error404', array(), 404);

}); 
