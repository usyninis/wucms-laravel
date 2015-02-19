<?php namespace Usyninis\Wucms;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class WucmsServiceProvider extends ServiceProvider {


	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
     * The facades package.
     *
     * @var array
     */
	 
	protected $facades = [
		//models
        'Album'		=> 'Usyninis\Wucms\Album',
        'Group'		=> 'Usyninis\Wucms\Group',
        'Image'		=> 'Usyninis\Wucms\Image',
        'Prop'		=> 'Usyninis\Wucms\Prop',
        'Role'		=> 'Usyninis\Wucms\Role',
        'Setting'	=> 'Usyninis\Wucms\Setting',
        'Template'	=> 'Usyninis\Wucms\Template',
        'Type'		=> 'Usyninis\Wucms\Type',
        'Unit'		=> 'Usyninis\Wucms\Unit',
        'UnitProp'	=> 'Usyninis\Wucms\UnitProp',
        //'User'		=> 'Usyninis\Wucms\User',
    ];
		
	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	 
	 
	public function boot()
	{
		$this->package('usyninis/wucms','wucms');
		
		include __DIR__.'/../../filters.php';		
		include __DIR__.'/../../routes.php';
		include __DIR__.'/../../errors.php';
		
		include __DIR__.'/../../macros/form.php';
		include __DIR__.'/../../macros/html.php';
		
		include __DIR__.'/../../helpers/wucms.php';
		
		
		
		
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		
		AliasLoader::getInstance($this->facades);
		
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
