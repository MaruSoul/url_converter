<?php

namespace Tmolbik\UrlConverter\DataStorage;

class FileStorage implements DataStorageInterface
{
    protected array $links = [];

    public function __construct(
        protected string $filename,
    )
    {
        if (file_exists($this->filename)) {
            $this->links = (array) json_decode(file_get_contents($this->filename), true);
        }
    }

    public function save(string $key, string $link): void
    {
        $this->links[$key] = $link;
    }

    public function getByKey(string $key): string
    {
        return isset($this->links[$key]) ? $this->links[$key] : ''; 
    }

    public function getByLink(string $link): string
    {
        $key = array_search($link, $this->links);
        return isset($key) ? $key : ''; 
    }

    public function __destruct() {
        if (!file_exists(dirname($this->filename))) {
            mkdir(dirname($this->filename), 0775, true);
        }

        file_put_contents($this->filename, json_encode($this->links));
    }
}
