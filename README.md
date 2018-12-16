# Laravel SQL Executer

This package allows you to execute SQL statements from files directly or queued. 
It uses Laravel's disk Feature, so it is possible to use remote filesystems, too.

This is an easy way to import, seed and transform data very quickly by writing
just SQL statements to a file. 
  

## Installation

You can install the package via composer:

```bash
composer require tkivelip/laravel-sql-executer
```

## How to use?

### Using Artisan Console Commands
You can use Artisan to execute a SQL File. If you like to execute the SQL file
directly, use the `sql-executer:run` command:

```bash
php artisan sql-executer:run relative/path/file.sql
```

If you like to queue the execution of a SQL file, use the 
`sql-executer:queue` command.

```bash
php artisan sql-executer:queue relative/path/file.sql
```

### Using within your application
You can use Laravel's `Artisan::call()` method within your code to execute or queue
a SQL file:

```php
use Illuminate\Support\Facades\Artisan;

// Execute directly
Artisan::call('sql-executer:run', [
    'file' => 'relative/path/file.sql'
]);

// Queue execution
Artisan::call('sql-executer:queue', [
    'file' => 'relative/path/file.sql'
]);
```

### Options
You can configure the commands by the following options.

##### On both commands:
- `--disc=name` Name of the disk to use
- `--sql-connection=name` Name of the SQL connection to use

##### On queue command:
- `--queue=name` Name of the queue to use




### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## Credits

- [Tobi Kivelip](https://github.com/tkivelip)
- [All Other Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
 
