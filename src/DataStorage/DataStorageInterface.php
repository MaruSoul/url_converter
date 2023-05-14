<?php

namespace Tmolbik\UrlConverter\DataStorage;

interface DataStorageInterface
{
    public function save(string $key, string $link): void;
    public function getByKey(string $key): string;
    public function getByLink(string $link): string;
}
