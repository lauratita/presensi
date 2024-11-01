<?php 
use Web\Auth;

try {
    $con = new PDO('mysql:host=localhost;dbname=db_presensicekinout', 'root', '', array(PDO::ATTR_PERSISTENT => true));
} catch (PDOException $e){
    echo $e->getMessage();
}

include_once __DIR__ . '/../auth/Auth.php';
$user = new Auth($con);