<?php
declare(strict_types=1);

namespace App\Router;

class RouteMatcher {
    public function match(array $routes, string $requestMethod, string $requestPath): ?array {
        foreach ($routes as $route) {
            // Convert route path to regex pattern
            $pattern = $this->convertPathToPattern($route['path']);
            
            if ($route['method'] === $requestMethod && 
                preg_match($pattern, $requestPath, $matches)) {
                return [
                    'handler' => $route['handler'],
                    'params' => $this->filterMatches($matches)
                ];
            }
        }
        return null;
    }

    private function convertPathToPattern(string $path): string {
        return '@^' . preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $path) . '$@D';
    }

    private function filterMatches(array $matches): array {
        return array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
    }
}