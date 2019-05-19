<?php

$dsn="mysql:host=localhost;dbname=amit-php";
$username='root';
$pass= '';

try{
    $con=new PDO($dsn , $username , $pass);
    //echo  "you are connected";
}catch (PDOException $e){
    //echo  "connect failed".$e->getMessage();
}

