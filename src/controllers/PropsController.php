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

class PropsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function index()
	{
        $this->beforeFilter('admin.auth');
        $this->beforeFilter('admin.role:admin');
		
		
		return View::make('wucms::props.list')
			->with('props',Prop::all());
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make(Input::all(),Prop::rules());
		
		if ($validator->fails()) 
		{
			$json['status'] = 'error';
			$json['message'] = $validator->messages()->first();
			return Response::json($json);
		}
		$prop = new Prop;
		
		$prop->code = Input::get('code');
		$prop->name = Input::get('name');
		$prop->description = Input::get('description');
		$prop->type = Input::get('type');
		$prop->value = Input::get('value');
		$prop->multiple = Input::has('multiple');
		$prop->required = Input::has('required');
		$prop->save();

			if($types = Input::get('types'))
			{
				$checked_types = [];
				foreach($types as $type_id => $checked)
					if($checked) $checked_types[] = $type_id;
					
				$prop->types()->sync($checked_types);			
			}
			else
			{
				$prop->types()->detach();
			}
			
		$json = ['status'=>'ok','message'=>'Сохранено'];
			
		return Response::json($json);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{			
		return View::make('wucms::props.list')
			->with('props',Prop::all())
			->with('aprop',Prop::find($id));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{	
		$validator = Validator::make(Input::all(),Prop::rules($id));
		
		if ($validator->fails()) 
		{
			$json['status'] = 'error';
			$json['message'] = $validator->messages()->first();
			return Response::json($json);
		}
		$prop = Prop::find($id);
		$prop->code = Input::get('code');
		$prop->name = Input::get('name');
		$prop->description = Input::get('description');
		$prop->type = Input::get('type');
		$prop->value = Input::get('value');
		$prop->multiple = Input::has('multiple');
		$prop->required = Input::has('required');
		$prop->save();

			if($types = Input::get('types'))
			{
				$checked_types = [];
				foreach($types as $type_id => $checked)
					if($checked) $checked_types[] = $type_id;
					
				$prop->types()->sync($checked_types);			
			}
			else
			{
				$prop->types()->detach();
			}
			
		$json = ['status'=>'ok','message'=>'Сохранено'];
			
		return Response::json($json);		
		
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		
	}


}
