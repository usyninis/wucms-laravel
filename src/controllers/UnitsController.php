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

class UnitsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */


	public function __construct()
    {
    	if(Input::get('sort') && in_array(Input::get('sort'),['sort','public_date'])) 
		Session::put('sort',Input::get('sort'));
		
		
		
    	$sort = Session::get('sort','sort');
		View::share('sort',$sort);
    	View::share('map',Unit::map());
    	View::share('types',Type::lists('name','id'));
    }

	public function index()
	{
		//if($lastUnitId = Session::get('ui.lastUnitId')) return Redirect::route('admin.units.show',[$lastUnitId]);
		
		
		
		$units = Unit::whereParentId(0)->orderBy(Session::get('sort','sort'),'asc')->get();
		
		return View::make('wucms::units.map',compact('units'));
			
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		/*$unit = new Unit;
		
		$unit->type_id = Type::defaultType();
		$unit->parent_id = Input::get('parent_id');	
		//$unit->sort = Input::get('sort');	


		return View::make('admin.units.map')
			->with('unit',$unit);*/
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make(Input::all(),Unit::rules());
		
		$json = [];
		
		if ($validator->fails()) 
		{
			$json['status'] = 'error';
			$json['message'] = $validator->messages()->first();
			return Response::json($json);
		}
		
		$unit = new Unit;
		$unit->name = Input::get('name');
		$unit->code = URLify::filter(Input::get('name'));
		$unit->parent_id = Input::get('parent_id');
		$unit->type_id = Input::get('type_id');
		$unit->level = Input::get('level');			
		$unit->sort = Input::get('sort');			
		$unit->active = 1;			
		$unit->save();
			
			
		$json['status'] = 'ok';
			$json['message'] = 'Страница добавлена';
			$json['reload'] = '/admin/units/'.$unit->id.'?parent_id='.$unit->parent_id;
		return Response::json($json);
			
		//return Redirect::to('admin/units/'.$unit->id);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

		$unit = Unit::find($id);
		if(Input::get('preview')) return Redirect::to($unit->url);
		$parent_id = Input::get('parent_id') ?: $unit->id; 
		$parent_unit = $parent_id=='home' ? false : Unit::find($parent_id);
		$units = Unit::whereParentId($parent_id)->orderBy(Session::get('sort','sort'),'asc')->get();
		Session::put('lastUnitId',$id);
		//dd($unit);
		//print_array($unit->parents);
		//print_array(Unit::lists('name','id'));
		return View::make('wucms::units.map',compact('unit','units','parent_unit'));
			
			
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
		$this->beforeFilter('csrf');
		
		$json = array();
		$unit = Unit::find($id);
		
		$validator = Validator::make(Input::all(),Unit::rules($id));
		
		if ($validator->fails()) 
		{
			$json['status'] = 'error';
			$json['message'] = $validator->messages()->first();
			return Response::json($json);
		}
		$unit->name = Input::get('name');
		$unit->code = Input::get('code');
		if(Unit::whereCode($unit->code)->where('id','!=',$unit->id)->first()) $unit->code = $unit->id.'-'.$unit->code;
		//$unit->parent_id = Input::get('parent_id');	

		if($images = Input::get('images'))
		{
			foreach($images as $key => $image_id)
			{
				if($key==0) $unit->image_id = $image_id;
				$images[$key] = ['image_id'=>$image_id,'sort'=>$key];
			}
						
			$unit->images()->sync($images);
		}
		else
		{
			$unit->image_id = 0;
		}

		
		$unit->groups()->sync((array)Input::get('groups'));
		
		

		
		$unit->template_id = Input::get('template_id');
		$unit->type_id = Input::get('type_id');
		$unit->children_type_id = Input::get('children_type_id');
		$unit->short_content = Input::get('short_content');
		$unit->content = Input::get('content');
		$unit->public_date = date('Y-m-d',strtotime(Input::get('public_date')));
		$unit->title = Input::get('title');
		$unit->active = Input::get('active');
		$unit->main = Input::get('main');
		$unit->meta_title = Input::get('meta_title');
		$unit->meta_keywords = Input::get('meta_keywords');
		$unit->meta_description = Input::get('meta_description');
		$unit->save();
		
		
		$unit->recount();
		
		
		UnitProp::where('unit_id','=',$unit->id)->delete();

		
		
			if($props = Input::get('props'))
			{
				
				foreach($props as $prop_id => $values)
				{
					foreach($values as $value)
					{
						if(!$value) continue;
						$prop = new UnitProp();
						$prop->prop_id = $prop_id;
						$prop->value_int = $value;
						$prop->value_string = $value;
						$prop->value_text = $value;
						/* $prop->value = $prop_post['value'];
						$prop->description = $prop_post['description']; */
						$unit->props()->save($prop);
					}
					
				}						
				
			}
		
		
		
		
		//foreach()
		//$unit->images()->attach(1);
		
		$json['status'] = 'ok';
		$json['message'] = 'save ok';
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
		$unit = Unit::find($id);
		
		//$unit->type()->detach();
		$unit->delete();
		return Redirect::to('admin/units/'.$parent_id);
	}

	public function saveMap()
	{
		if($units = Input::get('units'))
		{
			$parent_id = Input::get('unit_id');
			$level = Input::get('level');
			foreach($units as $sort => $unit_id)
				Unit::where('id','=',$unit_id)->update(array(
					'parent_id'	=>$parent_id,
					'level'		=> $level,
					'sort'		=>$sort					
				));
		}
		return Response::json(['status'=>'ok','success'=>true,'message'=>'Сохранено']);
	}

	public function templates()
	{
		$unit = new Unit;
		$unit->id = 0;
		return View::make('wucms::units.templates')
			
			->with('unit',$unit);
	}

	public function types()
	{
		$unit = new Unit;
		$unit->id = 0;
		return View::make('wucms::units.types')
			
			->with('unit',$unit);
	}



}
