<?php namespace Usyninis\Wucms;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class InstallCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'wucms:install';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Installation wucms admin pack.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		//
		$this->info('start install..');
		$this->call('migrate',array('--path' => 'workbench/usyninis/wucms/src/migrations'));
		$this->call('migrate',array('--package' => 'Usyninis/Wucms'));
		//$this->call('asset:publish', array('--package' => 'Usyninis/Wucms'));
		$this->call('asset:publish', array('--bench' => 'Usyninis/Wucms'));
		$this->info('Install Successfull!');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
