<?php
namespace University;

class School {
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function display() {
        echo "{$this->name}<br>";
    }
}