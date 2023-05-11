<?php

namespace Tmolbik\UrlConverter;

interface FileRepositoryInterface
{
    public function getFilename(): string;
    public function save(array $data): void;
    public function getData(): array;
}
