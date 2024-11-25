<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/controller/mapelcontroller.php';

$controller = new MapelControler();
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'POST':
        if (isset($_GET['action']) && $_GET['action'] === 'update' && isset($_GET['kode'])) {
            header('Content-Type: application/json');
            echo $controller->update($_POST);
        }else{
            header('Content-Type: application/json');
            echo $controller->create($_POST);
        }
        break;
    case 'GET':
        if (isset($_GET['action']) && $_GET['action'] === 'getByKode' && isset($_GET['kode'])) {
            header('Content-Type: application/json');
            echo $controller->getByKode($_GET['kode']);
        }else{
            header('Content-Type: application/json');
            echo $controller->read();
        }
        break;
    
    case 'DELETE':
        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['kode'])) {
            header('Content-Type: application/json');
            echo $controller->delete($_GET['kode']);
        }
        break;
        
    default:
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Request method not supported']);
    break;
}