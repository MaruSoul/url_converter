<?php

namespace Tmolbik\PhpPro\Shortener;

use DateTime;
use InvalidArgumentException;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Tmolbik\PhpPro\IFileRepository;

class Shortener implements IUrlDecoder, IUrlEncoder
{
    protected array $links;
    public function __construct(
        protected IFileRepository $fileRepository,
        protected int $length,
        protected LoggerInterface $logger,
        protected IUrlValidator $validator = new UrlValidator(),
    )
    {
        $this->links = $this->fileRepository->getData();
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function setLength(int $length): void
    {
        $this->length = $length;
    }

    public function decode(string $code): string
    {
        return $this->links[$code] ?? throw new InvalidArgumentException('Don\'t find the code');
    }

    public function encode(string $url): string
    {
        // the array contains the url?
        $key = array_search($url, $this->links);
        if (!$key) {
            $key = $this->encodeAnyway($url);
        }

        return $key;
    }

    public function encodeAnyway(string $url): string
    {
        $this->validator->validate($url);

        $key = $this->generateUniqueCode();
        $this->links[$key] = $url;
        $this->fileRepository->save($this->links);
        $this->logger->info('New encode ' . $url . ' as ' . $key . PHP_EOL);
        return $key;
    }

    protected function generateUniqueCode(string $possible = '0123456789abcdefghijkmnopqrtvwxyz'): string
    {
        $date = new DateTime();
        $str = $possible . mb_strtoupper($possible) . $date->getTimestamp();

        return substr(str_shuffle($str), 0, $this->length);
    }
}
