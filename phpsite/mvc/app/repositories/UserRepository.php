<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Database\Database;
use Exception;

class UserRepository implements DataRepositoryInterface {
    private Database $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getAll(): array {
        return $this->db->query("SELECT * FROM users");
    }

    public function getById(int $id): array {
        $result = $this->db->query("SELECT * FROM users WHERE id = ?", [$id]);
        return $result ?: [];
    }

    public function create(array $data): void {
        $required = ['id', 'name', 'email', 'password'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                throw new \InvalidArgumentException("Missing required field: $field");
            }
        }

        $this->db->query(
            "INSERT INTO users (id, name, email, password) VALUES (?, ?, ?, ?)",
            [$data['id'], $data['name'], $data['email'], password_hash($data['password'], PASSWORD_BCRYPT)]
        );
    }

    public function update(int $id, array $data): void {
        if (empty($data)) {
            throw new \InvalidArgumentException("No data provided for update");
        }

        $this->db->query(
            "UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?",
            [$data['name'], $data['email'], password_hash($data['password'], PASSWORD_BCRYPT), $id]
        );
    }

    public function delete(int $id): void {
        $this->db->query("DELETE FROM users WHERE id = ?", [$id]);
    }

    public function getByEmail(string $email): ?array {
        $result = $this->db->query("SELECT * FROM users WHERE email = ?", [$email]);
        return $result[0] ?? null;
    }
}