<?php
spl_autoload_register(function($class){
    $file = $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    } else {
        throw new Exception("Class file $file not found.");
    }
});
?>