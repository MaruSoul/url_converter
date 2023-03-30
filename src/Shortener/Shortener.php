<?php

namespace Tmolbik\PhpPro\Shortener;

use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use RandomLib\Factory;
use SecurityLib\Strength;
use Tmolbik\PhpPro\IFileRepository;

class Shortener implements IUrlDecoder, IUrlEncoder
{
    protected array $links;
    protected IUrlValidator $validator;

    public function __construct(
        protected IFileRepository $fileRepository,
        protected LoggerInterface $logger,
        protected int $length = 6,
        protected string $possible = '0123456789abcdefghijkmnopqrtvwxyz',
        IUrlValidator $validator = null,
    )
    {
        $this->validator = $validator ?? new UrlValidator($this->logger);
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
        $url = $this->links[$code] ?? '';

        if (!$url) {
            $this->logger->warning('Don\'t find the code ' . $code);
            throw new InvalidArgumentException('Don\'t find the code ' . $code . PHP_EOL);
        }

        return $url;
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
        $this->logger->info('New encode ' . $url . ' as ' . $key);
        return $key;
    }

    protected function generateUniqueCode(): string
    {
        $factory = new Factory();
        $generator = $factory->getGenerator(new Strength());
        return $generator->generateString($this->length, $this->possible);
    }
}
