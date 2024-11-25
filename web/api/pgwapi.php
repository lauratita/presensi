<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/controller/pgwcontroller.php';

$controller = new PegawaiController();
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'POST':
        if (isset($_GET['action']) && $_GET['action'] === 'update' && isset($_GET['nik'])) {
            header('Content-Type: application/json');
            echo $controller->update($_POST);
        }else{
            header('Content-Type: application/json');
            echo $controller->create($_POST);
        }
        break;

    case 'GET':
        if (isset($_GET['action']) && $_GET['action'] === 'getByNikp' && isset($_GET['nik'])) {
            header('Content-Type: application/json');
            echo $controller->getByKode($_GET['nik']);
        }else{
            header('Content-Type: application/json');
            echo $controller->read();
        }
        break;
    
    case 'DELETE':
        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['nik'])) {
            header('Content-Type: application/json');
            echo $controller->delete($_GET['nik']);
        }
        break;
        
    default:
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Request method not supported']);
    break;
}