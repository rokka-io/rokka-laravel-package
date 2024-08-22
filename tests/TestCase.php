<?php

namespace Rokka\RokkaLaravel\Tests;

use Rokka\RokkaLaravel\RokkaLaravelServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            RokkaLaravelServiceProvider::class,
        ];
    }
}