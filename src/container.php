<?php

use Container\Container;
use Monolog\Handler\StreamHandler;
use Monolog\{Level, Logger};
use Psr\Log\LoggerInterface;
use Tmolbik\UrlConverter\DataStorage\{DatabaseStorage, DataStorageInterface};
use Tmolbik\UrlConverter\Models\Database;
use Tmolbik\UrlConverter\Shortener\{Shortener, UrlValidator, UrlValidatorInterface};

$container = new Container();

$container->add(DataStorageInterface::class, 
    fn() => new DatabaseStorage()
);

$container->add(LoggerInterface::class, 
    fn() => new Logger('url_converter', [
        new StreamHandler(__DIR__ . '/../logs/my_app_info.log', Level::Info),
        new StreamHandler(__DIR__ . '/../logs/my_app_warning.log', Level::Warning)
    ])
);


$container->add(UrlValidatorInterface::class, 
    fn() => new UrlValidator(
        $container->get(LoggerInterface::class)
    ),
);

$container->add(Database::class, 
    fn() => new Database()
);

$container->add(Shortener::class,
    fn() => new Shortener(
        $container->get(DataStorageInterface::class),
        $container->get(LoggerInterface::class),
        $container->get(UrlValidatorInterface::class),
    )
);
