<?php
require '../vendor/autoload.php';

// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect to login page
if(isset($_SESSION["2fa"]) && $_SESSION["2faauth"] != true) {
    header("location: 2faauth.php");
    exit;
}
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$template = new Utils\View();

$template->loginTimes = $_SESSION["logins"];
$template->firstName = $_SESSION["firstName"];
$template->lastName = $_SESSION["lastName"];

$template->render('welcome.phtml');
?>