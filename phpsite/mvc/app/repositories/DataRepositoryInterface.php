<?php
declare(strict_types=1);

namespace App\Repositories;

interface DataRepositoryInterface {
    public function getAll(): array;
    public function getById(int $id): array;
    public function create(array $data): void;
    public function update(int $id, array $data): void;
    public function delete(int $id): void;
}