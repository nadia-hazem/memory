<?php

function autoloader($className) {
    require_once 'lib/' . $className . '.php';
}

spl_autoload_register('autoloader');

?>