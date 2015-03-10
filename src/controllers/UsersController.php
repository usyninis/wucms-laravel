<?php

namespace Usyninis\Wucms;

use Illuminate\Routing\Controller;

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
		$user->email = Input::get('email');
		$user->save();
		
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
		if($roles = Input::get('roles'))
		{		
			$user->roles()->sync($roles);
		}
		else
		{
			$user->roles()->detach();
		}
		
		
		$user->save();
		

		
		return Response::json($json);	
	}

	

	



}