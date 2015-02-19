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
		$album = new Album;
		$album->name = Input::get('name');
		$album->save();
		return Redirect::back();
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
			->with('images',Image::whereAlbumId($id)->paginate(50));
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
	
		$album = Album::find($id);
		$album->name = Input::get('name');
		$album->save();
		return Response::json(['status'=>'ok','message'=>'Альбом обновлен']);
	
				
		
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		
	}


}
