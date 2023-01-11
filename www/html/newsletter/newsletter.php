<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

include '../db_config.php';

session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login_page.php");
}

$sql = "SELECT * FROM admin WHERE email='$email'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) == 0) {
    header("Location: login_page.php");
    exit;
}

if (isset($_POST['submit'])) {

    //get all emails from users table
    $sql = "SELECT email, firstname, lastname FROM users";
    $result = mysqli_query($conn, $sql);
    $emails = mysqli_fetch_all($result, MYSQLI_ASSOC);

    //get newsletter content
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
            $mail->Username   = 'carlokraken40@gmail.com';
            $mail->Password   = 'xnoejbhhbonxpotq';
            $mail->SMTPSecure = 'starttls';
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('newsletter', 'SmartMenu');
            $mail->addAddress($to['email'], '$to[firstname]  $to[lastname]');

            //Content
            $mail->isHTML(true);

            $mail->Subject = $subject;
            $mail->Body    = $content;

            if (!$mail->send()) {
                echo 'Email not sent an error was encountered: ' . $mail->ErrorInfo;
            } else {
                echo 'Message has been sent.';
            }

            $mail->smtpClose();

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
