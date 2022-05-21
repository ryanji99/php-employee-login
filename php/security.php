<?php
require '../vendor/autoload.php';

$template = new Utils\View();
$UserModel = new Model\UserModel(new DataGateway\UsersTableDataGateway(new db()));

if($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['username']) && !empty($_GET['username']) and isset($_GET['hash']) && !empty($_GET['hash'])) {
        if ($row = $UserModel->validateEmailRequest($_GET['username'], $_GET['hash'])) {
            $template->q1 = $row['question1'];
            $template->q2 = $row['question2'];
            $template->render('security.phtml');
        }
    }
}
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['answer1']) && !empty($_POST['answer1']) and isset($_POST['answer2']) && !empty($_POST['answer2'])
        and isset($_POST['username']) && !empty($_POST['username'])) {
        $answer1 = $_POST['answer1'];
        $answer2 = $_POST['answer2'];
        $username = $_POST['username'];

        $template->username = $username;
        if ($row = $UserModel->validateSecurityQuestions($_POST['username'])) {
            if (sha1($answer1) != $row[0] || sha1($answer2) != $row[1])
                $template->flag = 1;
            else $template->flag = 0;
        }
        $template->render('security2.phtml');
    }
}
?>