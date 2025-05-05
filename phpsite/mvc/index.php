<?php
declare(strict_types=1);

require __DIR__ . '/config/bootstrap.php';

// Initialize dependencies
$db = require __DIR__ . '/config/orm.php';
$request = new App\Requests\Request();

// Setup controller
$studentRepository = new App\Repositories\StudentRepository($db);
$controller = new App\Controllers\StudentController($studentRepository, $request);

// Initialize JWT middleware
$jwtMiddleware = new App\Middlewares\JWTMiddleware($_ENV['JWT_SECRET']);

// Load and register routes
$routes = (require __DIR__ . '/config/routes.php')($controller, $jwtMiddleware);
$router = new App\Router\Router($request, new App\Router\RouteMatcher());

foreach ($routes as $route) {
    $router->addRoute($route['method'], $route['path'], $route['handler']);
}

// Handle the request
$response = $router->dispatch();

// Send response
http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $name => $value) {
    header("$name: $value");
}
echo $response->getBody();