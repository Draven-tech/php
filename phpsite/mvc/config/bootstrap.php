<?php
declare(strict_types=1);

// 1. Composer Autoloader
require_once __DIR__.'/../vendor/autoload.php';

// 2. Environment Setup
try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/..');
    $dotenv->load();
    $dotenv->required(['DB_DSN', 'DB_USER', 'JWT_SECRET'])->notEmpty();
} catch (Exception $e) {
    header('Content-Type: application/json');
    exit(json_encode(['error' => 'Config error: '.$e->getMessage()]));
}

// 3. Application Settings
define('APP_DEBUG', $_ENV['APP_DEBUG'] ?? false);

// 4. Error Handling
ini_set('display_errors', APP_DEBUG ? '1' : '0');
error_reporting(APP_DEBUG ? E_ALL : E_ERROR);

// 5. Timezone
date_default_timezone_set($_ENV['TIMEZONE'] ?? 'UTC');

// 6. Autoloader
spl_autoload_register(function ($class) {
    $file = __DIR__.'/../'.str_replace('\\', '/', $class).'.php';
    if (file_exists($file)) require $file;
});

// 7. Initialize Dependencies
try {
    $db = require __DIR__.'/orm.php';
    $router = require __DIR__.'/routes.php';
    $GLOBALS['router'] = $router;
} catch (Exception $e) {
    http_response_code(500);
    exit(APP_DEBUG ? $e->getMessage() : 'System error');
}