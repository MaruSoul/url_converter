<?php

use Container\Exceptions\EntityNotFoundException;
use Tmolbik\UrlConverter\Models\Database;
use Tmolbik\UrlConverter\Shortener\Shortener;

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../src/container.php');

/** @var Container\Container $container */
try {
    $database = $container->get(Database::class);
    $shortener = $container->get(Shortener::class);
} catch (EntityNotFoundException $e) {
    die($e->getMessage());
}

$url = 'https://www.youtube.com';
$url = 'https://www.linkedin.com';

try {
    $shortUrl = $shortener->encode($url);
    var_dump($shortUrl);

    $decodedUrl = $shortener->decode($shortUrl);
    var_dump($decodedUrl);
    var_dump($url === $decodedUrl);
} catch (Throwable $th) {
    echo $th->getMessage();
}

try {
    // get notice log: Don't find the code nbdjbqwdjkw
    $shortener->decode('nbdjbqwdjkw');
} catch (Throwable $th) {
    echo $th->getMessage();
}

try {
    // get warning log: Link iygigo is invalid
    var_dump($shortener->encode('iygigo'));
} catch (Throwable $th) {
    echo $th->getMessage();
}

try {
    // get warning log: Unexpected response status: 404
    var_dump($shortener->encode('http://www.google.com.ua/gtfhjggjfgjgf'));
} catch (Throwable $th) {
    echo $th->getMessage();
}
