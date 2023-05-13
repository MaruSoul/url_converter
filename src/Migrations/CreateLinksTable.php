<?php

namespace Tmolbik\UrlConverter\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

class CreateLinksTable
{
    public function up()
    {
        if (!Capsule::schema()->hasTable('links')) {
            Capsule::schema()->create('links', function ($table) {
                $table->increments('id');
                $table->string('key')->unique();
                $table->string('link');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('links');
    }
}
