<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Database\DBORM;
use Exception;

class StudentRepository implements DataRepositoryInterface {
    private DBORM $db;

    public function __construct(DBORM $db) {
        $this->db = $db;
    }

    public function getAll(): array {
        return $this->db->table('students')->getAll();
    }

    public function getById(int $id): array {
        $result = $this->db->table('students')->where('studID', $id)->get();
        return $result ?: [];
    }

    public function create(array $data): void {
        $required = ['studid', 'studlname', 'studfname', 'Course', 'Year', 'studcollege'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                throw new \InvalidArgumentException("Missing required field: $field");
            }
        }

        $this->db->table('students')->insert([
            'studid' => $data['studid'],
            'studlname' => $data['studlname'],
            'studmname' => $data['studmname'] ?? null,
            'studfname' => $data['studfname'],
            'Course' => $data['Course'],
            'Year' => $data['Year'],
            'studcollege' => $data['studcollege']
        ]);
    }

    public function update(int $id, array $data): void {
        if (empty($data)) {
            throw new \InvalidArgumentException("No data provided for update");
        }

        $this->db->table('students')
            ->where('studID', $id)
            ->update($data);
    }

    public function delete(int $id): void {
        $this->db->table('students')
            ->where('studID', $id)
            ->delete();
    }
}