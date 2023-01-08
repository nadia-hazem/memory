<?php
function my_autoloader($class_name) {
    $path = 'lib/';
    $extension = '.php';
    $full_path = $path . $class_name . $extension;

    if (file_exists($full_path)) {
        require_once $full_path;
    }
}

spl_autoload_register('my_autoloader');