<?php
namespace App\Controllers;

use App\Repositories\DataRepositoryInterface;
use App\Requests\RequestInterface;
use App\Responses\Response;

class StudentController {
    private DataRepositoryInterface $studentRepository;
    private RequestInterface $request;

    public function __construct(
        DataRepositoryInterface $studentRepository,
        RequestInterface $request
    ) {
        $this->studentRepository = $studentRepository;
        $this->request = $request;
    }

    public function getAllStudent(): Response {
        try {
            $students = $this->studentRepository->getAll();
            return new Response(200, json_encode($students));
        } catch (\Exception $e) {
            return new Response(500, json_encode(['error' => $e->getMessage()]));
        }
    }

    public function getStudentById(int $id): Response {
        try {
            $student = $this->studentRepository->getById($id);
            if (empty($student)) {
                return new Response(404, json_encode(['error' => 'Student not found']));
            }
            return new Response(200, json_encode($student[0]));
        } catch (\Exception $e) {
            return new Response(500, json_encode(['error' => $e->getMessage()]));
        }
    }

    public function createStudent(): Response {
        try {
            $data = $this->request->getBody();
            $this->studentRepository->create($data);
            return new Response(201, json_encode(['message' => 'Student created']));
        } catch (\Exception $e) {
            return new Response(400, json_encode(['error' => $e->getMessage()]));
        }
    }

    public function updateStudent(int $id): Response {
        try {
            $data = $this->request->getBody();
            $this->studentRepository->update($id, $data);
            return new Response(200, json_encode(['message' => 'Student updated']));
        } catch (\Exception $e) {
            return new Response(400, json_encode(['error' => $e->getMessage()]));
        }
    }

    public function deleteStudent(int $id): Response {
        try {
            $this->studentRepository->delete($id);
            return new Response(204, json_encode(['message' => 'Student deleted']));
        } catch (\Exception $e) {
            return new Response(400, json_encode(['error' => $e->getMessage()]));
        }
    }
}
?>