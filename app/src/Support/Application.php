<?php namespace Streams\Support;

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