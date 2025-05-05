<?php
declare(strict_types=1);

interface iDBFuncs {
    public function select(?array $fieldList = null): object;
    public function table(string $table): object;
    public function from(string $table): object;
    public function get(): array;
    public function getAll(): array;
    public function where(string $field, $value, string $operator = '='): object;
    public function whereOr(string $field, $value, string $operator = '='): object;
    public function showQuery(): string;
    public function showValueBag(): array;
    public function insert(array $values): int;
    public function update(array $values): int;
    public function delete(): int;
}
?>