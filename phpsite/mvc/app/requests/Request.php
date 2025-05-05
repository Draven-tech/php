<?php
declare(strict_types=1);

namespace App\Requests;

class Request implements RequestInterface {
    private array $headers;
    private array $body;
    private string $method;
    private string $path;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->path = $this->parsePath($_SERVER['REQUEST_URI'] ?? '/');
        $this->headers = $this->parseHeaders();
        $this->body = $this->parseBody();
    }

    public function getMethod(): string {
        return $this->method;
    }

    public function getPath(): string {
        return $this->path;
    }

    public function getBody(): array {
        return $this->body;
    }

    public function getHeader(string $name): ?string {
        return $this->headers[$name] ?? null;
    }

    public function getHeaders(): array {
        return $this->headers;
    }

    private function parsePath(string $uri): string {
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';
        return rtrim(str_replace('//', '/', $path), '/');
    }

    private function parseHeaders(): array {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (!str_starts_with($key, 'HTTP_')) {
                continue;
            }
            
            $headerKey = substr($key, 5); // Remove 'HTTP_'
            $headerKey = strtolower($headerKey);
            $headerKey = str_replace('_', ' ', $headerKey);
            $headerKey = ucwords($headerKey);
            $headerKey = str_replace(' ', '-', $headerKey);
            
            $headers[$headerKey] = $value;
        }
        return $headers;
    }

    private function parseBody(): array {
        if ($this->method === 'GET') {
            return $_GET;
        }

        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        $rawBody = file_get_contents('php://input');

        if (str_contains($contentType, 'application/json')) {
            return json_decode($rawBody, true) ?? [];
        }

        return $_POST;
    }
}