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

$request = new \Http\HttpRequest($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
$response = new \Http\HttpResponse;

forEach($response->getHeaders() as $header) {
    // false here is to prevent other existing headers from being overwritten
    header($header, false);
}

$content = '<h1>Hello World</h1>';
$response->setContent($content);

echo $response->getContent();

?>