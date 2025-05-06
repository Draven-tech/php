<?php
spl_autoload_register(function (string $className) {
    // Project namespace prefix (adjust if you use namespaces)
    $prefix = 'App\\';
    
    // Base directory for the namespace prefix
    $baseDir = _DIR_ . '/';
    
    // Does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $className, $len) !== 0) {
        return;
    }
    
    // Get the relative class name
    $relativeClass = substr($className, $len);
    
    // Replace namespace separators with directory separators
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    
    // If the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

/**
 * Legacy fallback for non-namespaced classes
 * (Remove this if all classes use namespaces)
 */
spl_autoload_register(function (string $className) {
    $directories = [
        _DIR_ . '/controllers/',
        _DIR_ . '/middlewares/',
        _DIR_ . '/requests/',
        _DIR_ . '/responses/',
        _DIR_ . '/classes/',
        _DIR_ . '/models/'
    ];
    
    foreach ($directories as $directory) {
        $file = $directory . $className . '.php';
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});

// Optional: Load Composer's autoloader if not already loaded in bootstrap.php
if (!class_exists('Composer\\Autoload\\ClassLoader', false)) {
    require _DIR_ . '/../vendor/autoload.php';
}