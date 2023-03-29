<?php

use Tmolbik\PhpPro\Shortener\Shortener;

require_once(__DIR__ . '/../vendor/autoload.php');

try {
    $url = 'https://www.php.net';
    $shortener = new Shortener(__DIR__ . '/../data/links.json', 3);
    $code = $shortener->encode($url);
    var_dump($code);

    $url2 = $shortener->decode($code);
    var_dump($url2);
    var_dump($url === $url2);

    var_dump($shortener->encode('iygigo'));
} catch (Throwable $th) {
    echo $th->getMessage();
}

echo(PHP_EOL);
