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
             'database' => 'database',
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
