<?php
declare(strict_types=1);

namespace App\Responses;

class Response {
    private int $statusCode;
    private $body;
    private array $headers;

    public function __construct(
        int $statusCode,  // No default value here
        $body = '',      // No type hint for $body
        array $headers = []
    ) {
        $this->statusCode = $statusCode;
        $this->body = $body;
        $this->headers = array_merge([
            'Content-Type' => 'application/json'
        ], $headers);
    }

    public function getStatusCode(): int {
        return $this->statusCode;
    }

    public function getBody() {  // No return type for maximum compatibility
        return $this->body;
    }

    public function getHeaders(): array {
        return $this->headers;
    }
}