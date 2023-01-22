<?php
$row = mysqli_fetch_assoc($result);
$hash_pass = $row["password_hash"];

if (password_verify($pass, $hash_pass)) {
    $sql = mysqli_prepare($conn, "SELECT id FROM admin WHERE email=?");
    mysqli_stmt_bind_param($sql, "s", $email);
    mysqli_stmt_execute($sql);
    $result = mysqli_stmt_get_result($sql);
    $row = mysqli_fetch_assoc($result);
    $id = $row["id"];

    $_SESSION["email"] = $email;
    $_SESSION["db_id"] = $id;
    $_SESSION["admin"] = true;

    header("Location: newsletter/send_newsletter.php");
    exit;
} else {
    header("Location: login_page.php?error=wrongadminpassword");
    exit;
}
