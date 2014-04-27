<?php

/*
|--------------------------------------------------------------------------
| Register The Artisan Commands
|--------------------------------------------------------------------------
|
| Each available Artisan command must be registered with the console so
| that it is available to be called. We'll register every command so
| the console gets access to each of the command object instances.
|
*/

Artisan::add(new \Streams\Command\ModuleInstallAllCommand());
Artisan::add(new \Streams\Command\ModuleInstallCommand());
Artisan::add(new \Streams\Command\ModuleUninstallCommand());
Artisan::add(new \Streams\Command\UserCreateCommand());