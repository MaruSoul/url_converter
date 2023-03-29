<?php

namespace Tmolbik\PhpPro\Shortener;

interface IUrlValidator
{
    public function validate(string $url): bool;
}
