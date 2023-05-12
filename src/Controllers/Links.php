<?php

namespace Tmolbik\UrlConverter\Controllers;

use Tmolbik\UrlConverter\DataStorageInterface;
use Tmolbik\UrlConverter\Models\Link;
 
class Links implements DataStorageInterface
{
    public function getName(): string
    {
       return Link::getTableName();
    }

    public function save(array $data): void
    {
        Link::truncate();
        foreach ($data as $key => $link) {
            Link::create([
                'key' => $key,
                'link' => $link,
            ]);
        }
    }

    public function getData(): array
    {
        return Link::pluck('link', 'key')->toArray();
    }
}
