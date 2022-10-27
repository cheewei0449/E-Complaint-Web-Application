<?php
// used to connect to the database
$host = "localhost";
$db_name = "eshop";
$username = "eshop";
$password = "uH60gKo*ynhl6/T!";
  
try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password); //PDO make connection to database
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // show error 
}  
// show error
catch(PDOException $exception){
    echo "Connection error: ".$exception->getMessage();
}
