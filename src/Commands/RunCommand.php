<?php

namespace tkivelip\LaravelSqlExecuter\Commands;

use tkivelip\LaravelSqlExecuter\Jobs\ExecuteSqlJob;

class RunCommand extends AbstractCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sql-executer:run {file} {--disk=} {--sql-connection=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute a SQL file';

    /**
     * Process job.
     *
     * @param ExecuteSqlJob $job
     */
    protected function processJob(ExecuteSqlJob $job)
    {
        try {
            $this->info('Executing file: '.$this->argument('file'));
            $job->handle();
        } catch (\Exception $error) {
            $this->error('Error:'.$error->getMessage());
        }
    }
}
