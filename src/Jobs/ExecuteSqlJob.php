<?php

namespace tkivelip\LaravelSqlImport\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use tkivelip\LaravelSqlImport\Exceptions\SqlImportException;

class ExecuteSqlJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct($file, $disk='default', $connection = 'default')
    {
        $this->file = $file;
        $this->disk = $disk;
        $this->connection = $connection;
    }

    public function handle()
    {
        try {
            $content = file_get_contents(Storage::disk($this->disk)->get($this->file));
        } catch (\Exception $error) {
            throw new SqlImportException('File not found!');
        }

        return DB::connection($this->connection)->unprepared($content);
    }
}
