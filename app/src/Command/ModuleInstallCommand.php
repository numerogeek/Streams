<?php namespace Streams\Command;

use Illuminate\Console\Command as BaseCommand;
use Symfony\Component\Console\Input\InputArgument;

class  ModuleInstallCommand extends BaseCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'streams:module-install';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Install a module.';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $slug = $this->argument('slug');

        if (!$module = \Module::get($slug)) {
            $this->error("{$slug} module not found.");
        }

        if ($module and \Module::install($slug)) {
            $this->info("{$slug} module installed.");
        } else {
            $this->error("{$slug} module was not installed.");
        }
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('slug', InputArgument::REQUIRED, 'The module slug.'),
		);
	}

}
