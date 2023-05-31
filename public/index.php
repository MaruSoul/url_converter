<?php

use Tmolbik\UrlConverter\Models\Database;
use Tmolbik\UrlConverter\Shortener\Shortener;

header('Content-Type: text/plain');
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../src/container.php');

/** @var Container\Container $container */
try {
    $database = $container->get(Database::class);
    $shortener = $container->get(Shortener::class);
} catch (\Throwable $e) {
    die($e->getMessage());
}

echo 'Аби спробувати, перейдить наприклад за посиланням:  http://localhost:7003?url=https://www.defense.gov, або http://localhost:7003?key=value', PHP_EOL;


echo 'Результат:', PHP_EOL;

try {
    if (!empty($_GET['url'])) {
        $result = [];
        $value = $_GET['url'];
        $key = $shortener->encode($_GET['url']);
        echo 'Дані згідно url', PHP_EOL;
        echo $key, ': ', $value;
        echo PHP_EOL;
    } 
    
    if (!empty($_GET['key'])) {
        $result = [];
        $key = $_GET['key'];
        $value = $shortener->decode($_GET['key']);
        echo 'Дані згідно key', PHP_EOL;
        echo $key, ': ', $value;
    } 
} catch (\Throwable $th) {
    die($th->getMessage());
}
