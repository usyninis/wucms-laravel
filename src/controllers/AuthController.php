<?php

namespace Usyninis\Wucms;

use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class AuthController extends Controller {


	
	public function loginForm()
	{
		//return Session::get('back_url');
		//$back_url = Session::get('back_url');
		return View::make('wucms::login');
	}
	

	public function login()
	{
		$user = array(
			'email' => Input::get('email'),
			'password' => Input::get('password')
		);
		//print_r($user);        die();
		
		if (Auth::attempt($user,true)) 
		{
			
			$back_url = Input::get('back_url') ?:  route('index');
			
			return Redirect::to($back_url);
				//->with('flash_notice', 'You are successfully logged in.');
		}
		
		// authentication failure! lets go back to the login page
		return Redirect::route('admin.login.form')
			->with('flash_error', 'Your email/password combination was incorrect.')
			->with('back_url', Input::get('back_url'))
			->withInput();
	}
	
	public function logout()
	{
		if(Auth::check()) Auth::logout();
		
		if (Request::ajax())
		{
			
			return Response::json(['status'=>'ok']);
			
		}
		
		return Redirect::back();		
		
	}
	
	

}
