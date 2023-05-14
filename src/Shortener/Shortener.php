<?php

namespace Tmolbik\UrlConverter\Shortener;

use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use RandomLib\Factory;
use SecurityLib\Strength;
use Tmolbik\UrlConverter\DataStorage\DataStorageInterface;

class Shortener implements UrlDecoderInterface, UrlEncoderInterface
{
    public function __construct(
        protected DataStorageInterface      $dataStorage,
        protected LoggerInterface           $logger,
        protected UrlValidatorInterface     $validator,
        protected int                       $length = 6,
        protected string                    $possible = '0123456789abcdefghijkmnopqrtvwxyz',
    )
    {
    }

    public function decode(string $code): string
    {
        $url = $this->dataStorage->getByKey($code); 

        if (!$url) {
            $this->logger->warning('Don\'t find the code ' . $code);
            throw new InvalidArgumentException('Don\'t find the code ' . $code . PHP_EOL);
        }

        return $url;
    }

    public function encode(string $url): string
    {
        $this->validator->validate($url);

        $key = $this->dataStorage->getByLink($url); 
        
        if (!$key) {
            $key = $this->generateUniqueCode();;
            $this->dataStorage->save($key, $url);
            $this->logger->info('New encode ' . $url . ' as ' . $key);
        }

        return $key;
    }

    protected function generateUniqueCode(): string
    {
        $factory = new Factory();
        $generator = $factory->getGenerator(new Strength());
        return $generator->generateString($this->length, $this->possible);
    }
}
