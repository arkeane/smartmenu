<?php
$row = mysqli_fetch_assoc($result);
$hash_pass = $row["password_hash"];


if (password_verify($pass, $hash_pass)) {
    $sql = "SELECT id FROM admin WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $id = $row["id"];

    $_SESSION["email"] = $email;
    $_SESSION["db_id"] = $id;
    $_SESSION["admin"] = true;

    header("Location: /newsletter/send_newsletter.php");
    exit;
} else {
    header("Location: login_page.php?error=wrongadminpassword");
    exit;
}
