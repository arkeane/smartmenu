<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

include '../db_config.php';
include 'email_secrets.php';

session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login_page.php");
}

if(!isset($_SESSION["admin"])) {
    header("Location: login_page.php");
}

if (isset($_POST['submit'])) {



    //get all emails from users table
    $sql = "SELECT email, firstname, lastname FROM users";
    $result = mysqli_query($conn, $sql);
    $emails = mysqli_fetch_all($result, MYSQLI_ASSOC);

    //get newsletter content
    if(!isset($_POST['subject']) || !isset($_POST['content'])) {
        header("Location: send_newsletter.php?error=emptyfields");
        exit;
    }
    
    $subject = $_POST['subject'];
    $content = $_POST['content'];

    //send newsletter to all users
    foreach ($emails as $to) {
        try {
            //connect to gmail
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $gmail_email;
            $mail->Password   = $gmail_token;
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            //Recipients
            $mail->setFrom('newsletter@smartmenu.com', 'SmartMenu');
            $mail->addAddress($to['email'], ''. $to["firstname"] .' '. $to["lastname"] .'');

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $content;
            $mail->send();
            $mail->smtpClose();

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        header("Location: ../logout.php");
    }
}
