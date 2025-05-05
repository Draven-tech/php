<?php
declare(strict_types=1);

namespace App\Requests;

interface RequestInterface {
    public function getMethod(): string;
    public function getPath(): string;
    public function getBody(): array;
    public function getHeader(string $name): ?string;
    public function getHeaders(): array;
}