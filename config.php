<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);




$db_host = 'localhost'; 


$db_user = 'usrxdeng_Israel'; 


$db_pass = '0998433279Is@';   


$db_name = 'usrxdeng_muyayostim_db'; 


$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);


if ($conn->connect_error) {
    die("Error de Conexión a la Base de Datos: " . $conn->connect_error);
}


$conn->set_charset("utf8");

?>