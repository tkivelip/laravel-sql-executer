<?php

namespace tkivelip\LaravelSqlExecuter\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use tkivelip\LaravelSqlExecuter\Exceptions\SqlExecuterException;

class ExecuteSqlJob implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    /**
     * SQL file name with relative path.
     *
     * @var string
     */
    protected $file;

    /**
     * Disk name.
     *
     * @var string
     */
    protected $disk;

    /**
     * @var string
     */
    protected $sql_connection;

    /**
     * ExecuteSqlJob constructor.
     *
     * @param string $file
     * @param string $disk
     * @param string $sqlConnection
     */
    public function __construct(string $file, string $disk = 'default', string $sqlConnection = 'default')
    {
        $this->file = $file;

        $this->disk = 'default' != $disk
            ? $disk
            : config('filesystem.default');

        $this->sql_connection = 'default' != $sqlConnection
            ? $sqlConnection
            : config('database.default');
    }

    /**
     * Handle the job.
     *
     * @throws SqlExecuterException
     *
     * @return bool
     */
    public function handle()
    {
        try {
            $content = Storage::disk($this->disk)->get($this->file);
        } catch (\Exception $error) {
            throw new SqlExecuterException(sprintf('File "%s" not found!', $this->file), 0, $error);
        }

        return DB::connection($this->sql_connection)
            ->unprepared($content);
    }
}
