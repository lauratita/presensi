<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/controller/authOrtuController.php';

$controller = new LoginOrtuController();
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'POST':
        if (isset($_GET['action']) && $_GET['action'] === 'login' && isset($_GET['nik_ortu'])){
            header('Content-Type: application/json');
        echo $controller->login($_POST);
        break;
        }
    
    default:
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Request method not supported']);
    break;
}
?>