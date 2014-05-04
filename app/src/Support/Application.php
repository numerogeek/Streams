<?php namespace Streams\Support;

use Composer\Autoload\ClassLoader;
use Illuminate\Support\Facades\Request;
use Streams\Model\ApplicationModel;

class Application
{
    /**
     * The application reference.
     *
     * @var null
     */
    protected $appRef = null;

    /**
     * Create a new Application instance
     */
    public function __construct()
    {
        $this->apps = new ApplicationModel();
    }

    /**
     * Boot the application environment.
     */
    public function boot()
    {
        $this->registerEntryModels();
        $this->setupAddonManagers();
        $this->setupAssetPaths();
        $this->setupTemplate();
    }

    /**
     * Check whether Streams is installed or not.
     *
     * @return bool
     */
    public function isInstalled()
    {
        return (!is_dir(base_path('installer')));
    }

    /**
     * Locate and setup the application
     *
     * @return bool
     */
    public function locate($domain = null)
    {
        if (!$this->appRef) {
            if (!$domain) {
                $domain = Request::root();
            }

            $domain = trim(str_replace(array('http://', 'https://'), '', $domain), '/');

            if ($app = $this->apps->findByDomain($domain)) {
                $this->appRef = $app->reference;

                \Schema::getConnection()->getSchemaGrammar()->setTablePrefix($this->getTablePrefix());
                \Schema::getConnection()->setTablePrefix($this->getTablePrefix());

                return true;
            }

            return false;
        }

        // We've been located yo
        return true;
    }

    /**
     * Locate our app or head to the installer.
     */
    public function installOrLocate()
    {
        if (\Config::get('debug')) {
            if (!\Application::isInstalled()) {
                if (\Request::segment(1) !== 'installer') {
                    header('Location: installer');
                    exit;
                }
            }
        } elseif (\Request::segment(1) !== 'installer') {
            \Application::locate();
        }
    }

    /**
     * Setup addon managers.
     */
    protected function setupAddonManagers()
    {
        $addons = array( /*'Block', 'Extension', 'FieldType', */
            'Module', /*'Tag', */
            'Theme'
        );

        foreach ($addons as $addon) {

            $interface = 'Addon\Module\Addons\Contract\\' . $addon . 'RepositoryInterface';
            $manager   = '\\' . $addon;

            $manager::mergeData(\App::make($interface));
        }
    }

    /**
     * Register entry models generated by streams.
     */
    protected function registerEntryModels()
    {
        $loader = new ClassLoader();

        $loader->addPsr4(
            'Streams\Model\\',
            'app/addons/models/streams/' . \Application::getAppRef()
        );
    }

    /**
     * Setup paths for the asset class.
     */
    public function setupAssetPaths()
    {
        $addons = array( /*'Block', 'Extension', 'FieldType', */
            'Module', /*'Tag', */
            'Theme'
        );

        foreach ($addons as $addon) {

            $manager   = '\\' . $addon;

            foreach ($manager::getAll() as $addon) {
                \Assets::addPaths($addon->loaderNamespace, $addon->path);
            }
        }
    }

    /**
     * Setup the template.
     */
    protected function setupTemplate()
    {
        $engine   = \App::make('streams.template.engine');
        $template = \App::make('streams.template');

        $theme = \Theme::getAdminTheme();

        if ($theme) {

            // Add the theme folder as the primary theme namespace.
            $engine->addFolder('theme', $theme->path . '/views');

            // Set the default layout.
            $template->layout('theme::layouts/default');
        }
    }

    /**
     * Get the current app ref
     *
     * @return null
     */
    public function getAppRef()
    {
        return $this->appRef;
    }

    /**
     * Return the app reference
     *
     * @return string
     */
    public function getTablePrefix()
    {
        if (!$this->appRef) {
            $this->locate();
        }

        return $this->appRef . '_';
    }
}