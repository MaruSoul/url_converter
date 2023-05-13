<?php

namespace Tmolbik\UrlConverter\DataStorage;

interface DataStorageInterface
{
    public function getName(): string;
    public function save(array $data): void;
    public function getData(): array;
}
