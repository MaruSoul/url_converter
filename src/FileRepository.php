<?php

namespace Tmolbik\UrlConverter;

class FileRepository implements FileRepositoryInterface
{
    public function __construct(
        protected string $filename,
    )
    {
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function save(array $data): void
    {
        if (!file_exists(dirname($this->filename))) {
            mkdir(dirname($this->filename), 0775, true);
        }

        file_put_contents($this->filename, json_encode($data));
    }

    public function getData(): array
    {
        $data = [];

        if (file_exists($this->filename)) {
            $data = (array) json_decode(file_get_contents($this->filename), true);
        }

        return $data;
    }
}
