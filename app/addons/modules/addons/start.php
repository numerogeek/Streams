<?php

App::singleton(
    'Addon\Module\Addons\Contract\ModuleRepositoryInterface',
    'Addon\Module\Addons\Repository\StreamsModuleRepository'
);

App::singleton(
    'Addon\Module\Addons\Contract\ThemeRepositoryInterface',
    'Addon\Module\Addons\Repository\StreamsThemeRepository'
);