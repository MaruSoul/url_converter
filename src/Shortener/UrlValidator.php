<?php

namespace Tmolbik\UrlConverter\Shortener;

use GuzzleHttp\Client;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;

class UrlValidator implements UrlValidatorInterface
{
    public function __construct(
        protected LoggerInterface $logger,
        protected array $allowedResponseCode = [200],
    )
    {
    }

    public function validate(string $url): bool
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $this->logger->warning('Link ' . $url . ' is invalid');
            throw new InvalidArgumentException('Link ' . $url . ' is invalid' . PHP_EOL);
        }

        $context = stream_context_create(['http' => ['ignore_errors' => true]]);
        $result = file_get_contents($url, false, $context);

        $status_line = $http_response_header[0];

        preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);

        $status = $match[1];

        if (!in_array($status, $this->allowedResponseCode)) {
            $this->logger->warning('Unexpected response status: ' . $status);
            throw new InvalidArgumentException('Unexpected response status: ' . $status . PHP_EOL);
        }

        return true;
    }
}
