<?php
require_once 'C:/Users/jEsrA/Desktop/USJR/phpsite/ORM/DBORM.php';

// Define JWT secret (replace with your actual secret)
define('JWT_SECRET', 'your_secure_random_key_here');

// Autoload classes
spl_autoload_register(function ($class) {
    require_once __DIR__.'/classes/'.$class.'.php';
});
?>