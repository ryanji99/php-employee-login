<?php
require '../vendor/autoload.php';

$template = new Utils\View();
$UserModel = new Model\UserModel(new DataGateway\UsersTableDataGateway(new db()));

if($_SERVER["REQUEST_METHOD"] == "GET") {
  if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']))
  {
    $email = $_GET['email'];
    $hash = $_GET['hash'];
    if ($UserModel->activateAccount($email, $hash)) {
      echo "Your account has been successfully activated!";
      echo "<br>";
      echo "<a href='/'>Click here to login</a>";
    } else {
      echo "This URL is either invalid or this account has already been activated";
    }
  }
}
?>