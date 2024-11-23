jpgwapi.php

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/controller/jpgwcontroller.php';

$controller = new JPGWController();
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'POST':
        if (isset($_GET['action']) && $_GET['action'] === 'update' && isset($_GET['idJenis'])) {
            header('Content-Type: application/json');
            echo $controller->update($_POST);
        }else{
            header('Content-Type: application/json');
            echo $controller->create($_POST);
        }
        break;    
    
    case 'GET':
        if (isset($_GET['action']) && $_GET['action'] === 'getByIdJenis' && isset($_GET['idJenis'])) {
            header('Content-Type: application/json');
            echo $controller->getByIdJenis($_GET['idJenis']);
        }else{
            header('Content-Type: application/json');
            echo $controller->read();
        }
        break;
    
    case 'DELETE':
        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['idJenis'])) {
            header('Content-Type: application/json');
            echo $controller->delete($_GET['idJenis']);
        }
        break;
        
    default:
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Request method not supported']);
    break;
}
