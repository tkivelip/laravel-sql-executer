<?php

namespace tkivelip\LaravelSqlExecuter\Tests;

use tkivelip\LaravelSqlExecuter\Providers\SqlExecuterServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            SqlExecuterServiceProvider::class,
        ];
    }
}
