<?php

namespace Tmolbik\PhpPro;

interface IFileRepository
{
    public function getFilename(): string;
    public function save(array $data): void;
    public function getData(): array;
}