<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if(isset($_POST["btnSubmit"]) && $_POST["txtName"] != "" && $_POST["txtEmail"] != "" && $_POST["txtPhone"]  != "" && $_POST["txtMsg"] != ""){
    $mail = new PHPMailer(true);

    $mail-> isSMTP();
    $mail-> Host = 'smtp.gmail.com';
    $mail-> SMTPAuth = true;
    $mail-> Username = 'userc913@gmail.com';
    $mail-> Password = 'yimppyypjfoikydf';
    $mail-> SMTPSecure = "ssl";
    $mail-> Port = 465;

    $contact = 
    "<html>
    <head>
    </head>
    <body>
    <p>The email is:<br><b>{$_POST['txtEmail']}</b></p>
    <p> Name is:<br><b>{$_POST['txtName']}</b></p>
    <p>The phone is <br><b>{$_POST['txtPhone']}</b></p>
    <p>Message:<br><b>{$_POST['txtMsg']}</b></p>
    </body>
    </html>";

    $mail->setFrom('userc913@gmail.com');
    $mail->addAddress("userc913@gmail.com");
    $mail->isHTML(true);
    $mail->Subject = $_POST["txtEmail"];
    $mail->Body = $contact;

    $mail->send();

    header("Location: contact.php?message=mail_success");
} else {
    header("Location: contact.php?message=mail_empty");

}
