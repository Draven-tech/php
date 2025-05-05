<?php
namespace App\Controllers;

use App\Middlewares\JWTMiddleware;
use App\Repositories\DataRepositoryInterface;
use App\Requests\RequestInterface;
use App\Responses\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class UserController {
    private DataRepositoryInterface $userRepository;
    private RequestInterface $request;
    private JWTMiddleware $jwtMiddleware;

    public function __construct(
        DataRepositoryInterface $userRepository,
        RequestInterface $request,
        JWTMiddleware $jwtMiddleware
    ) {
        $this->userRepository = $userRepository;
        $this->request = $request;
        $this->jwtMiddleware = $jwtMiddleware;
    }

    public function getAllUsers(): Response {
        try {
            $users = $this->userRepository->getAll();
            return new Response(200, json_encode($users));
        } catch (Exception $e) {
            return new Response(500, json_encode(['error' => $e->getMessage()]));
        }
    }

    public function getUserById(int $id): Response {
        try {
            $user = $this->userRepository->getById($id);
            if (empty($user)) {
                return new Response(404, json_encode(['error' => 'User not found']));
            }
            return new Response(200, json_encode($user[0]));
        } catch (Exception $e) {
            return new Response(500, json_encode(['error' => $e->getMessage()]));
        }
    }

    public function createUser(): Response {
        try {
            $data = $this->request->getBody();
            $this->userRepository->create($data);
            return new Response(201, json_encode(['message' => 'User created']));
        } catch (Exception $e) {
            return new Response(400, json_encode(['error' => $e->getMessage()]));
        }
    }

    public function updateUser(int $id): Response {
        try {
            $data = $this->request->getBody();
            $this->userRepository->update($id, $data);
            return new Response(200, json_encode(['message' => 'User updated']));
        } catch (Exception $e) {
            return new Response(400, json_encode(['error' => $e->getMessage()]));
        }
    }

    public function deleteUser(int $id): Response {
        try {
            $this->userRepository->delete($id);
            return new Response(204, json_encode(['message' => 'User deleted']));
        } catch (Exception $e) {
            return new Response(400, json_encode(['error' => $e->getMessage()]));
        }
    }

    public function login(): Response {
        try {
            $data = $this->request->getBody();
            $email = $data['email'] ?? null;
            $password = $data['password'] ?? null;

            if (!$email || !$password) {
                return new Response(400, json_encode(['error' => 'Email and password required']));
            }

            $user = $this->userRepository->getByEmail($email);
            if (!$user || !password_verify($password, $user['password'])) {
                return new Response(401, json_encode(['error' => 'Invalid credentials']));
            }

            $payload = [
                'iss' => $_ENV['JWT_ISSUER'] ?? 'your-domain.com',
                'sub' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'iat' => time(),
                'exp' => time() + (int)($_ENV['JWT_EXPIRY'] ?? 3600)
            ];

            $jwt = JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');
            return new Response(200, json_encode(['token' => $jwt]));
        } catch (Exception $e) {
            return new Response(500, json_encode(['error' => $e->getMessage()]));
        }
    }

    public function validateRequest(RequestInterface $request): array {
        try {
            return $this->jwtMiddleware->validateToken($request);
        } catch (Exception $e) {
            return ['error' => $e->getMessage(), 'code' => $e->getCode()];
        }
    }
}
?>