<?php
    require '../vendor/autoload.php';
    $UserMailer = new Model\Mailer(new DataGateway\UsersTableDataGateway(new db()));
    $result = $UserMailer->findUserByEmail($_POST['email']);

    $firstName = $result['firstName'];
    $username = $result['username'];

  $html = "<p>Hi $firstName,</p>
               <br>
               <h4>We received your username request</h4>
               <br>
               <p>------------------------</p>
               <p>Username: $username</p>
               <br>
               <p>If you did not make this request, please contact us.</p>";
    $echostring = "<h3>Your username request has been sent </h3>\r\n
            <h3>If you didn't get the email, check your spam folder or <a href='https://ec2-18-216-212-66.us-east-2.compute.amazonaws.com/php/forgot_user.php'>try again</a>. We sent an email to $email</h3>";


    $UserMailer->sendMail('userName',$html, $echostring, $_POST['email'], $result['firstName'], null, $result['username'])
?>
