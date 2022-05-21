<?php
require '../vendor/autoload.php';

// Initialize the session
session_start();
$_SESSION['errors'] = array();

// user variables
$first_name = $last_name = $email = $password = $confirm_password =  "";

$template = new Utils\View();

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $UserModel = new Model\UserModel(new DataGateway\UsersTableDataGateway(new db()));
    if($UserModel->registerAction()){
        // Redirect to login page
        header("location: registration_emailer.php");
        exit;
    }
}
$template->render('sign_up.phtml');
