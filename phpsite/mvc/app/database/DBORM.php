<?php
declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOException;
use RuntimeException;
use App\Repositories\DataRepositoryInterface;

class DBORM implements DataRepositoryInterface {
    private ?PDO $db;
    private string $sql = '';
    private int $whereCounter = 0;
    private array $valueBag = [];
    private string $table = '';

    public function __construct(
        string $dsn,
        string $username,
        string $password,
        array $options = []
    ) {
        try {
            $this->db = new PDO(
                $dsn,
                $username,
                $password,
                array_replace([
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ], $options)
            );
        } catch (PDOException $e) {
            throw new RuntimeException(
                "Database connection failed: " . $e->getMessage(),
                $e->getCode()
            );
        }
    }

    public function table(string $table): self {
        $this->table = $table;
        return $this;
    }

    public function select(array $fields = ['*']): self {
        $this->sql = 'SELECT ' . implode(', ', $fields);
        return $this;
    }

    public function where(
        string $field,
        $value,
        string $operator = '=',
        string $logical = 'AND'
    ): self {
        $this->validateFieldName($field);
        
        $prefix = $this->whereCounter > 0 ? " $logical " : " WHERE ";
        $this->sql .= $prefix . "$field $operator ?";
        $this->valueBag[] = $this->sanitizeValue($value);
        $this->whereCounter++;
        
        return $this;
    }

    public function orWhere(string $field, $value, string $operator = '='): self {
        return $this->where($field, $value, $operator, 'OR');
    }

    public function get(): array {
        $result = $this->prepareAndExecute()->fetch(PDO::FETCH_ASSOC);
        $this->reset();
        return $result ?: [];
    }

    public function getAll(): array {
        $this->sql .= ';';
        $result = $this->prepareAndExecute()->fetchAll(PDO::FETCH_ASSOC);
        $this->reset();
        return $result;
    }

    public function insert(array $data): int {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $this->sql = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";
        $this->valueBag = array_values($data);
        
        $count = $this->prepareAndExecute()->rowCount();
        $this->reset();
        return $count;
    }

    public function update(array $data): int {
        $set = implode(', ', array_map(fn($col) => "$col = ?", array_keys($data)));
        
        $this->sql = "UPDATE $this->table SET $set";
        $this->valueBag = array_values($data);
        
        $count = $this->prepareAndExecute()->rowCount();
        $this->reset();
        return $count;
    }

    public function delete(): int {
        if ($this->whereCounter === 0) {
            throw new RuntimeException('DELETE requires WHERE clause');
        }
        
        $this->sql = "DELETE FROM $this->table";
        $count = $this->prepareAndExecute()->rowCount();
        $this->reset();
        return $count;
    }

    private function prepareAndExecute(): \PDOStatement {
        $stmt = $this->db->prepare($this->sql);
        $stmt->execute($this->valueBag);
        return $stmt;
    }

    private function reset(): void {
        $this->sql = '';
        $this->valueBag = [];
        $this->whereCounter = 0;
    }

    private function validateFieldName(string $field): void {
        if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $field)) {
            throw new InvalidArgumentException("Invalid field name: $field");
        }
    }

    private function sanitizeValue($value) {
        return is_string($value) ? htmlspecialchars($value, ENT_QUOTES, 'UTF-8') : $value;
    }
}