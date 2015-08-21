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

class UsersController extends Controller 
{

	public function index()
	{
        $this->beforeFilter('admin.auth');
        $this->beforeFilter('admin.role:admin');
		
		
		
		return View::make('wucms::users.list')
			
			->with('users',User::all());
	}

	public function show($id)
	{
		$cuser = User::find($id);
		
		return View::make('wucms::users.list')
			
			->with('users',User::all())
			->with('cuser',$cuser);
	}

	public function create()
	{
		$cuser = new User;
		
		
		return View::make('wucms::users.list')
			
			->with('users',User::all())
			->with('cuser',$cuser);
	}



	public function store()
	{
		$this->beforeFilter('auth');
		$this->beforeFilter('admin');
		$rules = [			
			'email'	=> 'required|email|unique:users,email'
		];
		$validator = Validator::make(Input::all(),$rules);
				
		if ($validator->fails()) 
		{
			$json['status'] = 'error';
			$json['message'] = $validator->messages()->first();
			return Response::json($json);
		}
		$user = new User;
		$user->first_name = Input::get('first_name');
		$user->last_name = Input::get('last_name');
		$user->email = Input::get('email');
		if(Input::get('new_password')) $user->password = Input::get('new_password');
		$user->save();
		
		if($roles = Input::get('roles'))
		{		
			$user->roles()->sync($roles);
		}
		
		return Response::json(['status'=>'ok','message'=>'User create success','reload'=>url('admin/users/'.$user->id)]);
	}
	
	public function update($id)
	{
		$this->beforeFilter('auth');
		$this->beforeFilter('admin');
		
		$rules = [
			
			'email'	=> 'required|email|unique:users,email,'.$id,
		];
		if(Input::get('new_password')) $rules['new_password'] = 'required|min:5';
		
		$validator = Validator::make(Input::all(),$rules);
				
		if ($validator->fails()) 
		{
			$json['status'] = 'error';
			$json['message'] = $validator->messages()->first();
			return Response::json($json);
		}
		
		$json = ['status'=>'ok','message'=>'User update success'];
		
		$user = User::find($id);
		$user->first_name = Input::get('first_name');
		$user->last_name = Input::get('last_name');
		$user->email = Input::get('email');
		if(Input::get('new_password')) $user->password = Input::get('new_password');
		$user->save();
		
		
		if($roles = Input::get('roles'))
		{		
			$user->roles()->sync($roles);
		}
		else
		{
			$user->roles()->detach();
		}
		
		
		
		

		
		return Response::json($json);	
	}

	public function changePassword()
	{
		if( ! Auth::check()) return Response::make('Unauthorized', 401);
		
		//$cuser = Auth::user();
		
		
		$validator = Validator::make(Input::all(),array(
			'old_password' => 'required|alphaNum|between:6,16',
			'new_password' => 'required|alphaNum|between:6,16|confirmed'
		));
		
		if($validator->passes())
		{

			$cuser = Auth::user();
			
			if (Hash::check(Input::get('old_password'), $cuser->password)) 
			{
				$cuser->password = Input::get('new_password');
				$cuser->save();
				
				$json['status'] = 'ok';
				$json['message'] = 'Пароль успешно изменен!';
			}
			else
			{
				$json['status'] = 'error';
				$json['message'] ='Старый пароль введен неверно';	
			}
			
		}
		else
		{
			$json['status'] = 'error';
			$json['message'] = $validator->messages()->first();
		}
		return Response::json($json);
	}
	
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