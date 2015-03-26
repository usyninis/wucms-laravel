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




class AppController extends Controller {

	//protected $layout = 'template::templates.default';
	
	protected $unit = null;

	public function __construct()
    {
        //$this->beforeFilter('auth');
        //$this->beforeFilter('admin');
		// $this->beforeFilter('csrf');
	   //View::share('settings', Setting::All()->keyBy('code'));
    }
	
	public function index()
	{
		
		$this->unit = Unit::whereMain(1)->active()->first();
		
		if( ! $this->unit) App::abort(404);
		//$this->ckeckUrl();
		
		if($this->unit->need_url != Request::path()) return Redirect::to($this->unit->need_url,301);
		
		$this->setTemplate();
		//View::share('unit', $unit);
		
	}
	
	
	public function unit()
	{
	
		$this->unit = Unit::whereCode(\Route::input('code'))->active()->first();		
	
		if( ! $this->unit) App::abort(404);
		
		if($this->unit->need_url != Request::path()) return Redirect::to($this->unit->need_url,301);
		
		$this->setTemplate();
	
	}
	
	
	public function unitByCode($code)
	{
	
		$this->unit = Unit::where('code','=',$code)->active()->firstOrFail();
	
	}
	
	
	public function unitById($id)
	{
		$this->unit = Unit::where('id','=',$id)->active()->firstOrFail();
		/*$new_page = new Page;

		$new_page->code = 'contacts';
		$new_page->url = '/contacts';
		$new_page->level = 1;
		$new_page->menu_name = 'КОнтакты';
		$new_page->active = 1;
		$new_page->save();*/

		//die($id);
		
		//return Unit::first();
		
		
		//return Group::first();
		
		$segments = Request::segments();
		
		//$props = (object) Prop::lists('value','code');		
		
		$code = end($segments);
		
		
		
		if(!$code)
		{
			$unit = Unit::whereMain(1)->active()->firstOrFail();
			
			
			
		}
		else
		{
			
			$unit = Unit::where('code','=',$code)->active()->firstOrFail();
			
			//die($code);
			
		}
		
		
		
		$need_url = $unit->main ? '/' : $unit->url;
		$check_url = $unit->main ? Request::path() : '/'.Request::path();
		
		if($need_url != $check_url) return Redirect::to($need_url,301);
		
		if($new_url = object_get($unit->prop('redirect'),'url')) return Redirect::to($new_url,301);
		
		
		View::share('unit', $unit);
			
		//return $unit;
			
		
		//View::addLocation('/app/views/modern-teh');
		

		/* View::composer('template::menu.*', function($view)
		{
			//$view->setPath('sokolfit.menu.main');
			$viewdata = $view->getData();
			
			$group = (!empty($viewdata['code']))? Group::where('code','=',$viewdata['code'])->first() : false ;
			$view->with('group',$group);
			//$view->with('items',Unit::where('level','=',1)->get());
			//$view->with('viewdata',$viewdata);
			//$view->setPath('sokolfit.menu.main');
			//$view->with('viewname',$view->getName());
		}); */

		
				//print_array($unit->children);
		
		//$unit_children = Unit::children($unit->id);		

		
		$view =  'template::units.'.$unit->code;			
		
		if( ! View::exists($view)) 
			$view = 'template::templates.'.$unit->templateCode;
			
		$this->layout = View::make($view);
			
		
			
			
			

	}

	/* public function ckeckUrl()
	{
		$need_url = $this->unit->url;
		
		$check_url = Request::path();
	} */

	public function setTemplate()
	{
		View::share('unit', $this->unit);
		
		$view =  'template::units.'.$this->unit->code;			
		
		if( ! View::exists($view)) 
			$view = 'template::templates.'.$this->unit->templateCode;
			
		$this->layout = View::make($view);
	}
	
	function develop()
	{
		//if(Setting::value('site_enable')) return Redirect::route('index');
		
		$view = 'template::errors.develop';
		
		if( ! View::exists($view)) 
			$view = 'usyninis::errors.develop';
			
		$this->layout = View::make($view);
	}



}
