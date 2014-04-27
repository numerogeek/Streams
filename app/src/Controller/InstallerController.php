<?php namespace Streams\Controller;

use Illuminate\Routing\Controller;

class InstallerController extends Controller
{
    /**
     * Installation steps
     *
     * @var array
     */
    protected $installationSteps = array(
        'step1',
        'step2',
        'step3',
        'step4',
        'install',
        'complete'
    );

    /**
     * Create a new InstallerController instance
     */
    public function __construct()
    {
        // Check if Streams is installed.
        if ($this->isInstalled() or !$this->installerExists()) {
            return \Redirect::to('/');
        }

        $this->loader    = new \Composer\Autoload\ClassLoader();
        $this->installer = new \StreamsInstaller\Installer;

        $this->loader->addPsr4('StreamsInstaller\\', base_path('installer/src'));
        $this->loader->register();

        \View::addNamespace('installer', base_path('installer/views'));
    }

    /**
     * Run an installer step.
     *
     * @param string $step
     * @return \Illuminate\Http\RedirectResponse
     */
    public function run($step = 'step1')
    {
        if (!$this->isValidStep($step)) {
            return \Redirect::to('/installer/step1');
        }

        return $this->installer->{$step}();
    }

    /**
     * Is this install step valid?
     *
     * @param null $step
     * @return bool
     */
    public function isValidStep($step = null)
    {
        return in_array($step, $this->installationSteps);
    }

    /**
     * Does the installer directory exist?
     *
     * @return bool
     */
    public function installerExists()
    {
        return is_dir(base_path('installer'));
    }

    /**
     * Is Streams installed?
     *
     * @return bool
     */
    public function isInstalled()
    {
        return \Schema::hasTable('streams_streams');
    }
}
