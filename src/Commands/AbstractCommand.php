<?php

namespace tkivelip\LaravelSqlExecuter\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use tkivelip\LaravelSqlExecuter\Jobs\ExecuteSqlJob;

abstract class AbstractCommand extends Command
{
    /**
     * Execute the console command.
     */
    final public function handle()
    {
        $file = $this->argument('file');
        $disk = $this->option('disk');

        if (Storage::disk($disk)->exists($file)) {
            $this->processJob(
                new ExecuteSqlJob(
                    $file,
                    $disk,
                    $this->option('sql-connection')
                )
            );
        }

        $this->error(sprintf('File "%s" not found!', $file));
    }

    /**
     * Process job.
     *
     * @param ExecuteSqlJob $job
     */
    abstract protected function processJob(ExecuteSqlJob $job);
}
