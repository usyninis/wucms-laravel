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

class ImagesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */


	public function __construct()
    {
        $this->beforeFilter('admin.auth');
        $this->beforeFilter('admin.role:admin');
    	
    }

	public function index()
	{

	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$path = Config::get('wucms::gallery.upload_images_path').'/'.date('Y-m-d');
		
		$root = public_path()?:$_SERVER['DOCUMENT_ROOT'];		
		
		$full_path = $root.'/'.$path;
		//dd($base_path);
		//print_array($_FILES);
		
		$upload_files_count = 0;		
		
		
		if ( ! Input::hasFile('images')) return Response::json(['status'=>'error','message'=>'not select file']); 
	
		$files = Input::file('images');
		$files_count = count($files);
		
		$album_id = Input::get('album_id');
	
		$images = [];
	
		foreach($files as $file) 
		{
			$validator = Validator::make(array('image'=>$file),Image::rules());				
			
			if ($validator->fails()) return Response::json(['status'=>'error','message'=>$validator->messages()->first()]);				
						
			//$filename = date('H-i-s').'-'.URLify::filter(str_random(12), 60, "", true);
			$filename = date('H-i-s').'-'.\URLify::filter($file->getClientOriginalName(), 60, "", true);
			
			//$upload_success = true;
			

			if($upload_success = $file->move($full_path, $filename))
			{
				$upload_files_count++;
			  
				$image = new Image;
				$image->filename = $filename;
				$image->name = $file->getClientOriginalName();
				$image->path = $path;
				$image->album_id = $album_id;
				$image->save();
				$images[] = View::make('wucms::albums.image',['image'=>$image,'hide'=>true])->render();
			}
			else
			{
				return Response::json(['status'=>'error','message'=>'upload error']);
			}
			
			
		}
		
		if($album_id) Album::find($album_id)->save();

		return Response::json(['status'=>'ok','message'=>'<b>Загружено:</b> '.$files_count.'/'.$upload_files_count,'images'=>$images]);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{	

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
	
		$image = Image::find($id);
		$image->name = Input::get('name');
		$image->description = Input::get('description');
		$image->album_id = Input::get('album_id');
		$image->save();
		return Response::json(['status'=>'ok','message'=>'Image update success']);
		
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$json = [];
		
		if($image = Image::find($id))
		{
			
			if (File::exists(public_path().$image->src)) 
				File::delete(public_path().$image->src);
				
			$json['status'] = 'ok';
			$json['id'] = $image->id;
			$json['message'] = 'Изображение удалено';
			$album_id = $image->album_id;					
			$image->delete();
			
			if($album_id) 
				Album::find($album_id)->save();					
		}
		else
		{
			$json['status'] = 'error';
			$json['message'] = 'Ошибка удаления';
			$json['id'] = $id;
		}
		return Response::json($json);
	}


}
