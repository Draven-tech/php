<?php
declare(strict_types=1);

use App\Database\DBORM;

return new DBORM(
    $_ENV['DB_DSN'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'],
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);