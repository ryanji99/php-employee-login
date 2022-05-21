<?php
require '../vendor/autoload.php';
require_once('utils/rfc6238.php');
require_once 'config.php';
// Initialize the session
session_start();

$template = new Utils\View();

$UserModel = new Model\UserModel(new DataGateway\UsersTableDataGateway(new db()));
$secretkey = $UserModel->get2FAtoken($_SESSION["username"])['twofatoken'];
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if($UserModel->set2FA($_SESSION["username"])){
        // welcome page redirect
        header("location: welcome.php");
        exit;
    }
}

print sprintf('<img src="%s"/>',TokenAuth6238::getBarCodeUrl('','',$secretkey,'My%20App'));
$template->render('2fa.phtml');
?>