<?php namespace StreamsInstaller;

/**
 * Class Installer
 * Seudo-controller to handle the steps of the installer steps.
 *
 * @package StreamsInstaller
 */
class Installer
{
    public function step1()
    {
        return \View::make('installer::step1');
    }

    public function step2()
    {
        return \View::make('installer::step2');
    }

    public function install()
    {
        $installerSchema = new \StreamsInstaller\InstallerSchema;
        $installerSchema->install();
        // Run final install
        return \Redirect::to('installer/complete');
    }

    public function complete()
    {
        return \View::make('installer::complete');
    }
}