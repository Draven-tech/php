<?php
namespace University;

class Person {
    private $firstname;
    private $lastname;

    public function __construct($firstname, $lastname) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    public function getFullName() {
        return "{$this->lastname}, {$this->firstname}";
    }
}