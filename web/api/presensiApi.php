<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/controller/presensicontroler.php';

$controller = new PresensiControler();
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'POST':
        if (isset($_GET['action']) && $_GET['action'] === 'AbsenMasuk') {
            header('Content-Type: application/json');
            echo $controller->create($_POST);
        }else if (isset($_GET['action']) && $_GET['action'] === 'AbsenPulang' ) {
            header('Content-Type: application/json');
            echo $controller->update($_POST);
        }else{  
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Request method not supported']);
        }
        break;

    case 'GET':
        header('Content-Type: application/json');
        echo json_decode($controller->getallpresensi($_GET['nis']));
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