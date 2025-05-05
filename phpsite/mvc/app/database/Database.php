<?php
declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOException;
use RuntimeException;

class Database {
    private PDO $connection;

    public function __construct(
        string $dsn,
        string $username,
        string $password,
        array $options = []
    ) {
        $defaultOptions = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES => false
        ];

        try {
            $this->connection = new PDO(
                $dsn,
                $username,
                $password,
                array_replace($defaultOptions, $options)
            );
        } catch (PDOException $e) {
            throw new RuntimeException(
                "Database connection failed: " . $e->getMessage(),
                $e->getCode()
            );
        }
    }

    public function query(string $sql, array $params = []): array {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function execute(string $sql, array $params = []): int {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    public function lastInsertId(): string {
        return $this->connection->lastInsertId();
    }

    public function beginTransaction(): bool {
        return $this->connection->beginTransaction();
    }

    public function commit(): bool {
        return $this->connection->commit();
    }

    public function rollBack(): bool {
        return $this->connection->rollBack();
    }
}