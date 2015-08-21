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

class AlbumsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */


	public function __construct()
    {
        $this->beforeFilter('admin.auth');
        $this->beforeFilter('admin.role:admin');
		
    	return View::share('albums',Album::all());
    	
    	
    }

	public function index()
	{
		
		
		return View::make('wucms::albums.list')
			->with('album',false)
			->with('images',Image::orderBy('id','DESC')->paginate(100));
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
		$json = [];
		
		$validator = Validator::make(Input::all(),Album::rules());
				
		if ($validator->fails()) 
		{
			$json['status'] = 'error';
			$json['message'] = $validator->messages()->first();
			return Response::json($json);
		}
		
		$album = new Album;
		$album->fill(Input::all());
		$album->save();
		
		$json['status'] = 'ok';
		$json['message'] = 'Альбом добавлен';
		$json['reload'] = route('admin.albums.show',$album->id);
		
		
		return Response::json($json);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{			
		return View::make('wucms::albums.list')						
			->with('album',Album::find($id))
			->with('images',Image::whereAlbumId($id)->orderBy('sort','asc')->paginate(200));
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
		$json = [];
		
		$validator = Validator::make(Input::all(),Album::rules());
				
		if ($validator->fails()) 
		{
			$json['status'] = 'error';
			$json['message'] = $validator->messages()->first();
			return Response::json($json);
		}
		
		$album = Album::find($id);
		$album->fill(Input::all());
		$album->save();
		
		$json['status'] = 'ok';
		$json['message'] = 'Альбом обновлен';
		
		
		return Response::json($json);
			
		
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
		
		if($album = Album::find($id))
		{
			Image::whereAlbumId($id)->update(['album_id'=>0]);
			$album->delete();
			
			$json['status'] = 'ok';
			$json['message'] = 'Альбом удален';
			$json['reload'] = route('admin.albums.index');
			
		}
		else
		{
			$json['status'] = 'error';
			$json['message'] = 'Альбом не найден';
		}		
		
		return Response::json($json);
	}


}
