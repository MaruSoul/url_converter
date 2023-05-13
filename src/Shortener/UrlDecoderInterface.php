<?php

namespace Tmolbik\UrlConverter\Shortener;

use InvalidArgumentException;

interface UrlDecoderInterface
{
    /**
     * @param string $code
     * @throws InvalidArgumentException
     * @return string
     */
    public function decode(string $code): string;
}
