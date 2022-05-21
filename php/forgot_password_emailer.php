<?php
    require '../vendor/autoload.php';
    $UserMailer = new Model\Mailer(new DataGateway\UsersTableDataGateway(new db()));
    $result = $UserMailer->findUserByUserName($_POST['username']);

    $firstname = $result['firstName'];
    $username = $_POST['username'];
    $hash =     $result['hash'];

    $html = "<p>Hi $firstname,</p>
               <br>
               <h4>We received your request to reset your password</h4>
               <br>
               <p>------------------------</p>
               <p>Please click the following link to reset your password:</p>
               <br>
               <a href='https://ec2-18-216-212-66.us-east-2.compute.amazonaws.com/php/security.php?username=$username&hash=$hash'>https://ec2-18-216-212-66.us-east-2.compute.amazonaws.com/php/security.php?username=$username&hash=$hash</a>
               <p>If you did not make this request, please contact us.</p>";
    $echostring = "<h3>An email with instructions on resetting your password has been sent to the email address associated with your account</h3>\r\n;
                   <h3>If you didn't get the email, check your spam folder or <a href='https://ec2-18-216-212-66.us-east-2.compute.amazonaws.com/php/forgot_password.php'>try again</a></h3>";


    $UserMailer->sendMail('password', $html, $echostring, $result['email'], $result['firstName'], $result['hash'], $_POST['username']);
?>
