<?php
// used to connect to the database
$host = "sql201.epizy.com";
$db_name = "epiz_33245164_eshop";
$username1 = "epiz_33245164";
$password1 = "DMj75fJVplRQkGt";
  
try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username1, $password1); //PDO make connection to database
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // show error 
}  
// show error
catch(PDOException $exception){
    echo "Connection error: ".$exception->getMessage();
}