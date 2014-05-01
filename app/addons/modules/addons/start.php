<?php

App::bind(
    'Addon\Module\Addons\Contract\ModuleRepositoryInterface',
    'Addon\Module\Addons\Repository\StreamsModuleRepository'
);

App::bind(
    'Addon\Module\Addons\Contract\ThemeRepositoryInterface',
    'Addon\Module\Addons\Repository\StreamsThemeRepository'
);