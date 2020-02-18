<?php
define("BASE_URL", $_SERVER['DOCUMENT_ROOT'].'/task-management-v0/backend/app/');
//define("LOG_FAJL", BASE_URL."/data/log.txt");
define("ENV_FAJL", BASE_URL."/config/.env");
//define("ERROR_FILE", BASE_URL."/data/errors.txt");
define("SERVER", "localhost");
define("DATABASE", env("DATABASE"));
define("USERNAME", env("USERNAME"));
define("PASSWORD", env("PASSWORD"));


function env($param){
    $file = file(BASE_URL . "Config/.env");

    $value = "";

    foreach($file as $row){
        $data = explode("=", trim($row));
        if($param == $data[0]){
            $value = $data[1];
        }
    }
    return $value;

}