<?php

namespace Usyninis\Wucms;

use Illuminate\Database\Eloquent\Model as Eloquent;



class Prop extends Eloquent {

	//protected $primaryKey = 'code';
	
	public $timestamps = false;

	public static function rules($uid=null)
	{
		return array(
			'name'		=> 'required|min:3',
			'code'		=> 'required|min:3|unique:props,code,'.$uid,
			'type'		=> 'required'
		);
	}
	
	public function types()
	{
		return $this->belongsToMany('Type');
	}
	
	
	public static function typesList()
	{
		return array(
			'int'		=> 'Число',
			'string'	=> 'Строка',
			'text'		=> 'Текст',
			//'date'		=> 'Дата',
			'album'		=> 'Альбом',
			'unit'		=> 'Элемент',
			'list'		=> 'Элемент из списка',
			'prop'		=> 'Свойство',
			'checkbox'	=> 'Переключатель'
		);
	}
	
	
	
	public function getValueKeyAttribute()
	{
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
	
	
	/* public static function getAll()
	{
		$props = Prop::all();
		if($props)
			foreach($props as  $key => $prop)
			{
				$props[$key] = $prop->value;
			}
		return $props;
	} */
	
	
}
