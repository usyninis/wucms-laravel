<?php

namespace Usyninis\Wucms;

use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
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

class AjaxController extends Controller {

	public function __construct()
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('admin');
       // $this->beforeFilter('csrf');
	   
    }


	
	public function anyMap($action)
	{
		$json = ['status'=>'error'];
		switch($action)
		{
			case 'save':
				if($units = Input::get('units'))
				{
					
					
					foreach($units as $sort => $unit_id)
					
						if($eunit = Unit::find($unit_id))
						{
							//$eunit->parent_id = Input::get('parent_id');
							$eunit->sort = $sort;
							$eunit->save();
						} 
						/* Unit::where('id','=',$unit_id)->update(array(
							'parent_id'	=> Input::get('parent_id'),
							'level'		=> Input::get('level'),
							'sort'		=> $sort					
						)); */ 
					$json['status'] = 'ok';
					$json['message'] = 'Сохранено';	
				}
				break;
			case 'setmain':
				$unit = Unit::find(Input::get('id'));
				$unit->main = 1;
				$unit->save();
				$json['status'] = 'ok';
					$json['message'] = 'Сохранено';	
				break;
			default:
				$json['message'] = 'Неизвестное действие';
				break;
		}
		return Response::json($json);
	}
	
	public function getImages($action)
	{
		$json = ['status'=>'error'];
		switch($action)
		{
			case 'delete':
				if($image = GImage::find(Input::get('id')))
				{
					
					if (File::exists(public_path().$image->src)) File::delete(public_path().$image->src);
					$json['status'] = 'ok';
					$json['id'] = $image->id;
					$json['message'] = 'Изображение удалено';
					$album_id = $image->album_id;					
					$image->delete();
					
					if($album_id) Album::find($album_id)->save();					
				}
				break;
			default:
				$json['message'] = 'Неизвестное действие';
				break;
		}
		return Response::json($json);
	}
	
	public function anyTemplates($action)
	{
		$json = ['status'=>'error'];
		switch($action)
		{
			case 'delete':
				if($template = Template::find(Input::get('id')))
				{
					Unit::whereTemplateId($template->id)->update(['template_id'=>0]);
					Type::whereTemplateId($template->id)->update(['template_id'=>0]);
					$template->delete();
				}
					
				$json = ['status'=>'ok','message'=>'Удалено'];
				break;
			case 'save':
				$validator = Validator::make(Input::all(),Template::rules());
				
				if ($validator->fails()) 
				{
					$json['status'] = 'error';
					$json['message'] = $validator->messages()->first();
					return Response::json($json);
				}
				
				$template = Template::findOrNew(Input::get('id'));				
				$template->code = Input::get('code');
				$template->name = Input::get('name');
				$template->description = Input::get('description');
				$template->save();
				$json = ['status'=>'ok','message'=>'Сохранено'];
					
				break;
			default:
				$json['message'] = 'Неизвестное действие';
				break;
		}
		return Response::json($json);
	}

	public function anySettings($action)
	{
		$json = ['status'=>'error'];
		switch($action)
		{
			case 'delete':
				
				if($setting = Setting::find(Input::get('id')))
					$setting->delete();
				$json = ['status'=>'ok'];
				break;
			case 'save': 
				$validator = Validator::make(Input::all(),Setting::rules());
				
				if ($validator->fails()) 
				{
					$json['status'] = 'error';
					$json['message'] = $validator->messages()->first();
					return Response::json($json);
				} 
				$setting = Setting::findOrNew(Input::get('id'));
				$setting->code = Input::get('code');
				$setting->name = Input::get('name');				
				$setting->type = Input::get('type');
				$setting->save(); 
				$json = ['status'=>'ok','message'=>'Сохранено'];
					
				break;
			case 'saveValue':
				if($setting = Setting::find(Input::get('id')))
				{
					Cache::forget('settings');
					$value_key = $setting->value_key;
					$setting->$value_key = Input::get($value_key);
					$setting->save();
					$json = ['status'=>'ok','message'=>'Настройка сохранена'];
				}
				else
				{
					$json = ['status'=>'error','message'=>'Настройка не найдена'];
				}
					
				break;
			default:
				$json['message'] = 'Неизвестное действие';
				break;
		}
		return Response::json($json);
	}
	
	public function anyTypes($action)
	{
		$json = ['status'=>'error'];
		switch($action)
		{
			case 'delete':
				if($type = Type::find(Input::get('id')))
				{
					if(Unit::whereTypeId($type->id)->first())
					{
						$json = ['status'=>'error','message'=>'Есть страницы данного типа'];
						break;
					}
					$type->props()->detach();
					$type->delete();
				}
				$json = ['status'=>'ok','message'=>'Удалено'];
				break;
			case 'save':
				$validator = Validator::make(Input::all(),Type::rules(Input::get('id')));
				
				if ($validator->fails()) 
				{
					$json['status'] = 'error';
					$json['message'] = $validator->messages()->first();
					return Response::json($json);
				}
				$type = Type::findOrNew(Input::get('id'));	
				$type->code = Input::get('code');
				$type->name = Input::get('name');
				$type->template_id = Input::get('template_id');						
				$type->save();
					if($props = Input::get('props'))
					{
						$type->props()->sync($props, false);
					}
					else
					{
						$type->props()->detach();
					}
				$json = ['status'=>'ok','message'=>'Сохранено'];
					
				break;
			default:
				$json['message'] = 'Неизвестное действие';
				break;
		}
		return Response::json($json);
	}
	
	public function anyUnits($action)
	{
		$json = ['status'=>'error'];
		switch($action)
		{
			case 'move':
				if($unit = Unit::find(Input::get('unit_id')))
				{
					$old_parent_id = $unit->parent_id;
					$new_parent_id = Input::get('parent_id');
					$unit->parent_id = $new_parent_id;
					$unit->save();
					$json = ['status'=>'ok','message'=>'Страница перемещена'];
					if($old_parent = Unit::find($old_parent_id)) $old_parent->recount();
					if($new_parent = Unit::find($new_parent_id)) $new_parent->recount();
				}
				else
				{
					$json = ['status'=>'error','message'=>'Ошибка перемещения'];
				}
				
				
				break;
			case 'delete':
				$unit = Unit::find(Input::get('id'));
				$parent_id = $unit->parent_id;		
				Unit::where('parent_id','=',Input::get('id'))
					->update(array(
						'parent_id' => $parent_id
					));
				//$unit->type()->detach();
				$unit->delete();
				$reload_url = $parent_id ? '/admin/units/'.$parent_id : '/admin/units';
				$json = ['status'=>'ok','message'=>'Страница удалена','reload'=>$reload_url];
				
				break;
			default:
				$json['message'] = 'Неизвестное действие';
				break;
		}
		return Response::json($json);
	}
	
	public function anyUi($code,$value=false)
	{
		$codes = ['uet'];
		if(in_array($code,$codes)) 
		return Session::put('ui.'.$code,$value);
		return Response::json(['status'=>'error']);
	}
	
	public function anyGroups($action)
	{
		$json = ['status'=>'error'];
		switch($action)
		{
			case 'toggle_unit':
				
				/* if($unit = Unit::find(Input::get('unit_id')))
				{
					$json = ['status'=>'ok','message'=>'Страница перемещена'];
				}
				else
				{
					$json = ['status'=>'error','message'=>'Ошибка перемещения'];
				}
				 */
				if($group = Group::find(Input::get('group_id')))
				{
					$unit = Unit::find(Input::get('unit_id'));
					
					//print_r($group->units->lists('id'));
					
					
					
					
					if($group->units->contains($unit->id))
					{
						$group->units()->detach($unit->id);
					}
					else
					{
						$group->units()->save($unit);
						
					}
					 
					
					$json = ['status'=>'ok'];
					
				}
				else
				{
					$json = ['status'=>'error','message'=>'Ошибка'];
				}
				
				break;
			default:
				$json['message'] = 'Неизвестное действие';
				break;
		}
		return Response::json($json);
	}
	
	
	/*public function anyProps($action)
	{
		$json = ['status'=>'error'];
		switch($action)
		{
			case 'new':
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
				$prop->type = Input::get('type');
				$prop->save();
				$json = ['status'=>'ok','message'=>'Сохранено'];
					
				break;
			default:
				$json['message'] = 'Неизвестное действие';
				break;
		}
		return Response::json($json);
	}
	*/
	public function getModal($code)
	{
		return View::make('wucms::modal.'.$code);
	}

}
