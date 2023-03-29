<?php

namespace Tmolbik\PhpPro\Shortener;

use InvalidArgumentException;

class UrlValidator implements IUrlValidator
{
    public function __construct(
        protected array $allowedResponseCode = [200],
    )
    {
    }

    public function validate(string $url): bool
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException("Link is invalid");
        }

        $context = stream_context_create(['http' => ['ignore_errors' => true]]);
        $result = file_get_contents($url, false, $context);

        $status_line = $http_response_header[0];

        preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);

        $status = $match[1];

        if (!in_array($status, $this->allowedResponseCode)) {
            throw new InvalidArgumentException("unexpected response status: {$status_line}");
        }

        return true;
    }
}
