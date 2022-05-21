<?php
require '../vendor/autoload.php';

// Initialize the session
session_start();
$_SESSION['errors'] = array();

if(isset($_SESSION["2fa"]) && $_SESSION["2faauth"] != true) {
    header("location: 2faauth.php");
    exit;
}
// Check if the user is already logged in, if true move to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}


$template = new Utils\View();
// validate user entries
if($_SERVER["REQUEST_METHOD"] == "POST"){    
    $UserModel = new Model\UserModel(new DataGateway\UsersTableDataGateway(new db()));
    if($UserModel->loginAction()){
       // welcome page redirect
        if (isset($_SESSION["2fa"]) && $_SESSION["2fa"] === 1) {
            header("location: 2faauth.php");
        }
        else {
            header("location: welcome.php");
        }
        exit;
    }
}
$template->render('login.phtml');
