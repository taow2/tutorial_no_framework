<?php declare(strict_types = 1);

namespace Example;

require __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);

$environment = 'development';

// register the error handler

$whoope = new \Whoops\Run;

if($environment !== 'production') {
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
}
else {
     $whoops->pushHandler(function($e) {
        echo 'Todo: friendly error page';
     });
}
$whoops->register();

throw new \Exception;
?>