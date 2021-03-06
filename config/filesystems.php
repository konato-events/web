<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. A "local" driver, as well as a variety of cloud
    | based drivers are available for your choosing. Just store away!
    |
    | Supported: "local", "ftp", "s3", "rackspace"
    |
    */

    'default'  => (getenv('APP_ENV') == 'prod')? 'ftp' : 'local',
    'root_url' => (getenv('APP_ENV') == 'prod')? 'http://igorsantos.com.br/konato/' : '/app/',
    //    'default'  => (getenv('APP_ENV') == 'prod')? 's3' : 'local',
    //    'root_url' => (getenv('APP_ENV') == 'prod')? 'http://s3.amazonaws.com/konato-users/' : '/app/',

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => 's3',

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root'   => public_path('app')
        ],

//        'ftp' => [
//            'driver'   => 'ftp',
//            'host'     => 'ftp.example.com',
//            'username' => 'your-username',
//            'password' => 'your-password',

            // Optional FTP Settings...
            // 'port'     => 21,
            // 'root'     => '',
            // 'passive'  => true,
            // 'ssl'      => true,
            // 'timeout'  => 30,
//        ],

        's3' => (getenv('APP_ENV') != 'prod')? [] :
            call_user_func(function() {
                return [
                    'driver' => 's3',
                    'key'    => getenv('S3_KEY'),
                    'secret' => getenv('S3_SECRET'),
                    'region' => 'us-east-1',
                    'bucket' => 'konato-users',
                ];
            }),

        'sftp' => [
            'driver'   => 'sftp',
            'host'     => 'direct.igorsantos.com.br',
            'username' => 'konato',
            'password' => getenv('FTP_PASSWD'),
            'root'     => '/var/www/konato'
        ]
    ],

];
