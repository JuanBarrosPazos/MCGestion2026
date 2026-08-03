<?php

if(file_exists("../../Mod_Admin_Plus/Conections/conection.php")){
    require "../../Mod_Admin_Plus/Conections/conection.php";
} else {
    global $cero_conection;
    $cero_conection = 1;
    global $db_host;
    global $db_user;
    global $db_pass;
    global $db_name;
    $db_host = ''; 
    $db_user = ''; 
    $db_pass = ''; 
    $db_name = ''; 
}

?>