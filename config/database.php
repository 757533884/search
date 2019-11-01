<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],
         //sale库
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        /* 这是需要新增加的设置内容，使用 .env 新增的内容 */
        'mysql_new' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_NEW', 'localhost'),
            'port' => env('DB_PORT_NEW', '3306'),
            'database' => env('DB_DATABASE_NEW', 'forge'),
            'username' => env('DB_USERNAME_NEW', 'forge'),
            'password' => env('DB_PASSWORD_NEW', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],
         //用户库
        'mysql_U' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_U', '127.0.0.1'),
            'port' => env('DB_PORT_U', '3306'),
            'database' => env('DB_DATABASE_U', 'forge'),
            'username' => env('DB_USERNAME_U', 'forge'),
            'password' => env('DB_PASSWORD_U', ''),
            'unix_socket' => env('DB_SOCKET_U', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        //业务库
        'mysql_B' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_B', '127.0.0.1'),
            'port' => env('DB_PORT_B', '3306'),
            'database' => env('DB_DATABASE_B', 'forge'),
            'username' => env('DB_USERNAME_B', 'forge'),
            'password' => env('DB_PASSWORD_B', ''),
            'unix_socket' => env('DB_SOCKET_B', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        //工单库
        'mysql_O' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_O', '127.0.0.1'),
            'port' => env('DB_PORT_O', '3306'),
            'database' => env('DB_DATABASE_O', 'forge'),
            'username' => env('DB_USERNAME_O', 'forge'),
            'password' => env('DB_PASSWORD_O', ''),
            'unix_socket' => env('DB_SOCKET_O', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        //后台管理
        'mysql_M' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_M', '127.0.0.1'),
            'port' => env('DB_PORT_M', '3306'),
            'database' => env('DB_DATABASE_M', 'forge'),
            'username' => env('DB_USERNAME_M', 'forge'),
            'password' => env('DB_PASSWORD_M', ''),
            'unix_socket' => env('DB_SOCKET_M', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        //测试库
        'mysql_T' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_B', '127.0.0.1'),
            'port' => env('DB_PORT_B', '3306'),
            'database' => env('DB_DATABASE_B', 'forge'),
            'username' => env('DB_USERNAME_B', 'forge'),
            'password' => env('DB_PASSWORD_B', ''),
            'unix_socket' => env('DB_SOCKET_B', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];
