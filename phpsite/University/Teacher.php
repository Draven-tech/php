<?php
namespace University;

class Teacher extends Person {
    private $title;

    public function __construct($firstname, $lastname, $title) {
        parent::__construct($firstname, $lastname);
        $this->title = $title;
    }

    public function getTitle() {
        return $this->title;
    }
}