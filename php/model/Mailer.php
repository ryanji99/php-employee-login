<?php
namespace Model;
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
Class Mailer extends Model
{
    private $userNamesubject = '[Company X] Your username request';
    private $passwordsubject = '[Company X] Password Reset Request';
    private $signupsubject = '[Company X] Please verify your email address.';


    public function sendMail($type, $html, $echostring, $email, $firstName = "DEFAULTFIRSTNAME", $hash = "DEFAULTHASH", $username="DEFAULTUSERNAME"){
        list('sender' => $sender,
            'senderName' => $senderName,
            'usernameSmtp' => $usernameSmtp,
            'passwordSmtp' => $passwordSmtp,
            'host' => $host,
            'port' => $port
            ) = \config::$config['mailerAuth'];
        // Replace recipient@example.com with a "To" address. If your account
        // is still in the sandbox, this address must be verified.
        $recipient = $email;
        // The subject line of the email
        $subject = $this->{$type."subject"};

        // The plain-text body of the email
        $bodyText = "";

        // The HTML-formatted body of the email
        $bodyHtml = $html;

        $mail = new PHPMailer(true);

        try
        {
            // Specify the SMTP settings.
            $mail->isSMTP();
            $mail->setFrom($sender, $senderName);
            $mail->Username = $usernameSmtp;
            $mail->Password = $passwordSmtp;
            $mail->Host = $host;
            $mail->Port = $port;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            //  $mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);

            // Specify the message recipients.
            $mail->addAddress($recipient);
            // You can also add CC, BCC, and additional To recipients here.

            // Specify the content of the message.
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $bodyHtml;
            $mail->AltBody = $bodyText;
            $mail->Send();
            echo $echostring;
     }
        catch
        (phpmailerException $e) {
            echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
        } catch (Exception $e) {
            echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
        }
    }
}
?>
