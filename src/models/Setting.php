<?php

namespace Usyninis\Wucms;



use Illuminate\Database\Eloquent\Model as Eloquent;

use Illuminate\Support\Facades\Cache;
	
class Setting extends Eloquent
{
	public $timestamps = false;
	
	/*	
		********************* rules *********************
	*/
	
	public static function rules($uid=null)
	{
		return array(
			'code'	=> 'required',
			'type'	=> 'required',
			'name'	=> 'required'
		);
	}
	
	/*
		********************* Attributes *********************
	*/
	
	public function getValueKeyAttribute()
	{
		if(!$this->type) return 'value_int';
		switch($this->type)
		{
			case 'checkbox';
			case 'prop';
			case 'album';
			case 'list';
			case 'unit':
				return 'value_int';
			default:
				return 'value_'.$this->type;
		}
		
	}
	
	public function getValueAttribute()
	{
		$value_key = $this->value_key;
		return array_get($this->attributes,$value_key);
		
	}
	
	public function getNameAttribute()
	{
		if( ! empty($this->attributes['name'])) return $this->attributes['name'];
		return array_get($this->attributes,'code');
		
	}
	
	public function setCodeAttribute($value)
	{
		
		$this->attributes['code'] = str_replace(' ','_',$value);
		
	}
	

	/*
		*************** other *********************
	*/
	public static function value($code)
	{
		$settings = Cache::remember('settings', 60, function () {
			return Setting::all();
		});
		if( ! $settings) return false;
		foreach($settings as $setting)
			if($setting->code==$code)		
				return $setting->value;
		return false;
		
	}
	
	public static function typesList()
	{
		return array(
			'int'		=> 'Число',
			'string'	=> 'Строка',
			'text'		=> 'Текст',
			//'album'		=> 'Альбом',
			//'unit'		=> 'Элемент',
			//'list'		=> 'Элемент из списка',
			//'prop'		=> 'Свойство',
			'checkbox'	=> 'Переключатель'
		);
	}
	
	/* public static function text($code)
	{
		
		if( ! $setting = Setting::where('code','=',$code)->first()) return false;
		return $setting->text;
		
	} */

}