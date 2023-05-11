<?php

namespace Tmolbik\UrlConverter\Controllers;

use Tmolbik\UrlConverter\Models\Link;
 
class Links
{
    public static function create($key, $link)
    {
        $link = Link::create([
            'key' => $key,
            'link' => $link
        ]);

        return $link;
    }
}
