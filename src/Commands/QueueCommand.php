<?php

namespace tkivelip\LaravelSqlExecuter\Commands;

use tkivelip\LaravelSqlExecuter\Jobs\ExecuteSqlJob;

class QueueCommand extends AbstractCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sql-executer:queue {file} {--disk=} {--queue=} {--sql-connection=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Queue the execution of a SQL file';

    /**
     * Process job.
     *
     * @param ExecuteSqlJob $job
     */
    protected function processJob(ExecuteSqlJob $job)
    {
        if ($queue = $this->option('queue')) {
            $job->onQueue($queue);
        }

        dispatch($job);
        $this->info(sprintf('Execution of SQL file "%s" queued!', $this->argument('file')));
    }
}
