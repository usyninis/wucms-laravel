<?php

namespace Usyninis\Wucms;

use Illuminate\Database\Eloquent\Model as Eloquent;
	
class Template extends Eloquent
{
	public $timestamps = false;
	
	protected $table = 'units_templates';
	
	public static function boot()
    {
        parent::boot();
		
		static::deleting(function($template)
        {   
			Unit::whereTemplateId($template->id)->update(['template_id'=>0]);
            // Delete all tricks that belong to this user
            /* foreach ($user->tricks as $trick) {
                $trick->delete();
            } */
        });
    }
	
	
	/*	
		rules
	*/
	
	public static function rules($uid=null)
	{
		return array(
			'name'		=> 'required|min:3',
			'code'		=> 'required|min:3',
			//'code'		=> 'required|min:3|unique:units,code,'.$uid,
			//'template_id'	=> 'required',
			//'type_id'	=> 'required',
		);
	}
}