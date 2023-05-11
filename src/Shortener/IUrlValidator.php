<?php

namespace Tmolbik\UrlConverter\Shortener;

interface IUrlValidator
{
    public function validate(string $url): bool;
}
