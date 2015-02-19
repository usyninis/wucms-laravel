<?php

namespace Usyninis\Wucms;

use Illuminate\Database\Eloquent\Model as Eloquent;

use Intervention\Image\ImageManager;

use Config;
use File;
use Input;


class Image extends Eloquent
{

	protected $table = 'images'; 
	//protected $watermark_src = 'images'; 

	//public static $resize_path = 'public/upload/resize';
	
	
	
	//protected $guarded = array('id');
	public static function rules()
	{
		return array(
			'image'	=> 'required|image|max:15000'			
		);
	}

	public static function boot()
    {
        parent::boot();

		static::creating(function($unit)
		{			
			$unit->created_by = \Auth::user()->id;
		});

		

		static::saving(function($unit)
		{			
			
			
			//ïåðåñ÷èòàòü
			
			
		});
    }

	public function getSrcAttribute()
	{		
	
		if( ! $this) return false;
		return asset($this->attributes['path'].'/'.$this->attributes['filename']);
		
	}

	public function watermark($width=null,$height=null)
	{
		return $this->thumb($width,$height,true);
	}

	/* public function clearThumb()
	{
		$thumb_dir = Config::get('gallery.thumb_path').'/'.$this->id;
	} */

	public function thumb($width=null,$height=null,$watermark=false)
	{
		/* die(public_path());
		die(public_path()); */
		if( ! Config::get('wucms::gallery.thumb_enable')) return $this->src;		
		
		$root = public_path()?:$_SERVER['DOCUMENT_ROOT'];
		
		$thumb_path = Config::get('wucms::gallery.thumb_path').'/'.$this->id;
		
		$full_thumb_path = $root.'/'.$thumb_path;
		//$this->id.'-'.($watermark?'w':''). (int) $width .'x'. (int) $height
		
		if(Input::get('clearThumb') && access('admin')) 
		{
			File::deleteDirectory($full_thumb_path);
		}
		
		if(!is_dir($full_thumb_path)) File::makeDirectory($full_thumb_path, 0777, true);
		
		$thumb_filename = $this->id.'-'.($watermark?'w':''). round((int)$width,-1) .'x'. round((int)$height,-1) . '-' . $this->filename;
		
		$thumb_src = $thumb_path.'/'.$thumb_filename;
		
		$thumb_full_src = $root.'/'.$thumb_src;
		
		if(File::exists($thumb_full_src)) 
			return asset($thumb_src); 
		
		
		
		$manager = new ImageManager(array('driver' => 'imagick'));
		
		//$manager->insert($_SERVER['DOCUMENT_ROOT'].'/moder-teh/img/wm.png', 'bottom-left', 10, 10);
		// create a new Image instance for inserting
			//$watermark = Image::make('public/watermark.png');
			//$img->insert($watermark, 'center');

		// insert watermark at bottom-right corner with 10px offset
		/*$watermark = new ImageManager(array('driver' => 'imagick'));
		$watermark->make($_SERVER['DOCUMENT_ROOT'].'/modern-teh/img/wm.png')*/
		
		$original_src = $this->path.'/'.$this->filename;
		
		$original_full_src = $root.'/'.$original_src;
		
		if( ! File::exists($original_full_src)) return false;
		
		
		
		$manager->make($original_full_src)			
			->resize($width, $height, function ($constraint) {			    
			    $constraint->aspectRatio();
			    //$constraint->upsize();
			    //$constraint->insert($_SERVER['DOCUMENT_ROOT'].'/modern-teh/img/wm.png', 'bottom-left', 10, 10);
			})			
			->save($thumb_full_src);
		
		if($watermark)
		{
			$watermark_src = Config::get('wucms::gallery.watermark_src');//'/'.Setting::value('template').'/img/wm.png';
			
			$watermark_full_src = $root.'/'.$watermark_src;
			
			$manager->make($thumb_full_src)
				->insert($watermark_full_src, 'bottom-left', 10, 10)
				->save($thumb_full_src);
		}
		
		return asset($thumb_src);
		/* $im = new Imagick($thumb_src);
		
		$im->resizeImage($size,$size,imagick::FILTER_LANCZOS,1,TRUE);	
		//$im->setImageResolution($acategory['dpi'],$acategory['dpi']);				
		$im->writeImage($thumb_src);
		$im->clear(); 
		$im->destroy(); 
		*/
		/* $manager = new ImageManager(array('driver' => 'imagick'));
		$manager->make($this->src)->resize(300, 200)->save($thumb_src);  */
		
		
		//return $thumb_src;
	}

	/* public function thumb2($width=null,$height=null)
	{
		$thumb_dir = '/upload/thumb/'. (int) $width .'x'. (int) $height;
		if( ! is_dir($_SERVER['DOCUMENT_ROOT'].$thumb_dir) ) mkdir($_SERVER['DOCUMENT_ROOT'].$thumb_dir,0777);
		$thumb_src = $thumb_dir.'/'.$this->filename;

		$image = new ImageManager(array('driver' => 'imagick'));
		$image->make($_SERVER['DOCUMENT_ROOT'].$this->src)
			->insert($_SERVER['DOCUMENT_ROOT'].'/modern-teh/img/wm.png', 'bottom-left', 10, 10)
			->save($_SERVER['DOCUMENT_ROOT'].$thumb_src);
		
		return $thumb_src;

	}
 */

	public function album()
	{
		return $this->belongsTo('Usyninis\Wucms\Album');
	}

	
}