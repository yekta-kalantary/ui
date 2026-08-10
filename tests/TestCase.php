<?php

declare(strict_types=1);

namespace Yekta\Ui\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Yekta\Ui\UiServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [UiServiceProvider::class];
    }
}
