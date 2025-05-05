<?php
namespace University;

class Discipline {
    private $CourseNo;
    private $CourseName;

    public function __construct($CourseNo, $CourseName) {
        $this->CourseNo = $CourseNo;
        $this->CourseName = $CourseName;
    }

    public function getCourseNo() {
        return $this->CourseNo;
    }

    public function getCourseName() {
        return $this->CourseName;
    }
}