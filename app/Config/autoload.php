<?php
spl_autoload_register(function($path){
    // App\Config\DB
    // app/Config/DB.php
    // app\Config\DB.php
    $path = str_replace("\\", DIRECTORY_SEPARATOR, $path);
    $path[0] = strtolower($path[0]);
    // echo $putanja;
    $path .= ".php";
    require_once $path;
});