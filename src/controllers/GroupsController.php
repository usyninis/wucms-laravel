<?php

namespace Usyninis\Wucms;

use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class GroupsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */


	public function __construct()
    {
    	View::share('groups',Group::all());
    	View::share('map',Unit::map());
    	
    }

	public function index()
	{
		$active_group = false;
		return View::make('wucms::groups.list')->with(compact('active_group'));
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
		
		
		$validator = Validator::make(Input::all(),Group::rules());
		
		if ($validator->fails()) 
		{
			return Response::json(['status'=>'error','message'=>$validator->messages()->first()]);
		}
		$group = Group::findOrNew(Input::get('id'));
		$group->fill(Input::all());	
		$group->save();
		
		
		
		if($units = Input::get('units'))
		{
			foreach($units as $key => $unit_id)
				$units[$key] = [ 'sort' => $key, 'unit_id' => $unit_id ];
			
			$group->units()->sync($units);
		}
		else
		{
			$group->units()->detach($units);
		}		
		
		return Response::json(['status'=>'ok','message'=>'Группа «'.$group->name.'»сохранена']);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$active_group = Group::find($id);		
		return View::make('wucms::groups.list')->with(compact('active_group'));
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
		
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$group = Group::find($id);		
		$group->units()->detach();
		$group->delete();
		return Redirect::route('admin.groups.index');
	}


}
