<?php

require_once 'init2.php';

$db = new DBORM('mysql:host=localhost;dbname=orm', 'root', 'root');


/*
// Insert data into the students table
 $result = $db->table('students')->insert([
    'studlname' => 'Gudio',   
    'studmname' => 'Camocamo', 
    'studfname' => 'Jeoffrey', 
    'Course' => 'BSIT',       
    'Year' => 4,              
    'studcollege' => 'SCS' 
]);

$result = $db->table('students')->insert([
    'studlname' => 'Bandalan',   
    'studmname' => 'A', 
    'studfname' => 'Roderick', 
    'Course' => 'BSIT',       
    'Year' => 4,              
    'studcollege' => 'SCS' 
]);


$result = $db->table('students')->insert([
    'studlname' => 'Bandalan',   
    'studmname' => 'A', 
    'studfname' => 'Roderick', 
    'Course' => 'BSIT',       
    'Year' => 4,              
    'studcollege' => 'SBM' 
]);

*/

/*
// Get all rows from the students table
$allStudents = $db->select()->from('students')->getAll(); 
echo "Select All Query: " . $db->showQuery() . "\n";
echo "All Students: \n";
print_r($allStudents); // Prints all student records

*/


/* 
// Get rows where `studcollege` is 'SCS'
$studentsWithSCS = $db->select()->from('students')->where('studcollege', 'SCS')->getAll();
echo "Select with Criteria Query: " . $db->showQuery() . "\n";
echo "Students with College 'SCS': \n";
print_r($studentsWithSCS);

*/


/*
// Get a single row where `studfname` is 'Roderick'
$studentRoderick = $db->select()->from('students')->where('studfname', 'Roderick')->get(); 
echo "Select Single Row Query: " . $db->showQuery() . "\n";
echo "Student with First Name 'Roderick': \n";
print_r($studentRoderick);
*/

/*
// Sample update query
$updateResult = $db->table('students')->where('studlname', 'Gudio')->update(['studlname' => 'Godio']); 
echo "Update Query: " . $db->showQuery() . "\n";
echo "Update Result: " . $updateResult . "\n";

*/

/*

// Sample delete query
$deleteResult = $db->table('students')->where('studlname', 'Godio')->delete(); 
echo "Delete Query: " . $db->showQuery() . "\n";
echo "Delete Result: " . $deleteResult . "\n";
*/

?>
