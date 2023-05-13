<?php

namespace Tmolbik\UrlConverter\Shortener;

use InvalidArgumentException;

interface UrlEncoderInterface
{
    /**
     * @param string $url
     * @throws InvalidArgumentException
     * @return string
     */
    public function encode(string $url): string;
}
