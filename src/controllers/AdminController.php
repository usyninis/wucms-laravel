<?php

class AdminController extends BaseController {

	public function __construct()
    {
        $this->beforeFilter('admin.auth');
        //$this->beforeFilter('admin');
       // $this->beforeFilter('csrf');
	   
    }

/* 	public function loginForm()
	{
		$back_url = Request::url();
		
		return View::make('admin.login')
			->with('back_url',$back_url);
		
	} */

	public function login()
	{
		
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

	public function changePassword()
	{
		$cuser = Auth::user();
		$rules = array(
			'old_password' => 'required|alphaNum|between:6,16',
			'new_password' => 'required|alphaNum|between:6,16|confirmed'
		);
		if($validator->passes())
		{

			$user = User::findOrFail(Auth::user()->id);
			$user->password = Input::get('new_password');
			$user->save();
			$json = ['status'=>'ok','message'=>'ok'];
		}
		else
		{
			$json = ['status'=>'error','message'=>'ok'];
		}
		return Response::json($json);
		/* $rules = [
			
			'email'	=> 'password,'.$id,
		];
		if(Input::get('new_password')) $rules['new_password'] = 'required|min:5';
		
		$validator = Validator::make(Input::all(),$rules); */
	}
	

}
