<?php
include_once '../controler/ortucontroler.php';

$controller = new OrtuControler();
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'POST':
        if (isset($_GET['action']) && $_GET['action'] === 'update') {
            echo $controller->update($_POST);
        }else{
            echo $controller->create($_POST);
        }
        break;

    case 'GET':
        if (isset($_GET['action']) && $_GET['action'] === 'getByNik' && isset($_GET['nik'])) {
            echo $controller->getByNik($_GET['nik']);
        }else{
            echo $controller->read;
        }
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $deleteVars);
        echo $controller->delete($deleteVars);
        break;
    
    default:
        echo json_encode(["message" => "Request method not supported"]);
        break;
}