<?php
namespace University;

class ClassSchedule extends Discipline {
    private $timeStart;
    private $timeEnd;
    private $scheduleID;
    private $students = [];
    private $teachers = [];

    public function __construct($CourseNo, $CourseName, $timeStart, $timeEnd, $scheduleID) {
        parent::__construct($CourseNo, $CourseName);
        $this->timeStart = $timeStart;
        $this->timeEnd = $timeEnd;
        $this->scheduleID = $scheduleID;
    }

    public function addTeacher(Teacher $teacher) {
        $this->teachers[] = $teacher;
    }

    public function addStudent(Student $student) {
        $this->students[] = $student;
    }

    public function display() {
        echo "<br>{$this->getCourseNo()} {$this->getCourseName()} {$this->timeStart} - {$this->timeEnd}<br>";
        echo "Teacher:<br>";
        foreach ($this->teachers as $teacher) {
            echo "{$teacher->getTitle()} {$teacher->getFullName()}<br>";
        }
        
        echo "<br>";
        foreach ($this->students as $student) {
            echo "{$student->getFullName()}<br>";
        }
    }
}