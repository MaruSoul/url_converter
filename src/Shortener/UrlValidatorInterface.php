<?php

namespace Tmolbik\UrlConverter\Shortener;

interface UrlValidatorInterface
{
    public function validate(string $url): bool;
}
