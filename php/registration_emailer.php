<?php
    require '../vendor/autoload.php';
    session_start();
    $UserMailer = new Model\Mailer(new DataGateway\UsersTableDataGateway(new db()));

    $email =     $_SESSION['email'];
    $firstName = $_SESSION['firstName'];
    $hash =      $_SESSION['hash'];

     $html = "<p>Almost done $firstName! To complete your Company X sign up,
                  we just need to verify your email address:</p>
               <br>
               <a href='mailto:$email'>$email</a>
               <p>------------------------</p>
               <p>Please click this link to activate your account:</p>
               <br>
               <a href='https://ec2-18-216-212-66.us-east-2.compute.amazonaws.com/php/registration_success.php?email=$email&hash=$hash'>https://ec2-18-216-212-66.us-east-2.compute.amazonaws.com/php/verify.php?email=$email&hash=$hash</a>";
     $echostring = "<h3>A verification link has been sent to your email account</h3>\r\n
                            <h3>Please click on the link that has just been sent to your email account to verify your email and continue the registration process.</h3>";


$UserMailer->sendMail('signup',$html, $echostring, $_SESSION['email']);
?>