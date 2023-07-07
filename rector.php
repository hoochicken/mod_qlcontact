<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/.',
    ]);

    // register a single rule
    $rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);

    $rectorConfig->skip([
        __DIR__ . '/vendor',
    ]);

    // define sets of rules
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_82,
    ]);
};
