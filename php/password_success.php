<?php
require '../vendor/autoload.php';

$template = new Utils\View();
$UserModel = new Model\UserModel(new DataGateway\UsersTableDataGateway(new db()));

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['username']) && !empty($_POST['username']) AND isset($_POST['password']) && !empty($_POST['password']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        if ($UserModel->changePassword($hashed_password, $username)) {
            echo "Your password has been successfully changed!<br>";
            echo "<a href='/'>Click here to log in</a>";
        } else {
          echo "Error";
        }
    }
}
?>