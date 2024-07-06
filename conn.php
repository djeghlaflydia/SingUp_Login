<?php
    $bd_server = "localhost";
    $bd_user = "root";
    $bd_pass = "";
    $bd_name = "database";
    $conn = "";

    try{
        $conn = mysqli_connect($bd_server, $bd_user, $bd_pass, $bd_name);
    }catch(mysqli_sql_exception){
        echo"Error connecting to database";
    } 
?>