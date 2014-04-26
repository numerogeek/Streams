<?php namespace Streams\Command;

use Illuminate\Console\Command as BaseCommand;

class  ModuleInstallAllCommand extends BaseCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'streams:module-install-all';

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
/*        $slug = $this->argument('slug');

        $name = ucfirst($slug);

		if ($module = Module::get($slug)) {
            if ($module->install()) {
                $this->info("{$name} module installed.");
            }
        } else {
            $this->info("{$name} module not found.");
        }*/
	}

}
