<?php namespace Streams\Setup;

class InstallerSetup
{
    public function __construct()
    {
        // Check if the installer folder was removed
        if (!$this->installerExists()) {
            return \Redirect::to('/');
        }

        $loader = new \Composer\Autoload\ClassLoader();
        $loader->addPsr4('StreamsInstaller\\', base_path('installer/src'));
        $loader->register();

        \View::addNamespace('installer', base_path('installer/views'));
    }

    protected $validSteps = array(
        'step1',
        'step2',
        'step3',
        'step4',
        'install',
        'complete'
    );

    public function run($step = 'step1')
    {
        if (!$this->isValidStep($step)) {
            return \Redirect::to('/installer/step1');
        }

        $installer = new \StreamsInstaller\Installer;

        return $installer->{$step}();
    }

    public function isValidStep($step = null)
    {
        return in_array($step, $this->validSteps);
    }

    public function installerExists()
    {
       return is_dir(base_path('installer'));
    }

    public function isInstalled()
    {
        //@todo - add some efficient logic to determine if Streams is installed
        return false;
    }
}