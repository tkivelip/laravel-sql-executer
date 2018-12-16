<?php

namespace tkivelip\LaravelSqlImport\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use tkivelip\LaravelSqlImport\Exceptions\SqlImportException;
use tkivelip\LaravelSqlImport\Jobs\ExecuteSqlJob;

class ImportSql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:sql-import {file} {path=?} {disk=default} {queue=null} {connection=default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import or execute any SQL statements from a file';

    /**
     * Execute the console command.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        if (! $this->fileExists()) {
            $this->error('File not found!');
            throw new SqlImportException('File not found!');
        }

        return $this->argument('queue')
            ? $this->dispatchJob()
            : $this->runJob();
    }

    protected function makeJob()
    {
        return new ExecuteSqlJob(
            $this->getRelativeUri(),
            $this->argument('disk'),
            $this->argument('connection')
        );
    }

    protected function runJob()
    {
        $this->info('SQL file execution startet!');

        try {
            return $this->makeJob()->handle();
        }
        catch (\Exception $error) {
            $this->error('SQL file execution faild!');
        }
    }

    protected function dispatchJob()
    {
        $this->info('SQL file execution queued!');
        return $this->makeJob()->onQueue($this->argument('queue'));
    }

    protected function fileExists()
    {
        return Storage::disk($this->argument('disk'))
            ->exists($this->getRelativeUri());
    }

    protected function getRelativeUri()
    {
        return implode('', [
            $this->argument('path'),
            DIRECTORY_SEPARATOR,
            $this->argument('file'),
        ]);
    }
}
