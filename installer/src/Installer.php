<?php namespace StreamsInstaller;

/**
 * Class Installer
 * Controller response handler for the installer steps.
 *
 * @package StreamsInstaller
 */
class Installer
{
    /**
     * Step 1 of the installer.
     *
     * @return \Illuminate\View\View
     */
    public function step1()
    {
        return \View::make('installer::step1');
    }

    /**
     * Step 2 of the installer.
     *
     * @return \Illuminate\View\View
     */
    public function step2()
    {
        return \View::make('installer::step2');
    }

    /**
     * The chunk of the installation logic goes here.
     *
     * @return \Illuminate\View\View
     */
    public function install()
    {
        // Add our streams folder
        if (!is_dir(base_path('app/models/streams'))) {
            mkdir(base_path('app/models/streams'), 0777);
        }

        // Install our streams_ tables
        $installerSchema = new \StreamsInstaller\InstallerSchema;
        $installerSchema->install();

        // Install our core modules
        foreach (\Module::getAll() as $module) {
            if (!\Module::install($module->slug)) {
                return false;
            }
        }

        return \Redirect::to('installer/complete');
    }

    /**
     * Complete the installation process.
     *
     * @return \Illuminate\View\View
     */
    public function complete()
    {
        //$this->removeInstaller();

        return \Redirect::to('/');
    }

    /**
     * Remove the installer directory.
     *
     * @param null $directory
     * @return bool
     */
    public function removeInstaller($directory = null)
    {
        $directory = $directory ? $directory : base_path('installer');
        $files     = array_diff(scandir($directory), array('.', '..'));

        foreach ($files as $file) {
            if (is_dir($directory . '/' . $file)) {
                $this->removeInstaller($directory . '/' . $file);
            } else {
                unlink($directory . '/' . $file);
            }
        }

        return rmdir($directory);
    }
}
