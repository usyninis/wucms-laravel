<?php

namespace Usyninis\Wucms;

class Album extends \Eloquent
{

	public $timestamps = false;

	
	
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
		return $this->hasMany('Image')->orderBy('id','DESC');
	}
	
	public function image()
	{
		return $this->belongsTo('Image');
	}

	
}