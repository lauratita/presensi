<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/authortuModel.php';

class LoginOrtuService {
    private $loginModel;

    public function __construct($db) {
        $this->loginModel = new LoginOrtuModel($db);
    }

    public function getLogin($nikOrtu, $password) {
        return $this->loginModel->login($nikOrtu, $password);
    }

    private function isPlainTextPassword($password){
        return strlen($password) < 60;
    }

    public function getSiswaByOrtu($nikOrtu) {
        return $this->loginModel->getSiswaByNikOrtu($nikOrtu);
    }
}