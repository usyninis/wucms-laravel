<?php

namespace Usyninis\Wucms;

use Illuminate\Database\Eloquent\Model as Eloquent;
	
class Group extends Eloquent
{

	//protected $primaryKey = 'code';

	
	
	public $timestamps = false;
	
	protected $fillable = array('name', 'code');
	
	//protected $guarded = array('id');
	
	public static function rules()
	{
		return array(
			'name'	=> 'required|min:3',
			'code'	=> 'required|min:3'		  
		);
	}
	
	public function units()
	{
		return $this->belongsToMany('Usyninis\Wucms\Unit')->orderBy('group_unit.sort','asc');
	}
	

	
}