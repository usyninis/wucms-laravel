<?php

namespace Usyninis\Wucms;

use Illuminate\Support\Facades\Auth;

class Album extends \Eloquent
{

	public $timestamps = false;

	
	protected $fillable = array('name', 'description');
	
	//protected $guarded = array('id');
	public static function rules()
	{
		return array(
			'name'		=> 'required|min:3'
		);
	}
	
    public static function boot()
    {
        parent::boot();

		static::creating(function($album)
		{			
			$album->created_by = Auth::user()->id;
		});

		

		static::saving(function($album)
		{			
			
			$album->count = Image::whereAlbumId($album->id)->count();
			//пересчитать
			
			
		});
    }
	
	public function images()
	{
		return $this->hasMany('Usyninis\Wucms\Image')->orderBy('id','DESC');
	}
	
	public function image()
	{
		return $this->belongsTo('Usyninis\Wucms\Image');
	}

	
}