<?php

namespace Tmolbik\UrlConverter\DataStorage;

use Tmolbik\UrlConverter\DataStorage\DataStorageInterface;
use Tmolbik\UrlConverter\Models\Link;

class DatabaseStorage implements DataStorageInterface
{
    public function getName(): string
    {
       return Link::getTableName();
    }

    public function save(array $data): void
    {
       foreach ($data as $key => $link) {
           Link::updateOrCreate(
               ['key' => $key],
               ['link' => $link]
           );
       }
    }

    public function getData(): array
    {
        return Link::pluck('link', 'key')->toArray();
    }
}
