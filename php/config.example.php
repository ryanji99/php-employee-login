<?php
// Change my name to "config.php"
class config
{
    public static $config = [
        'databaseAuth' => [
            'address' => 'YOUR_ADDRESS',
            'mysqlusername' => 'YOUR_USERNAME',
            'password' => 'YOUR_PASSWORD',
            'databaseName' => 'YOUR_DATABASE',
        ],
        'mailerAuth' => [
            'sender' => 'SENDER_EMAIL',
            'senderName' => 'SENDER_NAME',
            'usernameSmtp' => 'USERNAME_SMTP',
            'passwordSmtp' => 'PASSWORD_SMTP',
            'host' => 'HOST',
            'port' => 'PORT'
        ],
        'reCaptcha-sitekey' => 'RECAPTCHA_SITE_KEY',
        'reCaptcha-secret' => 'RECAPTCHA_SECRET',
    ];
}
