<?php

use App\Http\Action;
use App\Http\Middleware;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Pipeline\Pipeline;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization

$params = [
    'users' => ['admin' => 'password'],
];

$aura = new Aura\Router\RouterContainer();
$routes = $aura->getMap();

$routes->get('home', '/', Action\HelloAction::class);
$routes->get('about', '/about', Action\AboutAction::class);
$routes->get('blog', '/blog', Action\Blog\IndexAction::class);
$routes->get('blog_show', '/blog/{id}', Action\Blog\ShowAction::class)->tokens(['id' => '\d+']);
$routes->get('cabinet', '/cabinet', [
    new Middleware\BasicAuthMiddleware($params['users']),
    Action\CabinetAction::class,
]);

$router = new AuraRouterAdapter($aura);
$resolver = new MiddlewareResolver();
$pipeline = new Pipeline();

$pipeline->pipe($resolver->resolve(Middleware\ProfilerMiddleware::class));
### Running

$request = ServerRequestFactory::fromGlobals();
try {
    $result = $router->match($request);
    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }
    $handler = $result->getHandler();
    $pipeline->pipe($resolver->resolve($handler));
} catch (RequestNotMatchedException $e) {}

$response = $pipeline($request, new Middleware\NotFoundHandler());

### Postprocessing

$response = $response->withHeader('X-Developer', 'Sergo8ck');

### Sending

$emitter = new SapiEmitter();
$emitter->emit($response);