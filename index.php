<?php

session_start();

// Front Controller - Handle all request, route to action controllers and return the response
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__.'/vendor/autoload.php';

//Enable the default time zone
date_default_timezone_set("Europe/London");
define('SITE_PATH',realpath(dirname(__FILE__)).'/');

$controller = new Test\StarWars\Controller\DefaultController();
$request = Request::createFromGlobals();
$uri = $request->getPathInfo();

if('/' === $uri) {
    $response = $controller->indexAction($request);
} elseif ('/hit' === $uri) {
    $response = $controller->hitAction($request);
} else {
    header('HTTP/1.1 404 Not Found');
    $response = '<html><body><h1>Page Not Found</h1></body></html>';
}

echo $response;