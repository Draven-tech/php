<?php
declare(strict_types=1);

namespace App\Router;

use App\Requests\RequestInterface;
use App\Responses\Response;

class Router {
    private RequestInterface $request;
    private RouteMatcher $routeMatcher;
    private array $routes = [];

    public function __construct(RequestInterface $request, RouteMatcher $routeMatcher) {
        $this->request = $request;
        $this->routeMatcher = $routeMatcher;
    }

    public function addRoute(string $method, string $path, callable $handler): void {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch(): Response {
        $match = $this->routeMatcher->match(
            $this->routes,
            $this->request->getMethod(),
            $this->request->getPath()
        );

        if (!$match) {
            return new Response(404, ['error' => 'Not Found']);
        }

        try {
            return call_user_func_array($match['handler'], $match['params']);
        } catch (\Throwable $e) {
            return new Response(500, ['error' => $e->getMessage()]);
        }
    }
}