<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/controller/siswaController.php';

$controller = new SiswaController();
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'POST':
        if (isset($_GET['action']) && $_GET['action'] === 'update' && isset($_GET['nis'])) {
            header('Content-Type: application/json');
            echo $controller->update($_POST);
        }else{
            header('Content-Type: application/json');
            echo $controller->create($_POST);
        }
        break;

    case 'GET':
        if (isset($_GET['action']) && $_GET['action'] === 'getByNis' && isset($_GET['nis'])) {
            header('Content-Type: application/json');
            echo $controller->getByNis($_GET['nis']);
        }else{
            header('Content-Type: application/json');
            echo $controller->read();
        }
        break;

    case 'DELETE':
        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['nis'])) {
            header('Content-Type: application/json');
            echo $controller->delete($_GET['nis']);
        }
        break;
    
    default:
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Request method not supported']);
    break;
}