<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/controller/jadwalController.php';

$controller = new JadwalController();
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {

    case 'GET':
        if (isset($_GET['action']) && $_GET['action'] === 'getByIDKelas' && isset($_GET['id_kelas'])) {
            header('Content-Type: application/json');
            echo $controller->getByIDKelas($_GET['id_kelas']);
        }else{
            header('Content-Type: application/json');
            echo $controller->read();
        }
        break;

    default:
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Request method not supported']);
    break;
}