<?php
require '../vendor/autoload.php';
require_once('utils/rfc6238.php');
// Initialize the session
session_start();

$template = new Utils\View();
// validate user entries
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $UserModel = new Model\UserModel(new DataGateway\UsersTableDataGateway(new db()));
    $secretkey = $UserModel->get2FAtoken($_SESSION["username"])['twofatoken'];
    if (TokenAuth6238::verify($secretkey,$_POST['2faauth'])) {
        $_SESSION["2faauth"] = true;
        header("location: welcome.php");
        exit;
    } else {
        echo "Invalid code\n";
    }
}
$template->render('2faauth.phtml');
?>
