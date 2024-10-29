<?php 
require_once './config/config.php';
$user->logout();
header('location: login.php');