<?php

namespace tkivelip\LaravelSqlExecuter\Tests\Unit\Jobs;

use tkivelip\LaravelSqlExecuter\Exceptions\SqlExecuterException;
use tkivelip\LaravelSqlExecuter\Jobs\ExecuteSqlJob;
use tkivelip\LaravelSqlExecuter\Tests\TestCase;

class ExecuteSqlJobTest extends TestCase
{
    public function testThrowsAnExceptionIfFileNotFound()
    {
        $this->expectException(SqlExecuterException::class);

        $job = new ExecuteSqlJob('unkown-file.sql');

        $job->handle();
    }
}
