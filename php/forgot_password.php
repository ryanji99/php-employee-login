<?php
require '../vendor/autoload.php';

// Initialize the session
session_start();

$template = new Utils\View();
$template->render('forgot_password.phtml');
?>
