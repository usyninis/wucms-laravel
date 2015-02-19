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

class SettingsController extends Controller 
{

	public function index()
	{
		
		return View::make('wucms::settings.list');
	}

	public function show($id)
	{
		
	}

	public function create()
	{
		
	}

	public function store()
	{
		
	}
	
	public function update($id)
	{
		
	}


}