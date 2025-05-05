<?php
require_once 'autoload.php';

use University\School;
use University\Discipline;
use University\ClassSchedule;
use University\Person;
use University\Student;
use University\Teacher;

$school = new School("University of San Jose - Recoletos");

$schedule1 = new ClassSchedule("1", "ITELEC1A", "10:00am", "11:30am", "001");
$schedule2 = new ClassSchedule("2", "ITELEC1A", "8:30am", "10:00am", "002");

$teacher1 = new Teacher("Gregg", "Gabison", "Dr.");
$teacher2 = new Teacher("Gregg", "Mahilum", "Ms.");
$teacher3 = new Teacher("Roderick", "Bandalan", "Mr.");

$schedule1->addTeacher($teacher1);
$schedule1->addTeacher($teacher2);
$schedule2->addTeacher($teacher3);

$students1 = [
    new Student("Clint", "Abastas", "S001"),
    new Student("James", "Bunac", "5002"),
    new Student("Eugene", "Cabatingan", "5003"),
    new Student("Jullene Jane", "Evangelista", "5004"),
    new Student("Jeoffrey", "Gudio", "5005"),
    new Student("Richard", "Moreno", "5006"),
    new Student("Jeffrey", "Rebutazo", "5007"),
    new Student("Roy", "Salares", "5008")
];

$students2 = [
    new Student("Resty", "Arriaga", "S009"),  
    new Student("Donnah Marizh", "Chan", "5010"),
    new Student("Mikee", "Libato", "5011"),
    new Student("John", "Pagador", "5012"),
    new Student("Justine", "Panorel", "5013"),
    new Student("Jerald", "Patalinghug", "5014"), 
    new Student("Pach", "Valenzona", "5015")
];

foreach ($students1 as $student) {
    $schedule1->addStudent($student);
}

foreach ($students2 as $student) {
    $schedule2->addStudent($student);
}

$school->display();
$schedule1->display();
$schedule2->display();