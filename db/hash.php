<?php
$pass = "admin";
$hash_pass = password_hash($pass, PASSWORD_DEFAULT);
echo $hash_pass;
?>