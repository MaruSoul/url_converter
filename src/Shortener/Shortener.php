<?php

namespace Tmolbik\PhpPro\Shortener;

use InvalidArgumentException;

class Shortener implements IUrlDecoder, IUrlEncoder
{
    protected array $links;

    public function __construct(
        protected string $filename,
        protected int $length,
        protected IUrlValidator $validator = new UrlValidator(),
    )
    {
        if (file_exists($this->filename)) {
            $this->links = json_decode(file_get_contents($this->filename), true);
        } else {
            $this->links = [];
        }
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function setLength(int $length): void
    {
        $this->length = $length;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function saveLinks(): void
    {
        if (!file_exists(dirname($this->filename))) {
            mkdir(dirname($this->filename), 0775, true);
        }

        file_put_contents($this->filename, json_encode($this->links));
    }

    public function decode(string $code): string
    {
        return $this->links[$code] ?? throw new InvalidArgumentException('Don\'t find the code');
    }

    public function encode(string $url): string
    {
        $this->validator->validate($url);

        $key = $this->generateUniqueCode();
        $this->links[$key] = $url;
        $this->saveLinks();
        return $key;
    }

    protected function generateUniqueCode(string $possible = '0123456789abcdefghijkmnopqrtvwxyz'): string
    {
        $count = 0;

        do {
            if ($count > 50) {
                $this->length++;
                $count = 0;
            }

            $key = '';
            $maxlength = strlen($possible);
            $i = 0;

            while ($i < $this->length) {
                $char = substr($possible, mt_rand(0, $maxlength - 1), 1);
                $key .= $char;
                $i++;
            }

            $count++;
        } while (array_key_exists($key, $this->links));

        return $key;
    }
}
