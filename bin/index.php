<?php

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Tmolbik\PhpPro\FileRepository;
use Tmolbik\PhpPro\Shortener\Shortener;

require_once(__DIR__ . '/../vendor/autoload.php');

// Create the logger
$logger = new Logger('my_logger');

// Now add some handlers
$logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/my_app_info.log', Level::Info));
$logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/my_app_warning.log', Level::Warning));

$fileRepository = new FileRepository(__DIR__ . '/../data/links.json');

$url = 'https://www.youtube.com';
$shortener = new Shortener($fileRepository, $logger);
try {
    $code = $shortener->encode($url);
    var_dump($code);

    $url2 = $shortener->decode($code);
    var_dump($url2);
    var_dump($url === $url2);

    // get notice log
    $shortener->decode('nbdjbqwdjkw');
} catch (Throwable $th) {
    echo $th->getMessage();
}

try {
    // get warning log
    var_dump($shortener->encode('iygigo'));
} catch (Throwable $th) {
    echo $th->getMessage();
}

try {
    // get warning log
    var_dump($shortener->encode('http://www.google.com.ua/gtfhjggjfgjgf'));
} catch (Throwable $th) {
    echo $th->getMessage();
}
echo PHP_EOL;
