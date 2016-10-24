<?php

require 'vendor/autoload.php';

use Carbon\Carbon;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$log = new Logger('Test log');
$log->pushHandler(new StreamHandler('test.log', Logger::WARNING));
$log->addRecord(Logger::INFO, 'Hello world');

$now = sprintf("Now: %s", Carbon::now());

$routes = [
    'hello_route' => new Route('/hello', ['result' => 'Hello route']),
    'bye_route'   => new Route('/bye', ['result' => 'Bye route']),
    'index_route' => new Route('/', ['result' => 'Index route']),
];

$routeCollection = new RouteCollection();

foreach ($routes as $routeName => $route) {
    $routeCollection->add($routeName, $route);
}

$context = new RequestContext();
$matcher = new UrlMatcher($routeCollection, $context);

$pathInfo = $_SERVER['PATH_INFO'];

try {
    $parameters = $matcher->match($pathInfo);

    echo "{$now}, route: {$parameters['_route']}, result: {$parameters['result']}";
} catch (ResourceNotFoundException $e) {
    echo 'No route found';
}
