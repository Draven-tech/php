<?php
declare(strict_types=1);

namespace App\Middlewares;

use App\Requests\RequestInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use InvalidArgumentException;
use RuntimeException;
use Exception;

class JWTMiddleware {
    private string $secretKey;
    private string $algorithm;

    public function __construct(
        string $secretKey,
        string $algorithm = 'HS256'
    ) {
        if (empty($secretKey)) {
            throw new InvalidArgumentException('JWT secret key cannot be empty');
        }

        $this->secretKey = $secretKey;
        $this->algorithm = $algorithm;
    }

    public function validateToken(RequestInterface $request): array {
        $token = $this->extractTokenFromRequest($request);
        
        try {
            $decoded = JWT::decode(
                $token,
                new Key($this->secretKey, $this->algorithm)
            );
            
            return (array) $decoded;
        } catch (Exception $e) {
            throw new RuntimeException(
                'Token validation failed: ' . $e->getMessage(),
                401,
                $e
            );
        }
    }

    private function extractTokenFromRequest(RequestInterface $request): string {
        $header = $request->getHeader('Authorization') ?? '';
        
        if (!preg_match('/Bearer\s(?P<token>\S+)/', $header, $matches)) {
            throw new RuntimeException('Authorization token not found', 401);
        }

        return $matches['token'];
    }

    public function createToken(array $payload, ?int $expiry = null): string {
        $defaultPayload = [
            'iat' => time(),
            'exp' => $expiry ?? time() + 3600, // Default 1 hour expiry
            'iss' => $_ENV['JWT_ISSUER'] ?? 'your-app-name'
        ];

        return JWT::encode(
            array_merge($defaultPayload, $payload),
            $this->secretKey,
            $this->algorithm
        );
    }
}