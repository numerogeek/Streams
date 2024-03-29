<?php namespace Streams\Command;

use Illuminate\Console\Command as BaseCommand;
use Symfony\Component\Console\Input\InputArgument;

class  ModuleUninstallCommand extends BaseCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'streams:module-uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall a module.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $slug = $this->argument('slug');

        $name = ucfirst($slug);

        $module = \Module::get($slug);

        if (!$module) {
            $this->error("{$name} module not found.");
        } elseif ($module->isCore()) {
            $this->error("{$name} is a core module and cannot be uninstalled.");
        } elseif (\Module::install($slug)) {
            $this->info("{$name} module uninstalled.");
        } else {
            $this->error("There was a problem uninstalling {$name} module.");
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
