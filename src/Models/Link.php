<?php

namespace Tmolbik\UrlConverter\Models;

use \Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = 'links';
    protected $fillable = ['key', 'link'];

    public static function getTableName()
{
    return (new self())->getTable();
}
}
