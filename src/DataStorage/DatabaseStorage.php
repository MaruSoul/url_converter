<?php

namespace Tmolbik\UrlConverter\DataStorage;

use Tmolbik\UrlConverter\Models\Link;

class DatabaseStorage implements DataStorageInterface
{
    public function save(string $key, string $link): void
    {
        Link::updateOrCreate(
            ['key' => $key],
            ['link' => $link]
        );
    }

    public function getByKey(string $key): string
    {
        $link = Link::where('key', $key)->first();
        return $link ? $link->link : ''; 
    }


    public function getByLink(string $link): string
    {
        $key = Link::where('link', $link)->first();
        return $key ? $key->key : ''; 
    }
}
