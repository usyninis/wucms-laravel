<?php
	
namespace Usyninis\Wucms;

use Illuminate\Database\Eloquent\Model as Eloquent;
	
class Type extends Eloquent
{

	public static $unguarded = true;
	
	public $timestamps = false;
	
	public function props()
	{
		return $this->belongsToMany('Usyninis\Wucms\Prop','prop_type');
	}
	
	public function template()
	{
		return $this->hasOne('Usyninis\Wucms\Template','id');
	}
	
	public static function rules($id=0)
	{
		return array(			
			'name'	=> 'required',
			'code'	=> 'required|unique:types,code,'.$id,
			'template_id'	=> 'required'
		);
	}
	
	public static function defaultType()
	{
		if($type = Type::where('default','=',1)->first()) return $type->id;
		return false;
	}

}