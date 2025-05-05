<?php
namespace University;

class Student extends Person {
    private $studentID;

    public function __construct($firstname, $lastname, $studentID) {
        parent::__construct($firstname, $lastname);
        $this->studentID = $studentID;
    }
}