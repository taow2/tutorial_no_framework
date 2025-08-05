<?php declare(strict_types = 1);

namespace Example;

require __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);

$environment = 'development';

// register the error handler

$whoops = new \Whoops\Run;

if($environment !== 'production') {
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
}
else {
     $whoops->pushHandler(function($e) {
        echo 'Todo: friendly error page';
     });
}
$whoops->register();

// throw new \Exception;

$request = new \Http\HttpRequest($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
$response = new \Http\HttpResponse;

forEach($response->getHeaders() as $header) {
    // false here is to prevent other existing headers from being overwritten
    header($header, false);
}

$content = '<h1>Hello World</h1>';

// $dispatcher = \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $r) {
//     $r->addRoute('GET', '/hello-world', function () {
//         echo 'Hello World';
//     });
//     $r->addRoute('GET', '/another-route', function () {
//         echo 'This works too';
//     });
// });

// $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPath());
// switch ($routeInfo[0]) {
//     case \FastRoute\Dispatcher::NOT_FOUND:
//         $response->setContent('404 - Page not found');
//         $response->setStatusCode(404);
//         break;
//     case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
//         $response->setContent('405 - Method not allowed');
//         $response->setStatusCode(405);
//         break;
//     case \FastRoute\Dispatcher::FOUND:
//         $handler = $routeInfo[1];
//         $vars = $routeInfo[2];
//         call_user_func($handler, $vars);
//         break;
// }

$routeDefinitionCallback = function (\FastRoute\RouteCollector $r) {
    $routes = include('Routes.php');
    foreach ($routes as $route) {
        $r->addRoute($route[0], $route[1], $route[2]);
    }
};

$dispatcher = \FastRoute\simpleDispatcher($routeDefinitionCallback);

$response->setContent($content);

echo $response->getContent();

?>