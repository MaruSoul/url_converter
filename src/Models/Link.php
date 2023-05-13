<?php

namespace Tmolbik\UrlConverter\Models;

use \Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = 'encoded_links';
    protected $fillable = ['key', 'link'];
}
