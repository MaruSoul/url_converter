<?php

namespace Tmolbik\UrlConverter\Models; 

use Illuminate\Database\Capsule\Manager as Capsule;

class Database 
{
    public function __construct() 
    {
        $capsule = new Capsule;
        $capsule->addConnection([
             'driver' => 'mysql',
             'host' => 'db',
             'database' => 'url_converter',
             'username' => 'user',
             'password' => 'root',
             'charset' => 'utf8',
             'collation' => 'utf8_unicode_ci',
             'prefix' => '',
        ]);

        $capsule->bootEloquent();
        $capsule->setAsGlobal();
    }
}
