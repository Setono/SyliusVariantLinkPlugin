<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $config): void {
    $config->import('vendor/sylius-labs/coding-standard/ecs.php');
    $config->parameters()->set(Option::PATHS, [
        'src',
        'tests',
    ]);
    $config->parameters()->set(Option::SKIP, [
        'tests/Application/node_modules/**',
        'tests/Application/var/**',
    ]);
};
