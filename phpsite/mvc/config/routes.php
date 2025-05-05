<?php
declare(strict_types=1);

use App\Middlewares\JWTMiddleware;
use App\Requests\Request;
use App\Responses\Response;

return function ($controller, JWTMiddleware $jwt) {
    $authHandler = function (Request $req, callable $handler) use ($jwt) {
        try {
            $jwt->validateToken($req);
            return $handler();
        } catch (Exception $e) {
            return new Response(401, ['error' => $e->getMessage()]);
        }
    };

    return [
        ['method' => 'POST', 'path' => '/login', 'handler' => fn() => $controller->login()],
        
        ['method' => 'GET', 'path' => '/students', 
         'handler' => fn() => $authHandler($GLOBALS['request'], fn() => $controller->getAllStudent())],
         
        ['method' => 'GET', 'path' => '/students/{id}', 
         'handler' => fn($id) => $authHandler($GLOBALS['request'], fn() => $controller->getStudentById($id))],
         
        ['method' => 'POST', 'path' => '/students',
         'handler' => fn() => $authHandler($GLOBALS['request'], fn() => $controller->createStudent())],
         
        ['method' => 'PUT', 'path' => '/students/{id}',
         'handler' => fn($id) => $authHandler($GLOBALS['request'], fn() => $controller->updateStudent($id))],
         
        ['method' => 'DELETE', 'path' => '/students/{id}',
         'handler' => fn($id) => $authHandler($GLOBALS['request'], fn() => $controller->deleteStudent($id))]
    ];
};