<?php

define('APP_ROOT', __DIR__, false);
define('DS', DIRECTORY_SEPARATOR, false);
define('CLASS_ROOT', APP_ROOT . DS . 'Modules', false);
define('VIEW_ROOT', APP_ROOT. DS . 'view' . DS, false);

spl_autoload_register(function($class){
    
    if(strpos($class, 'NFSWeb') !== false){
        $class = str_replace('NFSWeb\\', '', $class);
        $path = CLASS_ROOT . DS . str_replace('\\', DS, $class) . '.php';
        if(file_exists($path)){
            include_once $path;
        }        
    }
});