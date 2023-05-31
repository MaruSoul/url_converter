<?php

namespace Tmolbik\UrlConverter\Shortener;

use GuzzleHttp\ClientInterface;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;

class UrlValidator implements UrlValidatorInterface
{
    public function __construct(
        protected LoggerInterface $logger,
        protected ClientInterface $client,
        protected array $allowedResponseCode = [200],
    )
    {
    }

    public function validate(string $url): bool
    {
        $response = $this->client->request('HEAD', $url);
        $statusCode = $response->getStatusCode();
    
        if (!in_array($statusCode, $this->allowedResponseCode)) {
            throw new InvalidArgumentException('Unexpected response status' . PHP_EOL);    
        }

        return true;
    }
}
